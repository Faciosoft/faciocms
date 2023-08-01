/**
 * @name onScriptLoaded
 * @description This will execute callback after loading all other scripts
 * 
 * @param {CallableFunction} callback 
 */

window.onScriptLoadedListeners = []
window.onScriptLoaded = (callback) => onScriptLoadedListeners.push(callback)