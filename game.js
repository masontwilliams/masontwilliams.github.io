function playMove(choice) {
    document.getElementById('rematchPrompt').style.display = 'none';

    // Highlight the selected choice
    document.querySelectorAll('#matchInfo button').forEach(button => {
        button.classList.remove('selected');
    });
    document.getElementById(`play${capitalize(choice)}`).classList.add('selected');

    // Display the player's choice
    document.getElementById('yourChoice').innerHTML = `${getChoiceImage(choice)} ${capitalize(choice)}`;

    fetch('result_processing.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `choice=${encodeURIComponent(choice)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.result === "tie") {
            document.getElementById('rematchPrompt').style.display = 'block';
            document.querySelectorAll('#matchInfo button').forEach(button => {
                button.classList.remove('selected');
            });
            document.getElementById('yourChoice').textContent = '';
            document.getElementById('winnerInfo').textContent = data.message;
        } else if (data.result === "win" || data.result === "lose") {
            document.getElementById('winnerInfo').innerHTML = `${data.result === "win" ? "You win!" : "You lose!"} (Opponent's Choice: ${getChoiceImage(data.opponentMove)} ${capitalize(data.opponentMove)})`;
        } else if (data.result === "waiting") {
            document.getElementById('winnerInfo').textContent = data.message;
        }
        fetchBrackets();  // Fetch updated brackets after each move
    })
    .catch(error => console.error('Error processing move:', error));
}

function capitalize(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
}

function getChoiceImage(choice) {
    switch (choice) {
        case 'rock':
            return '<img src="images/4221-dwayneeyebrow.png" alt="Rock" class="choice-img">';
        case 'paper':
            return '📄';
        case 'scissors':
            return '✂️';
        default:
            return '';
    }
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

// Event listeners for playing moves
document.getElementById('playRock').addEventListener('click', () => playMove('rock'));
document.getElementById('playPaper').addEventListener('click', () => playMove('paper'));
document.getElementById('playScissors').addEventListener('click', () => playMove('scissors'));
