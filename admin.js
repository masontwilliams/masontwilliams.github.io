function addPlayer() {
    const username = document.getElementById('newPlayer').value;
    const password = document.getElementById('newPassword').value;
    fetch('manage_participants.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=add&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.text())
    .then(data => alert(data))
    .catch(error => console.error('Error adding player:', error));
}

function initializeTournament() {
    fetch('initialize_tournament.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'initialize=true'
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        fetchBrackets();  // Fetch brackets after initialization
    })
    .catch(error => console.error('Error initializing tournament:', error));
}

function resetTournament() {
    fetch('reset_tournament.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'reset=true'
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        fetchBrackets();  // Fetch brackets after reset
    })
    .catch(error => console.error('Error resetting tournament:', error));
}

function fetchBrackets() {
    fetch('fetch_brackets.php')
    .then(response => response.json())
    .then(data => renderBrackets(data))
    .catch(error => console.error('Error fetching brackets:', error));
}

function renderBrackets(brackets) {
    const container = document.getElementById('bracketContainer');
    container.innerHTML = ''; // Clear previous content
    brackets.forEach((round, roundIndex) => {
        const roundDiv = document.createElement('div');
        roundDiv.classList.add('round');
        roundDiv.innerHTML = `<h3>Round ${roundIndex + 1}</h3>`;
        round.forEach(match => {
            const matchDiv = document.createElement('div');
            matchDiv.classList.add('match');
            matchDiv.innerHTML = `
                <p>${match.player1} vs ${match.player2}</p>
                <p>Winner: ${match.winner ? match.winner : 'TBD'}</p>
            `;
            roundDiv.appendChild(matchDiv);
        });
        container.appendChild(roundDiv);
    });
}

function logout() {
    window.location.href = 'logout.php';
}

function displayUsername() {
    fetch('get_username.php')
    .then(response => response.json())
    .then(data => document.getElementById('username').textContent = data.username)
    .catch(error => console.error('Error fetching username:', error));
}

// Fetch brackets on page load
fetchBrackets();
// Display username on page load
displayUsername();


