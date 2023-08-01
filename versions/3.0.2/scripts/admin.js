import { createApp } from "vue";
import { IsExpanded } from "./utils/IsExpanded";
import AUTH from "./utils/Auth"
import SETTINGS from "./utils/Settings"
import PAGES from "./utils/Pages"
import METAPAGESETTINGS from "./utils/MetaPageSettings"
import USERS from "./utils/Users"
import LAYOUTS from "./utils/Layouts"
import GALLERY from "./utils/Gallery"
import CONNECT_ACCOUNTS from "./utils/ConnectAccounts"
import SUPERCACHE from "./utils/SuperCache";
import PerformanceTestRun from "./vue/PerformanceTestRun.vue"
import PageEditor from "./vue/PageEditor.vue"
import ViewSelector from "./vue/ViewSelector.vue"
import GalleryUploader from "./vue/GalleryUploader.vue"
import "./utils/KeyManager"
import "./utils/WindowPrototypeExtended"
import "./utils/ViewFromUrl"
import "./utils/ContextMenu"
// import "./utils/LayoutEditor"
import { dynamicReload } from "./utils/DynamicReload";

const app = createApp({
    components: {
        performancetestrun: PerformanceTestRun,
        pageeditor: PageEditor,
        viewselector: ViewSelector,
        galleryuploader: GalleryUploader
    },
    data() {
        return {
            secureContent: '',
            forms: {
                auth: {
                    signIn: {
                        username: "",
                        password: ""
                    },
                    createUser: {
                        username: "",
                        email: "",
                        password: "",
                        confirm_password: "",
                        role: "Viewer"
                    }
                },
                layouts: {
                    createLayout: {
                        name: ""
                    }
                }
            },
            info: {
                auth: {
                    signIn: {
                        error: ''
                    }
                },
                settings: {
                    opt_cache: {
                        error: ''
                    }
                }
            },
            settings: {
                opt_cache: {
                    // Getting data from static PHP response in <script> tag in (views/Settings.php)
                    prod_mode: window.secureData?.prod_mode || false,
                    auto_updates: window.secureData?.prod_mode || false,
                    website_name: window.secureData?.website_name || "FacioCMS website",
                    website_url: window.secureData?.website_url || "https://faciocms.com/",
                    theme_color: window.secureData?.theme_color || "#242b38",
                    secondary_color: window.secureData?.secondary_color || "#fc3333",
                    supercaching: window.secureData?.super_caching || false,
                    version: window.secureData?.version || '3.0.0'
                }
            },
            view: '',
            page_default_meta_keys: [],
            show_secret_meta_settings: false,
            showPassword: false,
            window,
            document,
            galleryOpened: false,
            galleryIndex: -1
        }
    },
    methods: {
        ...AUTH,
        ...SETTINGS,
        ...PAGES,
        ...METAPAGESETTINGS,
        ...USERS,
        ...LAYOUTS,
        ...GALLERY,
        ...CONNECT_ACCOUNTS,
        ...SUPERCACHE,
        setView(newView) {
            this.view = newView
        },
        initView() {
            window._setDisplayView = (view) => this.view = view;
            window.getView = () => this.view;
        },
        setViewWithEditor(newView) {
            if(this.view === 'editor') {
                window.tinymce__editor[0]?.remove()
            }

            // Set new view
            this.view = newView;

            // Init editor if view contains edito
            if(newView === 'editor') {
                dynamicReload(true)

                // setTimeout(() => {
                //     window.tinymce__initEditor();
                // }, 512);
            }
        },
        toggleShowPassword() {
            this.showPassword = !this.showPassword
        },
        goto(url) {
            window.location.href = url
        },
        openWindow(url) {
            window.open(url, "blank")
        },
        IsExpanded, 
        capitalize(str = '') {
            if(!str) return; 
            const upper = str[0].toUpperCase() 

            return upper + str.substring(1, str.length).toLowerCase();
        }
    },
    mounted() {
        this.secureContent = window.secureContent;
        this.view = window.displayView || "";
        this.initView();
        this.initMeta();
    }
}).mount('#faciocms-admin')

// Fire Load event
window.onScriptLoadedListeners.forEach(callback => callback())