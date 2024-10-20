<script>
import api from "../service/api.js";
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import CustomDialog from "../components/CustomDialog.vue";

export default {
    name: "Operations",
    components: {CustomDialog},
    data() {
        return {
            filter: {
                operation_type_id: null,
                amount: null,
                description: null,
                operation_date: null
            },
            dialog: {
                showing: false,
                operation: {},
                fields: [
                    {type: 'number', name: 'amount', title: 'Сумма операции', binds: {mode: "currency", currency: "RUB", locale: "ru-RU"}},
                    {type: 'select', name: 'operation_type_id', title: 'Тип операции', binds: {options: this.operation_type, optionValue: 'id', optionLabel: 'title'}},
                    {type: 'textarea', name: 'description', title: 'Описание операции', binds: {rows: 5, autoResize: true}}
                ]
            }
        }
    },
    async created() {
        await this.getOperationTypeData();
        await this.filterHandler();
        this.interval = setInterval(this.filterHandler, 60000);
    },
    computed: {
        ...mapGetters(['balance_operation', 'loading', 'operation_type'])
    },
    beforeUnmount() {
        clearInterval(this.interval);
    },
    methods: {
        ...mapActions(['saveOperations', 'appendOperation', 'saveOperationTypes']),

        getColorByOperationType(operation) {
            switch (operation) {
                case 'debit':
                    return'red';
                case 'credit':
                    return 'green';
                default:
                    return 'gray';
            }
        },

        filterHandler() {
            if (this.filter.operation_date !== null) {
                this.filter.operation_date = moment(this.filter.operation_date).format('YYYY-MM-DD');
            }
            const f = Object.fromEntries(
                Object.entries(this.filter).filter(
                    ([key, value]) => (value !== null && value !== "" && value !== undefined)
                )
            );

            api.get('/api/balance-operation', { params: f}).then(value => this.saveOperations(value.data.data))
        },

        addOperation() {
            const operationIndex = this.dialog.fields.findIndex(f => f.name === 'operation_type_id');
            if (operationIndex !== -1) {
                this.dialog.fields[operationIndex].binds.options = this.operation_type;
                this.dialog.showing = true;
                this.dialog.title = 'Добавление операции';
                this.dialog.applyFunction = (event) => {
                    this.$confirm.require({
                        target: event.currentTarget,
                        message: `Вы действительно хотите выполнить данную операцию?`,
                        header: "Подтверждение операции",
                        accept: () => {
                            api.post('/api/balance-operation', this.dialog.operation)
                                .then(() => {
                                    this.dialog.operation = {};
                                    this.dialog.showing = false;
                                    this.$notification.success('Операция отправлена на обработку');
                                })
                        },
                        onHide: () => {},
                        acceptClass: 'p-button-success',
                        rejectClass: 'p-button-danger p-button-text'
                    });
                };
                this.dialog.cancelFunction = (event) => {
                    this.$confirm.require({
                        target: event.currentTarget,
                        message: `Вы действительно хотите отменить данную операцию?`,
                        header: "Подтверждение отмены операции",
                        accept: () => {
                            this.$nextTick(() => this.dialog.showing = false);
                        },
                        onHide: () => {},
                        acceptClass: 'p-button-success',
                        rejectClass: 'p-button-danger p-button-text'
                    });
                };
            }

        },

        getOperationTypeData() {
            api.get('/api/operation-type').then(value => this.saveOperationTypes(value.data.data));
        },
    },
}
</script>

<template>
    <div class="card p-1">
        <CustomDialog :show-dialog="dialog.showing"
                      :title="dialog.title"
                      :apply-function="dialog.applyFunction"
                      :cancel-function="dialog.cancelFunction"
                      :row="dialog.operation"
                      @show="getOperationTypeData"
                      :fields="dialog.fields"></CustomDialog>
        <DataTable :value="this.balance_operation" :loading="loading" filter-display="row" >
            <template v-slot:loading>Происходит загрузка данных. Пожалуйста, подождите</template>
            <template v-slot:header>
                <Toolbar>
                    <template v-slot:start>
                        <Button severity="success" icon="pi pi-plus" text outlined @click="addOperation"></Button>
                    </template>
                </Toolbar>
            </template>
            <Column field="id" header="ID"></Column>
            <Column header="Тип операции" :show-filter-menu="false" :show-filter-match-modes="false">
                <template v-slot:body="slot">
                    <p
                        :style="{color: this.getColorByOperationType(slot.data?.operation_type?.name)}"
                        v-text="slot.data?.operation_type?.title"></p>
                </template>
                <template v-slot:filter>
                    <Select :options="this.operation_type" class="w-full"
                            show-clear
                            v-model="filter.operation_type_id"
                            placeholder="Тип операции" @change="filterHandler"
                            optionValue="id" optionLabel="title"></Select>
                </template>
            </Column>
            <Column header="Сумма" :show-filter-menu="false" :show-filter-match-modes="false">
                <template v-slot:body="slot">
                    <p
                        :style="{color: this.getColorByOperationType(slot.data?.operation_type?.name)}"
                        v-text="slot.data?.amount"></p>
                </template>
                <template v-slot:filter>
                    <InputText v-model="filter.amount" @change="filterHandler" placeholder="Сумма" ></InputText>
                </template>
            </Column>
            <Column field="description" header="Описание"  :show-filter-menu="false" :show-filter-match-modes="false">
                <template v-slot:filter>
                    <InputText v-model="filter.description" @change="filterHandler" placeholder="Описание"/>
                </template>
            </Column>
            <Column field="operation_date" header="Дата" :show-filter-menu="false" :show-filter-match-modes="false">
                <template v-slot:filter>
                    <DatePicker v-model="filter.operation_date" placeholder="Дата операции" showButtonBar
                                @update:modelValue="filterHandler" dateFormat="yy/mm/dd"></DatePicker>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<style scoped>

</style>
