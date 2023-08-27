import * as VueRouter from 'vue-router'
import store from './store'
import ChatBox from './components/prompt/ChatBoxComponent.vue'
import Plans from './components/subscription/PlansComponent.vue'
import Subscription from './components/subscription/SubscriptionComponent.vue'
import Billing from './components/subscription/BillingComponent.vue'
import Dashboard from './components/prompt/DashboardComponent.vue'
import Archive from './components/prompt/ArchiveComponent.vue'
import DocumentsList from './components/documents/DocumentsListComponent.vue'
import SavedDocument from './components/documents/SavedDocumentComponent.vue'
import CustomChatList from './components/custom/CustomChatComponent.vue'
import SpeechToText from './components/speech/SpeechToTextComponent.vue'
import SavedSpeechToText from './components/speech/SavedSpeechToTextComponent.vue'

import isSubscribed from './middleware/isSubscribed'
import isValidPlanSelected from './middleware/isValidPlanSelected'
import isLoggedInUser from './middleware/isLoggedInUser'

const routes = [
    {
        path: '/',
        component: Dashboard,
        name: 'dashboard',
        meta: {
            middleware: isLoggedInUser,
        },
    },
    {
        path: '/archive',
        component: Archive,
        name: 'archive'
    },
    {
        path: '/plans',
        component: Plans,
        name: 'plans',
        meta: {
            middleware: isLoggedInUser,
        },
    },
    {
        path: '/subscription',
        component: Subscription,
        name: 'subscription',
        meta: {
            middleware: [isLoggedInUser, isValidPlanSelected],
        },
    },
    {
        path: '/manage-billing',
        component: Billing,
        name: 'billing',
        meta: {
            middleware: isLoggedInUser,
        },
    },
    {
        path: '/documents',
        component: DocumentsList,
        name: 'documentsList',
        meta: {
            middleware: isSubscribed,
        },
    },
    {
        path: '/documents/:documentid',
        component: SavedDocument,
        name: 'savedDocument',
        meta: {
            middleware: isSubscribed,
        },
    },
    {
        path: '/custom-chat',
        component: CustomChatList,
        name: 'customChatList',
        meta: {
            middleware: isSubscribed,
        },
    },
    {
        path: '/model/:prompt',
        component: ChatBox,
        name: 'chatBox',
        meta: {
            middleware: isSubscribed,
        },
    },
    {
        path: '/model/:prompt/:id',
        component: ChatBox,
        name: 'savedChatBox',
        meta: {
            middleware: isSubscribed,
        },
    },
    {
        path: '/custom-chat/:prompt',
        component: ChatBox,
        name: 'customChatBox',
        meta: {
            middleware: isSubscribed,
        },
    },
    {
        path: '/custom-chat/:prompt/:id',
        component: ChatBox,
        name: 'savedCustomChatBox',
        meta: {
            middleware: isSubscribed,
        },
    },
    {
        path: '/speech-to-text',
        component: SpeechToText,
        name: 'speechToText',
        meta: {
            middleware: isSubscribed,
        },
    },
    {
        path: '/speech-to-text/:id',
        component: SavedSpeechToText,
        name: 'savedSpeechToText',
        meta: {
            middleware: isSubscribed,
        },
    },
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/'),
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
})

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = Array.isArray(to.meta.middleware) ? to.meta.middleware : [to.meta.middleware];
    const context = {
        to,
        from,
        next,
        store
    }
    return middleware[0]({
        ...context
    })
})

export default router;