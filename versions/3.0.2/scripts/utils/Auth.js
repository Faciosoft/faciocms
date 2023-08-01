export default {
    signIn() {
        console.log(this.forms.auth.signIn)

        fetch(`/api/sign-in`, {
            method: 'POST',
            body: JSON.stringify(this.forms.auth.signIn)
        })
            .then(res => res.json())
            .then(res => {
                // Message
                this.info.auth.signIn.error = res["content-message"]

                // Login was successful!
                if(!res.error) window.location.href = window.location.origin + '/admin';
            })
    }
}