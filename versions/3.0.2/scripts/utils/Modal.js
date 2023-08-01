export class Modal {
    constructor(name) {
        this.name = name
    }

    init() {
        const modalId = 'modal_' + parseInt(Math.random() * 9e9).toString(16)

        document.body.innerHTML += `<div class="cms-modal" id="${modalId}">
            <h3 class="cms-modal-title">${this.name}</h3>

            <div class="cms-modal-body">
                <button class="cancel-btn cms-btn"><em class="fas fa-times no"></em></button>
                <input type="text" class="cms-input" id="cms-modal-input">
                <button class="ok-btn cms-btn"><em class="fas fa-arrow-right no"></em></button>
            </div>
        </div>`
        
        return new Promise((resolve, reject) => {
            const modal = document.querySelector('#' + modalId)

            modal.querySelector('.ok-btn').addEventListener('click', () => {
                const { value } = modal.querySelector('#cms-modal-input')
                
                modal.remove()
                resolve(value)
            })

            modal.querySelector('.cancel-btn').addEventListener('click', () => {
                modal.remove()
                
                reject(null)
            })
        })
    }
}