<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the database configuration
include('../includes/config.php');

// Get the number of users to show per page
$usersPerPage = isset($_GET['usersPerPage']) ? (int)$_GET['usersPerPage'] : 5;

// Get the current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Get the selected status filter
$filterStatus = isset($_GET['filterStatus']) ? $_GET['filterStatus'] : 'all';

// Get the selected date filter
$filterDate = isset($_GET['filterDate']) ? $_GET['filterDate'] : '';

// Calculate the offset for the SQL query
$offset = ($page - 1) * $usersPerPage;

// Build the SQL query based on the selected filters
$sql = "SELECT * FROM tickets WHERE 1=1";
$params = [];
$types = "";

// Add status filter if selected
if ($filterStatus !== 'all') {
    $sql .= " AND status = ?";
    $params[] = $filterStatus;
    $types .= "s";
}

// Add date filter if selected
if (!empty($filterDate)) {
    $sql .= " AND submission_date = ?";
    $params[] = $filterDate;
    $types .= "s";
}

$sql .= " LIMIT ? OFFSET ?";
$params[] = $usersPerPage;
$params[] = $offset;
$types .= "ii";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch the total number of tickets for pagination
$countSql = "SELECT COUNT(*) AS total FROM tickets WHERE 1=1";
$countParams = [];
$countTypes = "";

// Add status filter for count query
if ($filterStatus !== 'all') {
    $countSql .= " AND status = ?";
    $countParams[] = $filterStatus;
    $countTypes .= "s";
}

// Add date filter for count query
if (!empty($filterDate)) {
    $countSql .= " AND submission_date = ?";
    $countParams[] = $filterDate;
    $countTypes .= "s";
}

$countStmt = $conn->prepare($countSql);

if (!empty($countTypes)) {
    $countStmt->bind_param($countTypes, ...$countParams);
}

$countStmt->execute();
$countResult = $countStmt->get_result();
$totalTickets = $countResult->fetch_assoc()['total'];

// Calculate the total number of pages
$totalPages = ceil($totalTickets / $usersPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white">

    <!-- Header with Logout Button -->
    <div class="flex justify-between items-center p-6 bg-gray-800">
        <h1 class="text-3xl font-semibold text-white">Admin Dashboard</h1>
        <button onclick="logout()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Logout
        </button>
    </div>

    <!-- Main Container -->
    <div class="container mx-auto p-6">

        <!-- Filter and Display Options Section -->
        <form method="GET" class="w-full mb-6 flex justify-between items-center">
            <div class="flex space-x-4">
                <div>
                    <label for="filterDate" class="block text-sm font-medium text-white mb-2">Filter by Submission Date:</label>
                    <div class="flex items-center">
                        <input type="date" id="filterDate" name="filterDate" value="<?php echo htmlspecialchars($filterDate); ?>" class="bg-gray-700 text-white px-3 py-2 rounded focus:outline-none" />
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-3">Filter</button>
                    </div>
                </div>
                <div>
                    <label for="filterStatus" class="block text-sm font-medium text-white mb-2">Filter by Status:</label>
                    <select id="filterStatus" name="filterStatus" class="bg-gray-700 text-white px-3 py-2 rounded focus:outline-none" onchange="this.form.submit()">
                        <option value="all" <?php if ($filterStatus == 'all') echo 'selected'; ?>>All</option>
                        <option value="pending" <?php if ($filterStatus == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="in-progress" <?php if ($filterStatus == 'in-progress') echo 'selected'; ?>>In Progress</option>
                        <option value="completed" <?php if ($filterStatus == 'completed') echo 'selected'; ?>>Completed</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="usersPerPage" class="block text-sm font-medium text-white mb-2">Show per page:</label>
                <select id="usersPerPage" name="usersPerPage" class="bg-gray-700 text-white px-3 py-2 rounded focus:outline-none" onchange="this.form.submit()">
                    <option value="5" <?php if ($usersPerPage == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if ($usersPerPage == 10) echo 'selected'; ?>>10</option>
                    <option value="20" <?php if ($usersPerPage == 20) echo 'selected'; ?>>20</option>
                </select>
            </div>
        </form>

        <!-- User Tickets Section -->
        <div class="w-full mb-6">
            <h2 class="text-2xl font-semibold mb-6 text-white text-center">User Submitted Tickets</h2>
            <div class="overflow-x-auto">
                <table class="table-auto bg-gray-800 text-white rounded-lg shadow w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Phone Number</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Request</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Submission Date</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ticketsTableBody">
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr class='border-b border-gray-700'>";
                                echo "<td class='px-4 py-3'>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td class='px-4 py-3'>" . htmlspecialchars($row['phone']) . "</td>";
                                echo "<td class='px-4 py-3'>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td class='px-4 py-3'>";
                                echo "<span>" . htmlspecialchars(substr($row['request'], 0, 20)) . "...</span>";
                                echo "<button class='text-blue-500 ml-2 focus:outline-none' onclick=\"openModal('request" . $row['id'] . "')\">See More</button>";
                                echo "<span id='request" . $row['id'] . "' class='hidden'>" . htmlspecialchars($row['request']) . "</span>";
                                echo "</td>";
                                echo "<td class='px-4 py-3'>";
                                echo "<select class='status-select bg-gray-700 text-white text-xs font-semibold px-2 py-1 rounded focus:outline-none' onchange=\"saveStatus(" . $row['id'] . ", this.value)\">";
                                echo "<option value='pending'" . ($row['status'] == "pending" ? " selected" : "") . ">Pending</option>";
                                echo "<option value='in-progress'" . ($row['status'] == "in-progress" ? " selected" : "") . ">In Progress</option>";
                                echo "<option value='completed'" . ($row['status'] == "completed" ? " selected" : "") . ">Completed</option>";
                                echo "</select>";
                                echo "</td>";
                                echo "<td class='px-4 py-3'>" . htmlspecialchars($row['submission_date']) . "</td>";
                                echo "<td class='px-4 py-3'>";
                                echo "<form method='POST' action='delete_ticket.php' style='display:inline;'>";
                                echo "<input type='hidden' name='ticket_id' value='" . $row['id'] . "' />";
                                echo "<button type='submit' class='bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs'>Delete</button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='px-4 py-3 text-center'>No tickets found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="pagination mt-4 text-center">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='index.php?page=$i&usersPerPage=$usersPerPage&filterStatus=$filterStatus&filterDate=$filterDate' class='px-3 py-1 mx-1 rounded " . ($i == $page ? "bg-blue-700" : "bg-gray-700") . " text-white'>$i</a>";
                }
                ?>
            </div>
        </div>

    </div>

    <!-- Modal Structure -->
    <div id="requestModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-lg w-full text-white">
            <h3 class="text-xl font-semibold mb-4">Full Request</h3>
            <p id="modalRequestText" class="mb-6"></p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        function logout() {
            window.location.href = 'logout.php';
        }

        function openModal(requestId) {
            const requestText = document.getElementById(requestId).innerText;
            document.getElementById('modalRequestText').innerText = requestText;
            document.getElementById('requestModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('requestModal').classList.add('hidden');
        }

        function saveStatus(ticketId, status) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "save_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Status updated successfully");
                }
            };
            xhr.send("ticket_id=" + ticketId + "&status=" + status);
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>
