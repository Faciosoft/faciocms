<template>
    <div class="d-flex justify-content-center uploader">
        <label 
            @drop="handleDrop"
            @dragover="handleIn"
            @dragleave="handleOut"
            @dragenter="handleIn"
            :class="`uploader-area ${inside ? 'active' : ''}`" 
            for="gallery-file">
            <em class="fas fa-upload"></em>
            <span class="text">{{ text }}</span>
        </label>

        <input class="hidden" type="file" name="gallery-file" id="gallery-file">
    </div>
</template>

<script>
    import { dynamicReload } from "../utils/DynamicReload"
    import { createError } from "../utils/Error"

    export default {
        name: "GalleryUploader",
        props: {
            text: String,
            page_id: Number
        },
        data() {
            return {
                inside: false,
                files: []
            }
        },
        methods: {
            handleOut(e) {
                this.inside = false

                e.preventDefault();
                e.stopPropagation();
            },
            handleIn(e) {
                this.inside = true    
                
                e.preventDefault();
                e.stopPropagation();
            },
            handleDrop(e) {
                this.handleOut(e)
                const dt = e.dataTransfer
                const files = dt.files

                this.files = files

                if(!files[0]) return

                const fd = new FormData()
                fd.append('file', files[0])
                fd.append('page_id', this.page_id)
                
                fetch(`/api/upload-gallery`, {
                    method: 'POST',
                    body: fd
                })
                    .then(res => res.json())
                    .then(res => {
                        const contentMessage = res["content-message"]
                        if(res.error) return createError(res["content-message"]);
                        
                        dynamicReload(true);
                    })
            }
        }
    }
</script>