import './bootstrap';
import '../css/app.scss';

/**
 * Initialisiert das Tic Tac Toe Spiel.
 */
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

    /**
     * API-Endpunkte für die Scores und das Spiel.
     * @type {{SCORES: string, SCORES_SESSION: string, SCORES_INCREMENT: string, GAME_SAVE_STATE: string, GAME_RESET: string}}
     */
    const API = {
        SCORES: '/api/scores',
        SCORES_SESSION: '/api/scores/session',
        SCORES_INCREMENT: '/api/scores/increment',
        GAME_SAVE_STATE: '/api/game/save-state',
        GAME_RESET: '/game/reset',
    };

    /**
     * Zeigt einen Ladezustand für die Scores an.
     */
    function showScoreLoading() {
        scoreX.innerHTML = '<span class="score-loading">X: <span class="loader"></span></span>';
        scoreO.innerHTML = '<span class="score-loading">O: <span class="loader"></span></span>';
    }

    /**
     * Zeigt einen Fehlertext für die Scores an.
     */
    function showScoreError() {
        scoreX.textContent = 'X: Fehler';
        scoreO.textContent = 'O: Fehler';
    }

    /**
     * Lädt und rendert die Scores von der API.
     * @param url
     * @returns {Promise<void>}
     */
    async function renderScores(url) {
        showScoreLoading();
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('API-Fehler');
            const scores = await response.json();
            scoreX.textContent = `X: ${scores.x_score}`;
            scoreO.textContent = `O: ${scores.o_score}`;
        } catch (e) {
            showScoreError();
            console.error('Fehler beim Laden der Scores:', e);
        }
    }

    /**
     * Zeichnet das Spielfeld neu.
     */
    function renderBoard() {
        boardContainer.innerHTML = '';
        board.forEach((cell, idx) => {
            const cellDiv = document.createElement('div');
            cellDiv.className = 'cell';
            if (cell === 'X') {
                cellDiv.classList.add('setX');
                cellDiv.innerHTML = `
      <svg class="icon-x" viewBox="0 0 100 100">
        <path d="M20,20 L80,80 M80,20 L20,80" stroke="currentColor" stroke-width="10" fill="none"/>
      </svg>
    `;
            } else if (cell === 'O') {
                cellDiv.classList.add('setO');
                cellDiv.innerHTML = `
      <svg class="icon-o" viewBox="0 0 100 100">
        <circle cx="50" cy="50" r="35" stroke="currentColor" stroke-width="10" fill="none"/>
      </svg>
    `;
            }
            // if (cell === 'X') {
            //     cellDiv.classList.add('setX');
            //     const img = document.createElement('img');
            //     img.src = `/svg/x-solid.svg`;
            //     img.alt = 'X';
            //     cellDiv.appendChild(img);
            // } else if (cell === 'O') {
            //     cellDiv.classList.add('setO');
            //     const img = document.createElement('img');
            //     img.src = `/svg/o-solid.svg`;
            //     img.alt = 'O';
            //     cellDiv.appendChild(img);
            // }
            cellDiv.addEventListener('click', () => handleCellClick(idx));
            boardContainer.appendChild(cellDiv);
        });
    }
    // function renderBoard() {
    //     boardContainer.innerHTML = '';
    //     board.forEach((cell, idx) => {
    //         const cellDiv = document.createElement('div');
    //         cellDiv.className = 'cell';
    //         if (cell === 'X' || cell === 'O') {
    //             const img = document.createElement('img');
    //             img.src = `/svg/${cell.toLowerCase()}-solid.svg`;
    //             img.alt = cell;
    //             cellDiv.appendChild(img);
    //         }
    //         cellDiv.addEventListener('click', () => handleCellClick(idx));
    //         boardContainer.appendChild(cellDiv);
    //     });
    // }

    /**
     * Überprüft, ob es einen Gewinner gibt.
     * @returns {any|null}
     */
    function checkWinner() {
        const winPatterns = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8],
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

    /**
     * Zeigt ein modales Fenster mit einer Win Alert an.
     * @param message
     */
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

    /**
     * Aktualisiert die Hervorhebung des Scores basierend auf dem aktuellen Spieler.
     */
    function updateScoreHighlight() {
        scoreX.classList.toggle('active', currentPlayer === 'X');
        scoreO.classList.toggle('active', currentPlayer === 'O');
    }

    /**
     * Speichert den aktuellen Spielstand auf dem Server.
     * @param board
     * @param currentPlayer
     * @param isGameOver
     * @returns {Promise<void>}
     */
    async function saveGameState(board, currentPlayer, isGameOver) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            await fetch(API.GAME_SAVE_STATE, {
                method: 'POST', headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                }, body: JSON.stringify({ board, currentPlayer, isGameOver })
            });
        } catch (e) {
            console.error('Fehler beim Speichern des Spielstands:', e);
        }
    }

    /**
     * Erhöht den Score des aktuellen Spielers und aktualisiert die Anzeige.
     * @param player
     * @param board
     * @param currentPlayer
     * @param isGameOver
     * @returns {Promise<boolean>}
     */
    async function incrementScore(player, board, currentPlayer, isGameOver) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const res = await fetch(API.SCORES_INCREMENT, {
                method: 'POST', headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                }, body: JSON.stringify({ player, board, currentPlayer, isGameOver })
            });
            if (!res.ok) throw new Error('Score-Increment fehlgeschlagen');
            const data = await res.json();
            scoreX.textContent = `X: ${data.x_score}`;
            scoreO.textContent = `O: ${data.o_score}`;
            updateScoreHighlight();
            return true;
        } catch (e) {
            showScoreError();
            console.error('Fehler beim Score-Update:', e);
            return false;
        }
    }

    /**
     * Behandelt den Klick auf eine Zelle des Spielfelds.
     * @param idx
     * @returns {Promise<void>}
     */
    async function handleCellClick(idx) {
        if (isGameOver || board[idx]) return;
        board[idx] = currentPlayer;
        renderBoard();
        const winner = checkWinner();
        if (winner) {
            isGameOver = true;
            const player = winner.toLowerCase();
            const success = await incrementScore(player, board, currentPlayer, isGameOver);
            await saveGameState(board, currentPlayer, isGameOver);
            setTimeout(() => showModal(`Player ${winner} hat gewonnen!`), 400);
        } else {
            currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
            updateScoreHighlight();
            await saveGameState(board, currentPlayer, isGameOver);
        }
    }

    /**
     * Event-Listener für den Reset-Button.
     */
    resetBtn.addEventListener('click', async function (e) {
        e.preventDefault();
        board = Array(9).fill(null);
        currentPlayer = 'X';
        isGameOver = false;
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            await fetch(API.GAME_RESET, {
                method: 'POST', headers: {
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                }
            });
        } catch (e) {
            console.error('Fehler beim Spielfeld-Reset:', e);
        }
        renderBoard();
        await renderScores(API.SCORES);
    });

    backBtn.addEventListener('click', function () {
        window.location.href = '/';
    });

    const hardResetBtn = document.getElementById('hardreset-btn');
    if (hardResetBtn) {
        hardResetBtn.addEventListener('click', async function (e) {
            e.preventDefault();
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                await fetch('/game/hardreset', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                    }
                });
                board = Array(9).fill(null);
                currentPlayer = 'X';
                isGameOver = false;
                renderBoard();
                await renderScores(API.SCORES);
            } catch (err) {
                console.error('Fehler beim Hardreset:', err);
            }
        });
    }
    await renderScores(API.SCORES_SESSION);
    renderBoard();
    updateScoreHighlight();
});
