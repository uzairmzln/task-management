import './bootstrap';
import { createApp } from 'vue';
import router from './router/index.js';
import App from './components/app.vue';
// Vuetify
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

import '@mdi/font/css/materialdesignicons.css'

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
  },
})

const app = createApp(App);
app.use(router);
app.use(vuetify);
app.mount('#App');
