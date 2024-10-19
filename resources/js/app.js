import './bootstrap';

import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import App from './pages/AppWrapper.vue';
import 'primeflex/primeflex.css';
import 'primeicons/primeicons.css';
import './assets/styles/layout.scss';
import router from "./router.js";



const app = createApp(App);
app.use(PrimeVue);
app.use(router);

app.mount('#app')

