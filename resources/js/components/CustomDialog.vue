<script>
import Dialog from 'primevue/dialog'
import IftaLabel from 'primevue/iftalabel'
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import InputOtp from 'primevue/inputotp'
import DatePicker from 'primevue/datepicker'
import Password from 'primevue/password'
import Select from 'primevue/select'
import MultiSelect from 'primevue/multiselect'
import Textarea from 'primevue/textarea'
import ToggleSwitch from 'primevue/toggleswitch'
import InputMask from 'primevue/inputmask'

export default {
    name: 'CustomDialog',
    data() {
        return {}
    },
    components: {
        Dialog,
        IftaLabel,
        InputText,
        InputNumber,
        InputOtp,
        DatePicker, Password, Select, MultiSelect, Textarea, ToggleSwitch, InputMask
    },
    computed: {
        rowData: {
            get() {
                return this.row;
            },
            set(value) {
                this.$emit("update:rowValue", value);
            }
        }
    },
    props: {
        showDialog: {
            type: Boolean,
            default: false
        },
        isModal: {
            type: Boolean,
            default: true
        },
        dialogStyle: {
            type: Object,
            default: {width: '50vw'}
        },
        title: {
            type: String,
            default: ''
        },

        cancelButtonText: {
            type: String,
            default: 'Отменить'
        },

        applyButtonText: {
            type: String,
            default: 'Сохранить'
        },

        dialogPosition: {
            type: String,
            default: 'top',

        },

        row: {
            type: Object,
            default: {}
        },

        fields: {
            type: Array,
            default: [],
        },

        applyFunction: {
            type: Function,
            default: () => {
            }
        },

        cancelFunction: {
            type: Function,
            default: () => {
            }

        },
    },
    methods: {
        getComponentType(type) {
            switch (type) {
                case 'text':
                    return 'InputText';
                case 'number':
                    return 'InputNumber';
                case 'code':
                    return 'InputOtp';
                case 'date':
                    return 'DatePicker';
                case 'password':
                    return 'Password';
                case 'select':
                    return 'Select';
                case 'multiselect':
                    return 'MultiSelect';
                case 'textarea':
                    return 'Textarea';
                case 'mask':
                    return 'InputMask';
                default:
                    return 'InputText';
            }
        },

        cancel(event) {
            this.$emit('cancelButtonClick', event)
        }
    },

}

</script>

<template>
    <Dialog v-model:visible="$props.showDialog" :style="dialogStyle" :modal="$props.isModal"
            :position="$props.dialogPosition" :closable="false">
        <template v-slot:header>
            <h5 class="p-dialog-title">{{ $props.title }}</h5>
        </template>
        <template v-slot:footer>
            <div class="flex flex-row gap-2">
                <Button severity="danger" text outlined :label="$props.cancelButtonText"
                        @click="$props.cancelFunction"/>
                <Button severity="success" outlined :label="$props.applyButtonText" @click="$props.applyFunction"/>
            </div>
        </template>
        <div class="p-dialog-content w-full p-1 ">
            <div v-for="field in $props.fields" :key="field.name" class="flex flex-column gap-2 p-1">
                <IftaLabel class="m-2" v-if="!['checkbox', 'code', 'toggle'].includes(field.type)">
                    <component
                        :is="getComponentType(field.type)"
                        :id="field.name"
                        class="w-full"
                        v-bind="field.binds"
                        :style="field.style"
                        v-model="rowData[field.name]"
                        fluid
                    ></component>
                    <label :for="field.name" v-text="field.title"></label>
                </IftaLabel>
                <div class="flex flex-row gap-2 m-2 justify-content-center" v-if="field.type === 'checkbox'">
                    <Checkbox :inputId="field.name" class="" v-model="rowData[field.name]" v-bind="field.binds"/>
                    <label :for="field.name" v-text="field.title"></label>
                </div>
                <div class="flex flex-row gap-2 m-2 justify-content-center" v-if="field.type === 'toggle'">
                    <ToggleSwitch :inputId="field.name" class="" v-model="rowData[field.name]"/>
                    <label :for="field.name" v-text="field.title"></label>
                </div>
                <div class="flex flex-column gap-2 m-2 w-full" v-if="field.type === 'code'">
                    <label :for="field.name" v-text="field.title" class="ml-2"></label>
                    <InputOtp :inputId="field.name" class="flex justify-content-center" v-bind="field.binds" v-model="rowData[field.name]"/>
                </div>
            </div>
        </div>
    </Dialog>
</template>

<style scoped>

</style>
