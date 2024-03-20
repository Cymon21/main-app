import './bootstrap';
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import Toaster from "@meforma/vue-toaster";



const app = createApp({});

app.component("font-awesome-icon", FontAwesomeIcon);
app.component('example-component', ExampleComponent);

app.use(Toaster);
app.mount('#app');
