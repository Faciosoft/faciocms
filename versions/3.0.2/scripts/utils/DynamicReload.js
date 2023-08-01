export function dynamicReload(has = false) {
    if(has) {
        const view = window.getView()
        let newUrl = window.location.href

        if(newUrl.indexOf(`/#!/${view}`) === -1) window.location.href += '/#!/' + view

        location.hash = `!/${view}`
    }

    location.reload()
}