
import './bootstrap';
import { createApp } from 'vue';
import ElementPlus from 'element-plus';
import { createPinia } from 'pinia'

const pinia = createPinia();
const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

app.use(ElementPlus);
app.use(pinia)
app.mount('#app');
