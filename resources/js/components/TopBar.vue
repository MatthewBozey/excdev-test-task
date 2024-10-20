<template>
    <div class="layout-topbar">
        <Button
            class="p-link layout-menu-button layout-topbar-button p-button-sm p-button-text "
            @click="onMenuToggle"
        >
            <i class="pi pi-bars"></i>
        </Button>


        <ul class="layout-topbar-menu hidden lg:flex origin-top">
            <li>
                <Button class="p-link layout-topbar-button p-button-text">
                    <i class="pi pi-calendar"></i> <span>Уведомления</span>
                </Button>
            </li>
            <li>
                <Button
                    class="p-link layout-topbar-button p-button-text p-button-info"
                    @click="$router.push('profile')"
                >
                    <i class="pi pi-user"></i> <span>Профиль</span>
                </Button>
            </li>
            <li>
                <Button class="p-link layout-topbar-button p-button-text p-button-danger" @click="logout">
                    <i class="pi pi-sign-out"></i> <span>Выйти из системы</span>
                </Button>
            </li>
        </ul>
    </div>
</template>

<script>



export default {
    methods: {
        onMenuToggle(event) {
            this.$emit("menu-toggle", event);
        },

        logout() {
            this.$router.push("/login");
        },
    },
    computed: {
        darkTheme() {
            return this.$appState.darkTheme;
        },
    },
    components: {},
};
</script>
