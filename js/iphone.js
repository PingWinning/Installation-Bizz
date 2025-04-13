const messages = [
    { text: "👋 Hey, hope you're doing well!", type: "received", delay: 1500 },
    { text: "Hey! I’m doing great, how about you? 😄", type: "sent", delay: 1500 },
    { text: "Doing great! I wanted to share an <span class='text-green-400 font-semibold'>opportunity</span> with you that might interest you.", type: "received", delay: 2500 },
    { text: "I’m listening! What’s it about?", type: "sent", delay: 1500 },
    { text: "We’re expanding our team at <span class='text-green-400 font-semibold'>QuickFix Brothers</span> Montreal & Laval’s trusted experts for moving, furniture assembly, and handyman services. 🏠🔧", type: "received", delay: 3000 },
    { text: "Sounds interesting! What’s the opportunity?", type: "sent", delay: 1200 },
    { text: "We’re launching an <span class='text-green-400 font-semibold'>Affiliate&nbsp;Program</span> where you can <span class='text-green-400 font-semibold'>earn money by referring customers</span> to our services. No experience needed, just connect people with us and <span class='text-green-400 font-semibold'>get paid!</span>", type: "received", delay: 3000 },
    { text: "Okay, how does it work?", type: "sent", delay: 1500 },
    { text: "<span class='text-green-400 font-semibold'>It's simple:</span><br>✅ Help a friend move!<br>✅ They they book with us!<br>✅ <span class='text-green-400 font-semibold'>You earn a payout! 💸</span>", type: "received", delay: 2500 },
    { text: "That sounds great! How much can I earn?", type: "sent", delay: 2500 },
    { text: "<span class='text-green-400 font-semibold'>Here’s what you can make:</span><br>✅ <span class='text-green-400 font-semibold'>$120</span> for small moves<br>✅ <span class='text-green-400 font-semibold'>$200</span> for bigger moves<br>✅ <span class='text-green-400 font-semibold'>$250</span> for moves outside the city.📍🌍<br>✅ <span class='text-green-400 font-semibold'>10% commission</span> on handyman services 🏡", type: "received", delay: 3000 },
    { text: "That’s solid! So, I just send people your way, and once they book, I get paid?", type: "sent", delay: 2000 },
    { text: "Exactly! Plus, you can do this from <span class='text-green-400 font-semibold'>anywhere in the world</span>. 🌍", type: "received", delay: 2000 },
    { text: "We provide everything you need to <span class='text-green-400 font-semibold'>succeed</span>. It’s a win-win!&nbsp;📈", type: "received", delay: 2500 },
    { text: "I like the sound of that! How do I get started?", type: "sent", delay: 2000 },
    { text: "<span class='text-green-400 font-semibold'>Let’s get you onboarded!</span><br>Sign up today and be part of the movement. 🚀", type: "received", delay: 2000 }
];


const chatBox = document.getElementById("chatBox");

function showTypingIndicator(type, callback) {
    let typingDiv = document.createElement("div");
    typingDiv.classList.add("typing-indicator", type);
    typingDiv.innerHTML = "<span></span><span></span><span></span>";
    chatBox.appendChild(typingDiv);
    chatBox.scrollTop = chatBox.scrollHeight;
    setTimeout(() => {
        chatBox.removeChild(typingDiv);
        callback();
    }, 2000);
}

function displayMessages(index = 0) {
    if (index >= messages.length) return;
    
    showTypingIndicator(messages[index].type, () => {
        let msg = messages[index];
        let messageDiv = document.createElement("div");
        messageDiv.classList.add("chat-message", msg.type);
        messageDiv.innerHTML = msg.text;
        chatBox.appendChild(messageDiv);
        chatBox.scrollTop = chatBox.scrollHeight;
        setTimeout(() => displayMessages(index + 1), msg.delay);
    });
}

displayMessages();


let balance = 0;
const balanceElement = document.getElementById("balance");
const transactionsContainer = document.getElementById("transactions");

const transactions = [
    { client: "Nathan Harrington", amount: 200 },
    { client: "Sarah Lee", amount: 120 },
    { client: "Michael King", amount: 250 },
    { client: "Emily Thompson", amount: 200 },
    { client: "Chris White", amount: 200 },
    { client: "Liam Montgomery", amount: 300 },
    { client: "Élodie Moreau", amount: 250 },
    { client: "Théo Dufresne", amount: 200 },
    { client: "Camille Fontaine", amount: 120 },
    { client: "Mason Whitaker", amount: 400 },
    { client: "Noah Holloway", amount: 250 },
    { client: "Ethan Chambers", amount: 150 },
    { client: "Caleb Preston", amount: 350 },
    { client: "Owen Kensington", amount: 400 },
    { client: "Lucas Lancaster", amount: 200 },
    { client: "Julian Ellington", amount: 300 },
    { client: "Isaac Winchester", amount: 200 },
    { client: "Sophia Bennett", amount: 250 },
    { client: "Ava Calloway", amount: 400 },
    { client: "Isabella Covington", amount: 150 },
    { client: "Mia Fitzgerald", amount: 200 },
    { client: "Amelia Hastings", amount: 350 },
    { client: "Harper Kensington", amount: 400 },
    { client: "Andrei Popescu", amount: 200 },
    { client: "Ioana Marinescu", amount: 250 },
    { client: "Elena Dragomir", amount: 120 },
    { client: "Evelyn Remington", amount: 250 },
    { client: "Abigail Sterling", amount: 200 },
    { client: "Scarlett Thatcher", amount: 300 },
    { client: "Giulia Bianchi", amount: 250 },
    { client: "Marco De Luca", amount: 200 },
    { client: "Alessia Romano", amount: 120 },
    { client: "Lily Westwood", amount: 400 },
    { client: "Celeste Montclair", amount: 250 },
    { client: "Cassian Blackwood", amount: 250 },
    { client: "Amina El-Sayed", amount: 250 },
    { client: "Mateo Ruiz", amount: 120 },
    { client: "Sofia Di Laurentis", amount: 200 },
    { client: "Takumi Yamamoto", amount: 250 },
    { client: "Leila Ben Arfa", amount: 200 },
    { client: "Nico Meier", amount: 250 },
    { client: "Clara Vögeli", amount: 200 },
    { client: "Sandro Bernardi", amount: 120 },
    { client: "Jonas Bergström", amount: 120 },
    { client: "Ananya Mehta", amount: 250 },
    { client: "Luca Romano", amount: 200 },
    { client: "Zara Khalid", amount: 200 },
    { client: "Kalina Stoyanova", amount: 200 },
    { client: "Thiago Mendes", amount: 120 },
    { client: "Chiara Bianchi", amount: 250 },
    { client: "Yara Daoud", amount: 200 },
    { client: "Noor Rahman", amount: 120 },
    { client: "Niko Petrov", amount: 200 },
    { client: "Élodie Marchand", amount: 250 },
    { client: "Ibrahim Al-Fulan", amount: 200 },
    { client: "Lucía Fernández", amount: 120 },
    { client: "Fatima Zahra", amount: 250 },
    { client: "Dimitar Petrov", amount: 250 },
    { client: "Nikolay Ivanov", amount: 250 },
    { client: "Dmitri Volkov", amount: 200 },
    { client: "Mei Lin Zhang", amount: 250 },
    { client: "Jasmine Delacroix", amount: 200 },
    { client: "Lucía Márquez", amount: 200 },
    { client: "Diego Castillo", amount: 250 },
    { client: "Carmen Rivas", amount: 200 },
    { client: "Evander Holt", amount: 120 },
    { client: "Aurora Kingsley", amount: 250 },
    { client: "Andrei Popescu", amount: 200 },
    { client: "Ioana Marinescu", amount: 250 },
    { client: "Elena Dragomir", amount: 120 },
    { client: "Silas Whitmore", amount: 200 },
    { client: "Vera Lockwood", amount: 250 },
    { client: "Alaric Vaughn", amount: 200 },
    { client: "Odessa Langford", amount: 250 },
    { client: "Dorian Graves", amount: 120 },
    { client: "Isadora Wren", amount: 200 },
    { client: "Leander Fox", amount: 120 },
    { client: "Bianca Rosenthal", amount: 200 },
    { client: "Maxim Thorne", amount: 200 },
    { client: "Noelle Ashbourne", amount: 200 },
    { client: "Lukas Schneider", amount: 200 },
    { client: "Anika Vogel", amount: 250 },
    { client: "Matthias Bauer", amount: 120 },
    { client: "Lucien Drake", amount: 250 },
    { client: "Giselle Fairbanks", amount: 250 },
    { client: "Bastian Crowley", amount: 120 },
    { client: "Seraphina Caldwell", amount: 200 },
    { client: "Soren Ashford", amount: 250 },
    { client: "Maxence Devereaux", amount: 300 },
    { client: "Isabeau Montclair", amount: 220 },
    { client: "Thierry Beaumont", amount: 275 },
    { client: "Celeste Duval", amount: 310 },
    { client: "Etienne Laforge", amount: 260 },
    { client: "Anastasia Marceau", amount: 240 },
    { client: "Lysandre Chevalier", amount: 290 },
    { client: "Victoire Lemoine", amount: 230 },
    { client: "Guillaume Marchand", amount: 280 },
    { client: "Isabelle Montclair", amount: 220 },
    { client: "Arielle Saint-Laurent", amount: 320 }
];

function animateBalance(newBalance) {
    let startBalance = balance; // Toujours partir de la dernière valeur réelle
    let currentBalance = startBalance;
    let step = (newBalance - startBalance) / 40; // Animation en 40 étapes pour plus de fluidité

    function update() {
        currentBalance += step;
        if ((step > 0 && currentBalance >= newBalance) || (step < 0 && currentBalance <= newBalance)) {
            currentBalance = newBalance;
            balanceElement.innerText = `$${currentBalance.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            return;
        }
        balanceElement.innerText = `$${currentBalance.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        requestAnimationFrame(update);
    }

    update();
}

function showTransaction(index = 0) {
    if (index >= transactions.length) return;

    const { client, amount } = transactions[index];
    const transactionDiv = document.createElement("div");
    transactionDiv.classList.add("transaction-item");
    transactionDiv.innerHTML = `You received <span class="amount">$${amount.toLocaleString()}</span> from <strong>QuickFix Brothers</strong> for client <strong>${client}</strong>`;
    transactionsContainer.prepend(transactionDiv);

    setTimeout(() => {
        transactionDiv.style.opacity = "1";
        transactionDiv.style.transform = "translateY(0)";
    }, 300);

    // On stocke toujours la vraie valeur sans bug
    balance += amount;
    animateBalance(balance);

    setTimeout(() => showTransaction(index + 1), 1120);
}

setTimeout(() => showTransaction(), 500);