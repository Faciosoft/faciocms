import { dynamicReload } from "./DynamicReload"

export default {
    saveSettings() {
        const settings = { ...this.settings.opt_cache }

        fetch(`/api/save-settings`, {
            method: 'POST',
            body: JSON.stringify(settings)
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                this.info.settings.opt_cache.error = contentMessage

                if(!res.error) dynamicReload(true)

                setTimeout(() => {
                    this.info.settings.opt_cache.error = ''
                }, 10 * 1000)
            })
    },
    initSettings() {
        const { keymanager } = window

        keymanager.subscribe('s', (cancel) => {
            if(keymanager.hasCtrl()) {
                this.saveSettings()
                cancel()
            }
        })

        return ""
    },
    saveVersion() {
        const version = this.settings.opt_cache.version

        fetch(`/api/change-version`, {
            method: 'POST',
            body: version
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                this.info.settings.opt_cache.error = contentMessage

                if(!res.error) dynamicReload(true)

                setTimeout(() => {
                    this.info.settings.opt_cache.error = ''
                }, 10 * 1000)
            })
    }
}