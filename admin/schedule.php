<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Availability and Booking Calendar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .available-day {
            background-color: #2563eb; /* Tailwind's blue-600 */
            color: white;
        }

        .available-slot {
            background-color: #2563eb; /* Tailwind's blue-600 */
            color: white;
            cursor: pointer;
            border-radius: 8px;
        }

        .default-slot {
            background-color: white;
            border: 1px solid #d1d5db;
            color: black;
            cursor: pointer;
            border-radius: 8px;
        }

        .booked-slot {
            background-color: #e5e7eb; /* Tailwind's gray-200 */
            color: #9ca3af; /* Tailwind's gray-400 */
            cursor: not-allowed;
            border-radius: 8px;
        }

        .disabled-day {
            background-color: #d1d5db; /* Tailwind's gray-300 */
            color: #9ca3af; /* Tailwind's gray-400 */
            cursor: not-allowed;
        }

        .day-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .scroll-btn {
            background-color: #4f46e5; /* Tailwind's indigo-600 */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: bold;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .scroll-btn:hover {
            transform: scale(1.05);
            background-color: #3730a3; /* Tailwind's indigo-800 */
        }

        .time-slot {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            text-align: center;
            border: 1px solid #d1d5db; /* Tailwind's gray-300 */
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
            display: inline-block;
            margin: 0.25rem;
        }

        .time-slot:hover {
            transform: scale(1.05);
        }

        /* Additional button styling */
        .btn-primary {
            background-color: #2563eb; /* Tailwind's blue-600 */
            color: white;
            padding: 0.75rem 1.5rem;
            font-weight: bold;
            border-radius: 25px;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #1d4ed8; /* Tailwind's blue-700 */
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col items-center justify-center">

    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 w-full">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-lg font-semibold text-white">
                Admin Dashboard
            </div>
            <ul class="flex space-x-6 text-white">
                <li><a href="index.php" class="hover:text-blue-400">Home</a></li>
                <li><a href="schedule.php" class="hover:text-blue-400">Schedule</a></li>
                <li><a href="bookings.php" class="hover:text-blue-400">Bookings</a></li>
            </ul>
        </div>
    </nav>

    <div class="bg-gray-800 shadow-lg rounded-lg p-10 w-full lg:w-[800px] mx-auto mt-8"> <!-- Dark theme -->
        <h2 class="text-3xl font-semibold text-white mb-6 text-center">Manage Your Availabilities and Bookings</h2>

        <!-- Month Navigation -->
        <div class="flex justify-between items-center mb-6">
            <button id="prevMonth" class="scroll-btn">
                &larr;
            </button>
            <h2 id="currentMonth" class="text-xl font-semibold text-white"></h2>
            <button id="nextMonth" class="scroll-btn">
                &rarr;
            </button>
        </div>

        <!-- Calendar Section -->
        <div class="grid grid-cols-7 gap-4 justify-center mb-6 mx-auto">
            <div class="text-center font-semibold text-gray-300">Mon</div>
            <div class="text-center font-semibold text-gray-300">Tue</div>
            <div class="text-center font-semibold text-gray-300">Wed</div>
            <div class="text-center font-semibold text-gray-300">Thu</div>
            <div class="text-center font-semibold text-gray-300">Fri</div>
            <div class="text-center font-semibold text-gray-300">Sat</div>
            <div class="text-center font-semibold text-gray-300">Sun</div>
        </div>

        <div class="grid grid-cols-7 gap-4 justify-center mb-10 mx-auto" id="calendar">
            <!-- Calendar days will be dynamically created here -->
        </div>

        <!-- Time Slots for the Selected Day -->
        <div class="bg-gray-700 shadow-md rounded-lg p-6 w-full text-center mx-auto">
            <h2 id="selectedDay" class="text-lg font-semibold text-white mb-6">Select a day</h2>

            <div id="timeSlots" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 justify-center mx-auto">
                <!-- Time slots will be dynamically created here -->
            </div>

            <div class="flex justify-center mt-6">
                <button onclick="saveAvailability()" class="btn-primary">
                    Save Availability
                </button>
            </div>
        </div>
    </div>

    <script>
        // Your existing JavaScript code for calendar and time slot management
        let currentMonthIndex = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let availabilities = {};
        let bookedSlots = {};
        const today = new Date();

        if (localStorage.getItem("availabilities")) {
            availabilities = JSON.parse(localStorage.getItem("availabilities"));
        }

        const generateTimeSlots = () => {
            let slots = [];
            for (let hour = 9; hour < 20; hour++) {
                const nextHour = hour + 1;
                const startTime = hour < 12 ? `${hour.toString().padStart(2, '0')}:00 AM` : `${(hour - 12).toString().padStart(2, '0')}:00 PM`;
                const endTime = nextHour < 12 ? `${nextHour.toString().padStart(2, '0')}:00 AM` : (nextHour === 12 ? `12:00 PM` : `${(nextHour - 12).toString().padStart(2, '0')}:00 PM`);
                slots.push(`${startTime} - ${endTime}`);
            }
            return slots;
        };

        function loadCalendar(month, year) {
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDayIndex = new Date(year, month, 1).getDay();
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';

            const adjustedFirstDayIndex = (firstDayIndex === 0 ? 6 : firstDayIndex - 1);

            for (let i = 0; i < adjustedFirstDayIndex; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('p-4');
                calendar.appendChild(emptyDay);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('p-4', 'day-circle', 'border', 'cursor-pointer', 'mx-auto', 'text-center');
                dayDiv.id = `day${day}-${month}-${year}`;
                dayDiv.innerText = day;

                const currentDay = new Date(year, month, day);

                if (currentDay < today) {
                    dayDiv.classList.add('disabled-day');
                } else {
                    dayDiv.onclick = () => selectDay(day, month, year);
                    const formattedDate = `${day.toString().padStart(2, '0')}-${(month + 1).toString().padStart(2, '0')}-${year}`;
                    if (availabilities[formattedDate]) {
                        dayDiv.classList.add('available-day');
                    }
                }

                calendar.appendChild(dayDiv);
            }
        }

        function selectDay(day, month, year) {
            const formattedDay = day.toString().padStart(2, '0');
            const formattedMonth = (month + 1).toString().padStart(2, '0');
            const selectedDay = `${formattedDay}-${formattedMonth}-${year}`;
            document.getElementById('selectedDay').innerText = `Manage Time Slots for ${formattedDay}/${formattedMonth}/${year}`;
            document.getElementById('selectedDay').dataset.day = selectedDay;

            loadTimeSlots(selectedDay);
        }

        function loadTimeSlots(day) {
            const timeSlotsContainer = document.getElementById('timeSlots');
            timeSlotsContainer.innerHTML = '';

            const timeSlots = generateTimeSlots();

            timeSlots.forEach(time => {
                const slotDiv = document.createElement('div');
                slotDiv.classList.add('time-slot', 'default-slot', 'mx-auto');
                slotDiv.innerText = time;

                if (bookedSlots[day] && bookedSlots[day].includes(time)) {
                    slotDiv.classList.remove('default-slot');
                    slotDiv.classList.add('available-slot');
                }

                slotDiv.onclick = () => toggleBooking(day, time, slotDiv);
                timeSlotsContainer.appendChild(slotDiv);
            });
        }

        function toggleBooking(day, time, slotDiv) {
            if (!bookedSlots[day]) {
                bookedSlots[day] = [];
            }

            if (bookedSlots[day].includes(time)) {
                bookedSlots[day] = bookedSlots[day].filter(t => t !== time);
                slotDiv.classList.remove('available-slot');
                slotDiv.classList.add('default-slot');
            } else {
                bookedSlots[day].push(time);
                slotDiv.classList.remove('default-slot');
                slotDiv.classList.add('available-slot');
            }

            if (bookedSlots[day].length > 0) {
                document.getElementById(`day${parseInt(day.split('-')[0])}-${currentMonthIndex}-${currentYear}`).classList.add('available-day');
                availabilities[day] = bookedSlots[day];
            } else {
                delete availabilities[day];
                document.getElementById(`day${parseInt(day.split('-')[0])}-${currentMonthIndex}-${currentYear}`).classList.remove('available-day');
            }

            localStorage.setItem("availabilities", JSON.stringify(availabilities));
        }

        function saveAvailability() {
            const selectedDay = document.getElementById('selectedDay').dataset.day;
            const timeSlots = bookedSlots[selectedDay] || [];

            if (timeSlots.length > 0) {
                document.getElementById(`day${parseInt(selectedDay.split('-')[0])}-${currentMonthIndex}-${currentYear}`).classList.add('available-day');
                availabilities[selectedDay] = timeSlots;
            } else {
                if (availabilities[selectedDay]) {
                    document.getElementById(`day${parseInt(selectedDay.split('-')[0])}-${currentMonthIndex}-${currentYear}`).classList.add('available-day');
                } else {
                    document.getElementById(`day${parseInt(selectedDay.split('-')[0])}-${currentMonthIndex}-${currentYear}`).classList.remove('available-day');
                }
            }

            localStorage.setItem("availabilities", JSON.stringify(availabilities));
        }

        function updateMonthDisplay() {
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            document.getElementById('currentMonth').innerText = `${monthNames[currentMonthIndex]} ${currentYear}`;
        }

        document.getElementById('prevMonth').onclick = () => {
            if (currentMonthIndex === 0) {
                currentMonthIndex = 11;
                currentYear--;
            } else {
                currentMonthIndex--;
            }
            loadCalendar(currentMonthIndex, currentYear);
            updateMonthDisplay();
        };

        document.getElementById('nextMonth').onclick = () => {
            if (currentMonthIndex === 11) {
                currentMonthIndex = 0;
                currentYear++;
            } else {
                currentMonthIndex++;
            }
            loadCalendar(currentMonthIndex, currentYear);
            updateMonthDisplay();
        };

        loadCalendar(currentMonthIndex, currentYear);
        updateMonthDisplay();
    </script>
</body>
</html>
