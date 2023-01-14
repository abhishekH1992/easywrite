import * as VueRouter from 'vue-router'
import ChatBox from './components/prompt/ChatBoxComponent.vue'
import Plans from './components/subscription/PlansComponent.vue'
import Subscription from './components/subscription/SubscriptionComponent.vue'

const routes = [
    {
        path: '/plans',
        component: Plans,
        name: 'plans'
    },
    {
        path: '/plans/:plan',
        component: Subscription,
        name: 'subscription'
    },
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