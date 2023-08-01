import { dynamicReload } from './DynamicReload'
import { createError } from './Error';
import { Modal } from './Modal';

export default {
    initMeta() {
        if(!window.secureDefaultMetaSettings) return;

        for(let [a, b] of Object.entries(window.secureDefaultMetaSettings)) {
            this.page_default_meta_keys.push(a)
        }
    },
    deleteMetaSetting(pageId, keyName) {
        fetch(`/api/delete-meta-setting`, {
            method: 'POST',
            body: JSON.stringify({ pageId, keyName })
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"])
                
                dynamicReload(true);
            })
    },
    createMetaSetting(pageId) {
        new Modal("Setting name").init().then((nameModal) => {
            if(!nameModal) return

            new Modal("Value").init().then((valueModal) => {
                if(!valueModal) return

                fetch(`/api/create-meta-setting`, {
                    method: 'POST',
                    body: JSON.stringify({ pageId, nameModal, valueModal })
                })
                    .then(res => res.json())
                    .then(res => {
                        const contentMessage = res["content-message"]
                        if(res.error) return createError(res["content-message"])
                        
                        dynamicReload(true);
                    })
            })
        }).catch((err) => console.log(err)) 
    },
    saveMetaSettings(pageId) {
        const form = document.forms["form-meta-settings"];
        const inputs = form.querySelectorAll('[return-value]');
        const key_value = {};

        inputs.forEach(input => {
            const { id } = input;
            const id_parts = id.split('_');
            id_parts.shift();

            const full_name = id_parts.join('_');
            key_value[full_name] = input.value;

            if(input.type === 'checkbox' || input.type === 'radio') {
                // if(input.value === '1') key_value[full_name] = true;
                // else if(input.value === '0') key_value[full_name] = false;
                key_value[full_name] = input.checked ? '1' : '0'
            }
        });

        console.log(key_value);
        fetch(`/api/save-meta-setting`, {
            method: 'POST',
            body: JSON.stringify({ values: key_value, page_id: pageId })
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"])
                
                dynamicReload(true);
            })
    }
}