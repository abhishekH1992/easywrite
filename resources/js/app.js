import './bootstrap';

import {createApp} from 'vue'
import store from './store'
import router from './routes'

import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
import Notifications from '@kyvg/vue3-notification'

import SideNav from './components/design/SideNav.vue'

const app = createApp({})
window.url = '/'

app.component('side-nav', SideNav)

app.use(store)
app.use(Notifications)
app.use(router)

app.mount('#app')