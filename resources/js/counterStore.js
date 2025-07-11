
const counterStore = (() => {
    let state = { X: 0, O: 0 };
    const listeners = [];

    function getState() {
        return { ...state };
    }

    function increment(player) {
        if (player === 'X' || player === 'O') {
            state[player]++;
            notify();
        }
    }

    function reset() {
        state = { X: 0, O: 0 };
        notify();
    }

    function subscribe(listener) {
        listeners.push(listener);
    }

    function notify() {
        listeners.forEach(fn => fn(getState()));
    }

    return { getState, increment, reset, subscribe };
})();

export default counterStore;
