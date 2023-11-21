
import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});


import Message from './components/Message.vue';
app.component('message', Message);


global.jQuery = require('jquery');
var $ = global.jQuery;
window.$ = $;

// axios.defaults.baseURL = 'http://localhost/seoproject/';
// axios.defaults.baseURL = 'https://seoagency.webartsfactory.com/backend/';

app.mount('#app');
