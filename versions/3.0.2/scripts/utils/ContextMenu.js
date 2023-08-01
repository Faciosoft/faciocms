// Dynamic return cause this is inside vue app so static handle could be deleted by vue
function contextMenu() {
    return document.querySelector('.context-menu')
}

function hideContextMenu() {
    contextMenu().style.top = '100vh';
    contextMenu().style.left = '100vw';
}

document.addEventListener('contextmenu', (e) => {
    const { pageX, pageY } = e

    contextMenu().style.top = pageY + 'px';
    contextMenu().style.left = pageX + 'px';

    e.preventDefault()
})

document.body.addEventListener("click", (e) => {
    if(e.target.offsetParent != contextMenu()) hideContextMenu();
})

window.hideContextMenu = () => hideContextMenu()