import { dynamicReload } from './DynamicReload'
import { createError } from './Error';
import { stringToBool } from './StringToBool';

window.tState = false

export default {
    createPage(parent_id = -1) {
        fetch(`/api/create-page`, {
            method: 'POST',
            body: JSON.stringify({ parent_id })
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"]);
                
                dynamicReload(true);
            })
    },
    deletePage(id) {
        fetch(`/api/delete-page`, {
            method: 'DELETE',
            body: JSON.stringify({ id })
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"]);
                
                dynamicReload(true);
            })
    },
    openPageDetails() {
        setTimeout(() => {
            const states = {}
            
            document.querySelectorAll('details.page')
                .forEach(pageDetails => {
                    const state = pageDetails.open
                    states[pageDetails.classList[1].split('page-')[1]] = state
                })

            const text = JSON.stringify(states)
            localStorage.setItem('pages-expand-state', text);
        }, 0)
    },
    toggleExpand() {
        const states = {}
        window.tState = !window.tState
            
        document.querySelectorAll('details.page')
            .forEach(pageDetails => {
                pageDetails.open = window.tState
                states[pageDetails.classList[1].split('page-')[1]] = window.tState
            })

        const text = JSON.stringify(states)
        localStorage.setItem('pages-expand-state', text);
    },
    deleteAllPages() {
        fetch(`/api/delete-all-pages`, {
            method: 'DELETE',
            body: JSON.stringify()
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"]);
                
                dynamicReload(true);
            })
    }
}