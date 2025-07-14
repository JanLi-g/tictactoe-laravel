/**
 * @typedef {Object} Score
 * @property {number} x_score
 * @property {number} o_score
 */

const counterStore = (() => {
    let state = { X: 0, O: 0 };
    const listeners = [];

    async function syncFromDb() {
        const dbScore = await fetchScore();
        state = { X: dbScore.x_score, O: dbScore.o_score };
        notify();
    }

    async function increment(player) {
        if (player === 'X' || player === 'O') {
            const dbScore = await incrementScore(player.toLowerCase());
            state = { X: dbScore.x_score, O: dbScore.o_score };
            notify();
        }
    }

    async function reset() {
        const dbScore = await resetScore();
        state = { X: dbScore.x_score, O: dbScore.o_score };
        notify();
    }

    function getState() {
        return { ...state };
    }

    function subscribe(listener) {
        listeners.push(listener);
    }

    function notify() {
        listeners.forEach(fn => fn(getState()));
    }

    // Initial sync beim Laden
    (async () => {
        await syncFromDb();
    })();

    return { getState, increment, reset, subscribe, syncFromDb };
})();

/** @returns {Promise<Score>} */
export async function fetchScore() {
    const response = await fetch('/api/score');
    return await response.json();
}

/** @returns {Promise<Score>} */
export async function incrementScore(player) {
    const response = await fetch('/api/score/increment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ player })
    });
    return await response.json();
}

/** @returns {Promise<Score>} */
export async function resetScore() {
    const response = await fetch('/api/score/reset', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
        }
    });
    return await response.json();
}

export default counterStore;
