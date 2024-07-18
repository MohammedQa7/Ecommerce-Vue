import './bootstrap';
import 'flowbite';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import App from './app.vue';
import router from './router';

const app = createApp(App);
const Pinia = createPinia();
app.use(router);
app.use(Pinia);
Pinia.use(piniaPluginPersistedstate);


app.mount('#app')