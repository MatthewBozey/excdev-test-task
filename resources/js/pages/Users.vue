<script>
import api from "../service/api.js";
import {mapActions, mapGetters} from "vuex";
import CustomDialog from "../components/CustomDialog.vue";

export default {
    name: "Users",
    components: { CustomDialog },
    data() {
        return {
            dialog: {
                showing: false,
                user: {},
                fields: [
                    {type: 'text', name: 'name', title: 'Имя'},
                    {type: 'text', name: 'email', title: 'Электронная почта'},
                    {type: 'password', name: 'password', title: 'Пароль'},
                    {type: 'password', name: 'password_confirmation', title: 'Повторите пароль'},
                ],
                title: ''
            }
        }
    },
    created() {
        api.get('/api/users').then(value => this.saveUsers(value.data.data));
    },
    computed: {
        ...mapGetters(['users', 'loading'])
    },
    methods: {
        ...mapActions(['saveUsers', 'pushUser', 'replaceUser', 'deleteUserById']),

        addUser() {
            this.dialog.title = 'Добавление пользователя';
            this.dialog.showing = true;

            this.dialog.applyFunction = (event) => {
                this.$confirm.require({
                    target: event.currentTarget,
                    message: `Вы действительно хотите создать пользователя с введенными данными?`,
                    header: "Подтверждение создания",
                    accept: () => {
                        api.post('/api/users', this.dialog.user).then((value) => {
                            this.$notification.success('Пользователь успешно создан');
                            this.dialog.showing = false;
                            this.pushUser(value.data.data);
                        });
                    },
                    onHide: () => {},
                    acceptClass: 'p-button-success',
                    rejectClass: 'p-button-danger p-button-text'
                });
            }

            this.dialog.cancelFunction = (event) => {
                this.$confirm.require({
                    target: event.currentTarget,
                    message: `Вы действительно хотите отменить создание пользователя?`,
                    header: "Подтверждение отмены",
                    accept: () => {
                        this.$nextTick(() => {
                           this.dialog.showing = false;
                           this.dialog.user = {};
                        });
                    },
                    onHide: () => {},
                    acceptClass: 'p-button-success',
                    rejectClass: 'p-button-danger p-button-text'
                });
            }
        },

        editUser(event, userId) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы действительно хотите отредактировать данные пользователя?`,
                header: "Подтверждение редактирования",
                accept: () => {
                    this.dialog.title = 'Редактирование пользователя';
                    this.dialog.showing = true;
                    api.get('/api/users/' + userId).then(value => {
                        this.dialog.user = value.data.data;
                    });
                    this.dialog.applyFunction = (event) => {
                        this.$confirm.require({
                            target: event.currentTarget,
                            message: `Вы действительно хотите создать пользователя с введенными данными?`,
                            header: "Подтверждение создания",
                            accept: () => {
                                api.put('/api/users/' + userId, this.dialog.user).then((value) => {
                                    this.$notification.success('Данные пользователя успешно отредактированы');
                                    this.dialog.showing = false;
                                    this.replaceUser(value.data.data);
                                });
                            },
                            onHide: () => {},
                            acceptClass: 'p-button-success',
                            rejectClass: 'p-button-danger p-button-text'
                        });
                    }
                    this.dialog.cancelFunction = (event) => {
                        this.$confirm.require({
                            target: event.currentTarget,
                            message: `Вы действительно хотите отменить редактирования пользователя?`,
                            header: "Подтверждение отмены",
                            accept: () => {
                                this.$nextTick(() => {
                                    this.dialog.showing = false;
                                    this.dialog.user = {};
                                });
                            },
                            onHide: () => {},
                            acceptClass: 'p-button-success',
                            rejectClass: 'p-button-danger p-button-text'
                        });
                    }
                },
                onHide: () => {},
                acceptClass: 'p-button-success',
                rejectClass: 'p-button-danger p-button-text'
            });

        },

        deleteUser(event, data) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы действительно хотите удалить пользователя?`,
                header: "Подтверждение удаления",
                accept: () => {
                    api.delete('/api/users/' + data.id).then(() => {
                        this.$notification.success('Пользователь успешно удален');
                        this.deleteUserById(data);
                    });
                },
                onHide: () => {},
                acceptClass: 'p-button-success',
                rejectClass: 'p-button-danger p-button-text'
            });
        }
    },
}
</script>

<template>
    <div class="card p-1">

        <CustomDialog :title="dialog.title" :show-dialog="dialog.showing"
                      :cancel-function="dialog.cancelFunction"
                      :apply-function="dialog.applyFunction"
                      :fields="dialog.fields"
                      :row="dialog.user"></CustomDialog>
        <DataTable :value="users" :loading="loading">
            <template v-slot:loading v-text="'Происходит загрузка данных. Пожалуйста, подождите'"></template>
            <template v-slot:header>
                <Toolbar>
                    <template v-slot:start>
                        <Button icon="pi pi-plus" outlined text severity="success" @click="addUser"></Button>
                    </template>
                </Toolbar>
            </template>
            <Column field="id" header="ID"/>
            <Column field="name" header="Имя"/>
            <Column field="email" header="Электронная почта"/>
            <Column field="balance.balance" header="Баланс"/>
            <Column>
                <template v-slot:body="slot">
                    <div class="flex justify-evenly">
                        <Button severity="warn" text outlined icon="pi pi-pencil" @click="editUser($event, slot.data.id)"></Button>
                        <Button severity="danger" text ourlined icon="pi pi-trash" @click="deleteUser($event, slot.data)"></Button>
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<style >

</style>
