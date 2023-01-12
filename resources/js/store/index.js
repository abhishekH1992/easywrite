import {createStore} from 'vuex'
import chat from './modules/chat';

const store = createStore({
    state: {
        titlex: "Vuex Store"
    },
    getters: {},
    mutations: {},
    actions: {},
});

store.registerModule('chat', chat);

export default store;