<script>

import api from "../service/api.js";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Balance",
    created() {
        this.getBalance();
        this.interval = setInterval(this.getBalance, 30000);
    },
    computed: {
        ...mapGetters(['user_info'])
    },
    mounted() {

    },
    methods: {
        ...mapActions(['saveUserInfo']),
        getBalance() {
            api.get('/api/users/balance').then(value => this.saveUserInfo(value.data.data));
        }
    },
    beforeUnmount() {
        clearInterval(this.interval);
    }
}
</script>

<template>
    <div class="p-1" style="">
        <div class="card ">
            <div class="flex justify-between align-items-center">
                <div><h1 class="">Баланс</h1></div>
                <div><h1 v-text="user_info?.balance?.balance + ' ₽'"></h1></div>
            </div>
        </div>

        <div class="card " v-for="item in (this.user_info?.balance_operation_group ?? [])" :key="item.name">
            <div
                 class="flex justify-between align-items-center">
                <div><h1 class="" v-text="item.name"></h1></div>
                <div><h1 v-text="item.count"></h1></div>
            </div>
        </div>

        <div class="card">
            <div class="flex justify-between items-center mb-6">
                <div class=""><h1>Последние операции</h1></div>
            </div>
            <ul class="list-none">
                <li v-for="item in (this.user_info?.balance_operation ?? [])" :key="item.id"
                    class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div class="">
                        <h4 class="" v-text="item.operation_type?.title"></h4>
                        <h6 v-text="item.description"></h6>
                        <small class="" style="color: lightgray" v-text="item.operation_date"></small>
                    </div>
                    <div class="flex items-center">
                        <h2 v-text="item.amount + ' ₽' "
                            :style="{color: item.operation_type.name === 'credit' ? 'green' : 'red'}"></h2>
                    </div>
                </li>

            </ul>
        </div>

    </div>

</template>

<style>
.balance-row {
    display: flex;
    justify-content: center;
    align-items: center;
    justify-items: center;
}

.balance-card {
    display: flex;
    padding: 2rem;
}
</style>
