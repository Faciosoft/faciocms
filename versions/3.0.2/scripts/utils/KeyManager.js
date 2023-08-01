/**
 * FacioCMS Key Manager
 */

class KeyManager {
    constructor() {
        this.data = {};
        this.subscriptions = [];
        this.init();
    }

    init() {
        document.addEventListener('keyup', ({ key }) => {
            this.data[key.toLowerCase()] = false;
        });

        document.addEventListener('keydown', (e) => {
            this.data[e.key.toLowerCase()] = true;

            this.subscriptions.forEach((subs) => {
                if(subs.key === e.key.toLowerCase()) subs.callback(() => e.preventDefault());
            });
        });
    }

    subscribe(key, callback) {
        this.subscriptions.push({ key, callback });
    }

    hasCtrl() {
        return !!this.data['control'];
    }

    hasShift() {
        return !!this.data['shift'];
    }

    hasAlt() {
        return !!this.data['alt'];
    }
}

window.keymanager = window.keymanager || new KeyManager();