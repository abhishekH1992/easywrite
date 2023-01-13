import * as VueRouter from 'vue-router'
import ChatBox from './components/prompt/ChatBoxComponent.vue'

const routes = [
    {
        path: '/model/:prompt',
        component: ChatBox,
        name: 'chatBox'
    },
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/'),
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
})

export default router;