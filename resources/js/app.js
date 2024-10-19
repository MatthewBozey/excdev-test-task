import './bootstrap';

import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import App from './pages/AppWrapper.vue';
import 'primeflex/primeflex.css';
import 'primeicons/primeicons.css';
import './assets/styles/layout.scss';
import router from "./router.js";
import store from './store';
import Aura from '@primevue/themes/aura';



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

app.mount('#app')

