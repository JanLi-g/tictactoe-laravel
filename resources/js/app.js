import './bootstrap';
import '../css/app.scss';

document.addEventListener('DOMContentLoaded', async function () {

    let gameData = document.getElementById('game-data');
    let initialData = {board: Array(9).fill(null), currentPlayer: 'X', isGameOver: false};
    if (gameData) {
        try {
            initialData = JSON.parse(gameData.textContent);
        } catch (e) {
            console.error('Fehler beim Parsen der Game-Daten:', e);
        }
    }
    let board = initialData.board;
    let currentPlayer = initialData.currentPlayer;
    let isGameOver = initialData.isGameOver;

    const boardContainer = document.getElementById('game-board');
    const scoreX = document.getElementById('score-x');
    const scoreO = document.getElementById('score-o');
    const resetBtn = document.getElementById('reset-btn');
    const backBtn = document.getElementById('back-btn');

    if (!boardContainer) {
        console.error('Das Element #game-board wurde nicht gefunden. Stellen Sie sicher, dass es in der HTML-Datei vorhanden ist.');
        return;
    }

    function renderBoard() {
        boardContainer.innerHTML = '';
        board.forEach((cell, idx) => {
            const cellDiv = document.createElement('div');
            cellDiv.className = 'cell';
            if (cell === 'X') {
                const img = document.createElement('img');
                img.src = '/svg/x-solid.svg';
                img.alt = 'X';
                cellDiv.appendChild(img);
            } else if (cell === 'O') {
                const img = document.createElement('img');
                img.src = '/svg/o-solid.svg';
                img.alt = 'O';
                cellDiv.appendChild(img);
            }
            cellDiv.addEventListener('click', () => handleCellClick(idx));
            boardContainer.appendChild(cellDiv);
        });
    }


    async function renderScores(url) {
        try {
            const response = await fetch(url);
            const scores = await response.json();
            scoreX.textContent = `X: ${scores.x_score}`;
            scoreO.textContent = `O: ${scores.o_score}`;
            // Keine Highlight-Logik mehr im JS
        } catch (e) {
            console.error('Fehler beim Laden der Scores:', e);
        }
    }

    function checkWinner() {
        const winPatterns = [[0, 1, 2], [3, 4, 5], [6, 7, 8],
            [0, 3, 6], [1, 4, 7], [2, 5, 8],
            [0, 4, 8], [2, 4, 6]
        ];
        for (const pattern of winPatterns) {
            const [a, b, c] = pattern;
            if (board[a] && board[a] === board[b] && board[a] === board[c]) {
                return board[a];
            }
        }
        return null;
    }

    function showModal(message) {
        let modal = document.createElement('div');
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100vw';
        modal.style.height = '100vh';
        modal.style.background = 'rgba(0,0,0,0.5)';
        modal.style.display = 'flex';
        modal.style.alignItems = 'center';
        modal.style.justifyContent = 'center';
        modal.style.zIndex = '9999';
        modal.innerHTML = `<div style="background:#fff;padding:2rem 3rem;border-radius:8px;box-shadow:0 2px 8px #0003;font-size:1.5rem;text-align:center;cursor:pointer;">${message}<br><br><button style='margin-top:1rem;padding:0.5rem 1.5rem;font-size:1rem;'>OK</button></div>`;
        modal.querySelector('button').onclick = () => document.body.removeChild(modal);
        document.body.appendChild(modal);
    }

    function updateScoreHighlight() {
        scoreX.classList.remove('active');
        scoreO.classList.remove('active');
        if (currentPlayer === 'X') {
            scoreX.classList.add('active');
        } else {
            scoreO.classList.add('active');
        }
    }

    async function handleCellClick(idx) {
        if (isGameOver || board[idx]) return;
        board[idx] = currentPlayer;
        renderBoard();
        const winner = checkWinner();

        if (winner) {
            isGameOver = true;
            const player = winner.toLowerCase();
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                const res = await fetch('/api/scores/increment', {
                    method: 'POST', headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                    }, body: JSON.stringify({
                        player, board, currentPlayer, isGameOver
                    })
                });
                const data = await res.json();
                scoreX.textContent = `X: ${data.x_score}`;
                scoreO.textContent = `O: ${data.o_score}`;
                updateScoreHighlight();
                await fetch('/api/game/save-state', {
                    method: 'POST', headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                    }, body: JSON.stringify({
                        board, currentPlayer, isGameOver
                    })
                });
                setTimeout(() => {
                    showModal(`Player ${winner} hat gewonnen!`);
                }, 400);
            } catch (e) {
                console.error('Fehler beim Score-Update:', e);
                setTimeout(() => {
                    showModal(`Player ${winner} hat gewonnen!`);
                }, 400);
            }
        } else {
            currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
            updateScoreHighlight();
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                await fetch('/api/game/save-state', {
                    method: 'POST', headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                    }, body: JSON.stringify({
                        board, currentPlayer, isGameOver
                    })
                });
            } catch (e) {
                console.error('Fehler beim Speichern des Spielstands:', e);
            }
        }
    }

    resetBtn.addEventListener('click', async function (e) {
        e.preventDefault();
        board = Array(9).fill(null);
        currentPlayer = 'X';
        isGameOver = false;
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            await fetch('/game/reset', {
                method: 'POST', headers: {
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                }
            });
        } catch (e) {
            console.error('Fehler beim Spielfeld-Reset:', e);
        }
        renderBoard();
        await renderScores('/api/scores');
    });

    backBtn.addEventListener('click', function () {
        window.location.href = '/';
    });

    await renderScores('/api/scores/session');
    renderBoard();
    updateScoreHighlight();
});
