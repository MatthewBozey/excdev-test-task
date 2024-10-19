<script>
import api from "../service/api.js";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Users",
    created() {
        api.get('/api/users').then(value => this.saveUsers(value.data.data));
    },
    computed: {
        ...mapGetters(['users', 'loading'])
    },
    methods: {
        ...mapActions(['saveUsers'])
    },
}
</script>

<template>
    <div class="card p-1">
        <DataTable :value="users" :loading="loading">
            <Column field="id" header="ID"/>
        </DataTable>
    </div>
</template>

<style >

</style>
