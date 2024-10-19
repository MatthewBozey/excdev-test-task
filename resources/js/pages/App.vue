<template>
    <DynamicDialog/>
    <ConfirmPopup></ConfirmPopup>
    <Toast/>
    <div :class="containerClass" @click="onWrapperClick">
        <TopBar @menu-toggle="onMenuToggle"/>
        <div class="layout-sidebar" @click="onSidebarClick">
            <AppMenu :model="menu" @menuitem-click="onMenuItemClick"/>
        </div>

        <div class="layout-main-container">
            <div class="layout-main">
                <div class="content">
                    <router-view/>
                </div>
            </div>

        </div>

        <transition name="layout-mask">
            <div class="layout-mask p-component-overlay" v-if="mobileMenuActive"></div>
        </transition>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import TopBar from '../components/TopBar.vue'
import AppMenu from '../components/Menu.vue'

export default {
    emits: ['change-theme'],
    data() {
        return {
            layoutMode: 'static',
            staticMenuInactive: false,
            overlayMenuActive: false,
            mobileMenuActive: false,
            menu: [
                {
                    label: "Главная",
                    items: [
                        {label: 'Главная страница', icon: 'pi pi-fw pi-home', to: '/balance'},
                        {label: 'Компании', icon: 'pi pi-fw pi-users', to: '/'},
                        {label: 'Объявления', icon: 'pi pi-fw pi-users', to: '/'},
                        {label: 'Пользователи', icon: 'pi pi-fw pi-users', to: '/users'},
                    ]
                }


            ],
            theme: 'bootstrap4-light-blue'
        }
    },
    watch: {},
    setup() {},
    methods: {

        onWrapperClick() {
            if (!this.menuClick) {
                this.overlayMenuActive = false;
                this.mobileMenuActive = false;
            }

            this.menuClick = false;
        },

        onMenuToggle() {
            this.menuClick = true;

            if (this.isDesktop()) {
                if (this.layoutMode === 'overlay') {
                    if (this.mobileMenuActive === true) {
                        this.overlayMenuActive = true;
                    }

                    this.overlayMenuActive = !this.overlayMenuActive;
                    this.mobileMenuActive = false;
                } else if (this.layoutMode === 'static') {
                    this.staticMenuInactive = !this.staticMenuInactive;
                }
            } else {
                this.mobileMenuActive = !this.mobileMenuActive;
            }

            event.preventDefault();
        },

        onSidebarClick() {
            this.menuClick = true;
        },

        onMenuItemClick(event) {
            if (event.item && !event.item.items) {
                this.overlayMenuActive = false;
                this.mobileMenuActive = false;
            }
        },

        onLayoutChange(layoutMode) {
            localStorage.layout = layoutMode;
            this.layoutMode = layoutMode;
        },

        addClass(element, className) {
            if (element.classList)
                element.classList.add(className);
            else
                element.className += ' ' + className;
        },

        removeClass(element, className) {
            if (element.classList)
                element.classList.remove(className);
            else
                element.className = element.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
        },

        isDesktop() {
            return window.innerWidth >= 992;
        },

        isSidebarVisible() {
            if (this.isDesktop()) {
                if (this.layoutMode === 'static')
                    return !this.staticMenuInactive;
                else if (this.layoutMode === 'overlay')
                    return this.overlayMenuActive;
            }

            return true;
        },
        loadTheme() {
            if (localStorage.theme && localStorage.theme !== this.theme) {
                let obj = {
                    theme: localStorage.theme,
                    dark: Boolean(localStorage.dark) || undefined
                }
                this.changeTheme(obj);
            }
        },
        loadLayout() {
            if (localStorage.layout && localStorage.layout !== this.layoutMode) {
                this.onLayoutChange(localStorage.layout);
            }
        },
        changeTheme(event) {
            let themeElement = document.getElementById("theme-link");
            themeElement.setAttribute(
                "href",
                themeElement.getAttribute("href").replace(this.theme, event.theme)
            );
            this.theme = event.theme;
            EventBus.emit("theme-change", event);
            this.$appState.darkTheme = event.dark;
            if (event.theme.startsWith("md")) {
                this.$primevue.config.ripple = true;
            }
            localStorage.theme = this.theme;
            localStorage.ripple = this.$primevue.config.ripple;
            if (event.dark === undefined)
                localStorage.removeItem('dark')
            else
                localStorage.dark = event.dark;
        },

    },
    created() {},
    computed: {
        containerClass() {
            return ['layout-wrapper', {
                'layout-overlay': this.layoutMode === 'overlay',
                'layout-static': this.layoutMode === 'static',
                'layout-static-sidebar-inactive': this.staticMenuInactive && this.layoutMode === 'static',
                'layout-overlay-sidebar-active': this.overlayMenuActive && this.layoutMode === 'overlay',
                'layout-mobile-sidebar-active': this.mobileMenuActive,
                'p-input-filled': this.$primevue.config.inputStyle === 'filled',
                'p-ripple-disabled': this.$primevue.config.ripple === false
            }];
        },
    },
    beforeUpdate() {
        if (this.mobileMenuActive)
            this.addClass(document.body, 'body-overflow-hidden');
        else
            this.removeClass(document.body, 'body-overflow-hidden');
    },
    components: { AppMenu, TopBar },
    mounted() { }
}
</script>

<style lang="scss">
</style>
