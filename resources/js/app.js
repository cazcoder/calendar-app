import './bootstrap';

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import { i18nVue } from 'laravel-vue-i18n';

import Notifications from 'notiwind'
import "vue-search-select/dist/VueSearchSelect.css"

const app = createApp(App)

app.use(router)
app.use(createPinia())
app.use(Notifications);

app.use(i18nVue, { 
   resolve: async lang => {
       const langs = import.meta.glob('../../lang/*.json');
       return await langs[`../../lang/${lang}.json`]();
   }
})

app.mount('#app')
