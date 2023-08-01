import { createError } from "./Error"
import { dynamicReload } from "./DynamicReload"
import { Modal } from "./Modal"

export default {
    createLayout() {
        const name = this.forms.layouts.createLayout.name

        fetch(`/api/create-layout`, {
            method: 'POST',
            body: JSON.stringify({ name })
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"]);
                
                dynamicReload();
            })
    },
    deleteLayout(name) {
        new Modal("Type CONFIRM to process").init().then((nameModal) => {
            if(!nameModal || nameModal !== 'CONFIRM') return

            fetch(`/api/delete-layout`, {
                method: 'DELETE',
                body: JSON.stringify({ name })
            })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"]);
                
                dynamicReload();
            })

        }).catch((err) => console.log(err)) 
    }
}