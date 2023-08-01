import { dynamicReload } from "./DynamicReload"
import { createError } from "./Error"

export default {
    deleteUser(id) {
        fetch(`/api/delete-user`, {
            method: 'DELETE',
            body: JSON.stringify({ id })
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"]);
                
                dynamicReload();
            })
    },
    createUser() {
        fetch(`/api/create-user`, {
            method: 'POST',
            body: JSON.stringify(this.forms.auth.createUser)
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"]);
                
                dynamicReload();
            })
    },
    randomizePasswordForUserCreation() {
        const 
            lower_charset = "abcdefghijklmnoprstwuxyz",
            upper_charset = lower_charset.toUpperCase(),
            numeric_charset = "0123456789",
            special_charset = ".,!@#$%^&*(){}|<>?;:'[]-="
        
        const password_charset = lower_charset + lower_charset + lower_charset + upper_charset + upper_charset + upper_charset + numeric_charset + numeric_charset + special_charset
        const password_length = 16

        let password = ''

        for(let i = 0; i < password_length; i++) 
            password += password_charset[parseInt(Math.random() * password_charset.length)]

        this.forms.auth.createUser.password = this.forms.auth.createUser.confirm_password = password
    }
}