import {createStore} from 'vuex'
import chat from './modules/chat';
import subscription from './modules/subscription';

const store = createStore({
    state: {
        titlex: "Vuex Store"
    },
    getters: {},
    mutations: {},
    actions: {},
});

store.registerModule('chat', chat);
store.registerModule('subscription', subscription);

export default store;