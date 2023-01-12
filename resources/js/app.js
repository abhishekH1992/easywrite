import './bootstrap';

import {createApp} from 'vue'
import store from './store'
import router from './routes'

import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

import SideNav from './components/design/SideNav.vue'

const app = createApp({})
window.url = '/'

app.component('side-nav', SideNav)

app.use(store)
app.use(router)

app.mount('#app')