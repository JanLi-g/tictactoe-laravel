import './bootstrap';
import '../css/app.scss';
import counterStore from './counterStore.js';

document.addEventListener('DOMContentLoaded', function () {
    // Initialisiere die Spielstände aus der Datenbank
    let board = Array(9).fill(null);
    let currentPlayer = 'X';
    let isGameOver = false;

    const boardContainer = document.getElementById('game-board');
    const scoreX = document.getElementById('score-x');
    const scoreO = document.getElementById('score-o');
    const resetBtn = document.getElementById('reset-btn');
    const backBtn = document.getElementById('back-btn');

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

    function renderScores(state) {
        scoreX.textContent = `X: ${state.X}`;
        scoreO.textContent = `O: ${state.O}`;
        scoreX.classList.toggle('active', currentPlayer === 'X');
        scoreO.classList.toggle('active', currentPlayer === 'O');
    }

    counterStore.subscribe(renderScores);

    async function handleCellClick(index) {
        if (board[index] || isGameOver) return;
        board[index] = currentPlayer;
        renderBoard();

        if (checkWinner(board, currentPlayer)) {
            isGameOver = true;
            await counterStore.increment(currentPlayer);
            renderScores(counterStore.getState());
            setTimeout(() => {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert';
                alertDiv.textContent = `Player ${currentPlayer} has won!`;
                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }, 100);
        } else {
            currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
            renderScores(counterStore.getState());
        }
    }

    function checkWinner(board, player) {
        const win = [
            [0,1,2],[3,4,5],[6,7,8],
            [0,3,6],[1,4,7],[2,5,8],
            [0,4,8],[2,4,6]
        ];
        return win.some(cond => cond.every(i => board[i] === player));
    }

    resetBtn.addEventListener('click', async function () {
        board = Array(9).fill(null);
        currentPlayer = 'X';
        isGameOver = false;
        await counterStore.reset();
        renderBoard();
    });

    backBtn.addEventListener('click', function () {
        window.location.href = '/';
    });

    // Initialer Sync der Spielstände aus der Datenbank
    counterStore.syncFromDb();
    renderBoard();
    renderScores(counterStore.getState());
});
