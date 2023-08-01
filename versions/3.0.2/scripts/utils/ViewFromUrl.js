/**
 *  If url contains /#!/xyz then faciocms will show the view from it (in this example: xyz)
 *  View goes after /#!/ 
 **/

window.onScriptLoaded(() => {
    const url = window.location.href

    if(url.indexOf("#!/") !== -1) {
        // We got view redirect=
        const newView = url.split("#!/")[1]
        if(!newView || newView === '') return;

        window.setDisplayView(decodeURIComponent(newView))
    }
})