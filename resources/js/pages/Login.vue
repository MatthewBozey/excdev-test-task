<template id="">

    <div class="card p-2 h-screen w-screen flex align-items-center justify-content-center">
        <div class=" w-3/4">
            <div class="flex flex-column gap-3">
                <InputText class="w-full"
                           v-model="userData.email"
                           input-class="w-full"
                           :loading="this.loading"
                           aria-describedby="emailHelp"
                           placeholder="Введите электронную почту"></InputText>
                <Password class="w-full"
                          :loading="this.loading"
                          v-model="userData.password"
                          toogle-mask
                          :feedback="false"
                          input-class="w-full" placeholder="Введите пароль"></Password>
                <Button severity="info"
                        :loading="this.loading"
                        outlined label="Войти"
                        class="w-full" @click="login"></Button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {mapGetters} from "vuex";
import api from "../service/api.js";

export default {
    name: "LoginForm",
    data() {
        return {
            userData: {
                email: "",
                password: ""
            }
        };
    },
    beforeMount() {

    },
    computed: {
        ...mapGetters(['loading'])
    },
    methods: {
        login() {
            api.post('/api/login', this.userData).then(value => {
                const token = value.data.data.token;
                localStorage.setItem('token', token.plainTextToken);
                localStorage.setItem('permissions', token.accessToken.abilities);
                this.$router.push('/balance');
            });
        }
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
