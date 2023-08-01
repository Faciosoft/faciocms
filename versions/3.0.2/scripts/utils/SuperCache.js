import { dynamicReload } from './DynamicReload'
import { createError } from './Error';

export default {
    ClearSuperCache() {
        fetch(`/api/clear-cache`, {
            method: 'POST',
            body: JSON.stringify({})
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"]);
                
                dynamicReload(true);
            })
    }
}