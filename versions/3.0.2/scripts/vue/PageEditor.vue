<template>
    <form class="editor-form form">
        <div class="form-group">
            <label class="editor-form__label form-label" for="page-title">{{ text_title }}</label>
            <input type="text" class="editor-form__input form-input" id="page-title" name="title" v-model="title">
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="form-group">
                    <label class="editor-form__label form-label" for="page-subtitle">{{ text_subtitle }}</label>
                    <input type="text" class="editor-form__input form-input" id="page-subtitle" name="subtitle" v-model="subtitle">
                </div>
            </div>

            <div class="col-lg-2 col-md-2">
                <div class="form-group">
                    <label class="editor-form__label form-label" for="page-layout">{{ text_layout }}</label>
                    <select class="editor-form__input form-input" id="page-layout" name="layout" v-model="layout">
                        <option value="" disabled>Not selected</option>
                        <option v-for="_layout in layouts" :value="_layout.name" :selected="_layout.name === layout">{{ _layout.name }}</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-2 col-md-2">
                <label class="editor-form__label form-label" for="page-url">{{ text_url }}</label>
                <input type="text" class="editor-form__input form-input" id="page-url" name="url" v-model="url">
            </div>
        </div>

        <div class="form-group">
            <label class="editor-form__label form-label" for="page-content">{{ text_content }}</label>
            <textarea type="text" class="editor-form__input form-input" id="page-content" name="content" v-model="content">{{ content }} </textarea>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
                <div class="form-group save">
                    <span class="text-success" @click="success_text = ''">{{ success_text }}</span>
                    <button class="success-cms-btn" @click="redirect" type="button"> {{ text_preview }} <em class="fas fa-external-link-alt"></em></button>
                    <button class="success-cms-btn" @click="save" type="button"> {{ text_save }} <em class="fas fa-save"></em> </button>
                </div>
            </div>
        </div>
    </form>
</template>

<style lang="scss" scoped>
    .form-group.save {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        .text-success {
            margin-right: 20px;
            color: #ccc!important;
            cursor: pointer;
        }

        .success-cms-btn {
            margin: 0 6px;
            margin-bottom: 0;

            em {
                margin-right: 6px;
            }
        }
    }
</style>

<script>
    import { markRaw } from 'vue';

    export default {
        name: "PageEditor",
        props: {
            _title: String,
            _subtitle: String,
            _content: String,
            _layout: String,
            _url: String,
            id: String,
            text_title: String,
            text_subtitle: String,
            text_content: String,
            text_save: String,
            text_layout: String,
            text_url: String,
            text_preview: String,
            _layouts: String
        },
        data() {
            return {
                title: '',
                subtitle: '',
                content: '',
                layout: '',
                layouts: [],
                editor: null,
                success_text: '',
                url: ''
            }
        },
        methods: {
            save() {
                const content = tinymce.get("page-content").getContent()

                fetch('/api/page-save', {
                    method: 'POST',
                    body: JSON.stringify({ 
                        content, 
                        title: this.title, 
                        subtitle: this.subtitle,
                        layout: this.layout,
                        url: this.url,
                        id: this.id
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        this.success_text = data["content-message"]

                        setTimeout(() => {
                            this.success_text = ''
                        }, 10 * 1000)
                    })
            },
            listen() {
                const { keymanager } = window;

                keymanager.subscribe('s', (cancel) => {
                    if(keymanager.hasCtrl()) {
                        this.save()
                        cancel()
                    }
                })
            },
            redirect() {
                const previewWindow = window.open(window.pageUrl, '_blank');
            },
            initEditor() {
                tinymce.init({ 
                    selector: '#page-content',
                    skin: "oxide-dark",
                    content_css: "dark"
                })
                    .then(editor => window.tinymce__editor = editor)
            }
        },
        mounted() {
            this.title = this._title;
            this.subtitle = this._subtitle;
            this.content = this._content === '' ? window.secureContent : this._content;
            this.layout = this._layout;
            this.layouts = JSON.parse(decodeURIComponent(this._layouts));
            this.url = this._url;

            this.listen();
            this.initEditor();

            window.tinymce__initEditor = () => this.initEditor();
        }
    }
</script>