import * as VueRouter from 'vue-router'
import ChatBox from './components/prompt/ChatBoxComponent.vue'
import CommonBox from './components/prompt/CommonBoxComponent.vue'

const routes = [
    {
        path: '/model/freechat',
        component: ChatBox,
        name: 'chatBox'
    },
    {
        path: '/model/:prompt',
        component: CommonBox,
        name: 'commonBox'
    },
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/'),
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
})

export default router;