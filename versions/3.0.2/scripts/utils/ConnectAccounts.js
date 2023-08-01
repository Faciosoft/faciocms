export default {
    connectAccounts() {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left = (width - 240) / 2 / systemZoom + dualScreenLeft
        const top = (height - 300) / 2 / systemZoom + dualScreenTop

        const connectAccountsWindow = window.open(`https://auth.faciocms.com/connect-account/${window.globalUserId}`, '_blank', `width=480,height=600,resizable=no,top=${top},left=${left}`)
    }
}