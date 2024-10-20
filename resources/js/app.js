import './bootstrap';

import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import App from './pages/AppWrapper.vue';
import 'primeflex/primeflex.css';
import 'primeicons/primeicons.css';
import './assets/styles/layout.scss';
import "vue-toastification/dist/index.css";
import router from "./router.js";
import store from './store';
import Aura from '@primevue/themes/aura/';
import Toasting, {useToast} from "vue-toastification";
import ConfirmationService from 'primevue/confirmationservice';



const app = createApp(App);
app.use(PrimeVue, {
    // Default theme configuration
    theme: {
        preset: Aura,
        options: {
            prefix: 'p',
            darkModeSelector: 'system',
            cssLayer: false
        }
    }
});
app.use(router);
app.use(store);
app.use(Toasting, {
    transition: 'Vue-Toastification__bounce',
    maxToasts: 30,
    newestOnTop: true,
    timeout: 15000,
    closeButton: false,
    closeOnClick: false,
});
app.use(ConfirmationService);
app.config.globalProperties.$notification = useToast()
app.mount('#app')

