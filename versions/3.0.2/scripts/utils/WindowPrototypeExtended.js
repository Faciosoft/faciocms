/**
 * @name displayView
 * @description this is default view that will be rendered (it can be change by client but it's default)
 * 
 */
window.displayView = window.displayView || "";
window.setDisplayView = (view) => {
    window.displayView = view 
    window._setDisplayView ? window._setDisplayView(view) : null
}