import counterStore from './counterStore.js'

document.addEventListener('DOMContentLoaded', function () {
    // State
    let board = Array(9).fill(null);
    let currentPlayer = 'X';
    let isGameOver = false;

    // DOM-Referenzen
    const boardContainer = document.getElementById('game-board');
    const scoreX = document.getElementById('score-x');
    const scoreO = document.getElementById('score-o');
    const resetBtn = document.getElementById('reset-btn');
    const backBtn = document.getElementById('back-btn');

    // Board rendern
    function renderBoard() {
        boardContainer.innerHTML = '';
        board.forEach((cell, idx) => {
            const cellDiv = document.createElement('div');
            cellDiv.className = 'cell';
            if (cell === 'X') {
                const img = document.createElement('img');
                img.src = '/svg/x-solid.svg'; // Pfad angepasst
                img.alt = 'X';
                cellDiv.appendChild(img);
            } else if (cell === 'O') {
                const img = document.createElement('img');
                img.src = '/svg/o-solid.svg'; // Pfad angepasst
                img.alt = 'O';
                cellDiv.appendChild(img);
            }
            cellDiv.addEventListener('click', () => handleCellClick(idx));
            boardContainer.appendChild(cellDiv);
        });
    }

    // Score rendern
    function renderScores(state) {
        scoreX.textContent = `X: ${state.X}`;
        scoreO.textContent = `O: ${state.O}`;
        scoreX.classList.toggle('active', currentPlayer === 'X');
        scoreO.classList.toggle('active', currentPlayer === 'O');
    }

    // Score-Änderungen abonnieren
    counterStore.subscribe(renderScores);

    // Zellen-Klick
    function handleCellClick(index) {
        if (board[index] || isGameOver) return;
        board[index] = currentPlayer;
        renderBoard();

        if (checkWinner(board, currentPlayer)) {
            alert(`Player ${currentPlayer} has won!`);
            counterStore.increment(currentPlayer);
            isGameOver = true;
        } else {
            currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
            renderScores(counterStore.getState());
        }
    }

    // Gewinner prüfen
    function checkWinner(board, player) {
        const win = [
            [0,1,2],[3,4,5],[6,7,8],
            [0,3,6],[1,4,7],[2,5,8],
            [0,4,8],[2,4,6]
        ];
        return win.some(cond => cond.every(i => board[i] === player));
    }

    // Reset
    resetBtn.addEventListener('click', function () {
        board = Array(9).fill(null);
        currentPlayer = 'X';
        isGameOver = false;
        counterStore.reset();
        renderBoard();
    });

    // Zurück
    backBtn.addEventListener('click', function () {
        window.location.href = '/';
    });

    // Initiales Rendern
    renderBoard();
    renderScores(counterStore.getState());
});
