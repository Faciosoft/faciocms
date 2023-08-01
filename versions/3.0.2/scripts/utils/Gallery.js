import { createError } from "./Error"
import { dynamicReload } from "./DynamicReload";

export default {
    openGalleryItem(index) {
        this.galleryOpened = true;
        this.galleryIndex = index; 
    },
    closeGalleryItem() {
        this.galleryOpened = false;
        this.galleryIndex = -1;
    },
    changeGalleryNavigation(add) {
        this.galleryIndex += add;
        const max = window.currentGallery.length;

        if(this.galleryIndex === -1) {
            this.galleryIndex = max - 1;
        }
        else if(this.galleryIndex === max) {
            this.galleryIndex = 0;
        }
    },
    deleteGalleryImage() {
        const item = window.currentGallery[this.galleryIndex];
        const { id } = item;

        fetch(`/api/delete-gallery-item`, {
            method: 'DELETE',
            body: JSON.stringify({ id })
        })
            .then(res => res.json())
            .then(res => {
                const contentMessage = res["content-message"]
                if(res.error) return createError(res["content-message"]);
                
                dynamicReload(true);
            })
    }
}