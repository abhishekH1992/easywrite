import {createStore} from 'vuex'
import chat from './modules/chat';
import subscription from './modules/subscription';
import models from './modules/models';
import documents from './modules/documents';

const store = createStore({
    state: {
        titlex: "Vuex Store"
    },
    getters: {
        auth(state) {
            return state.user
        }
    },
    mutations: {},
    actions: {},
});

store.registerModule('chat', chat);
store.registerModule('subscription', subscription);
store.registerModule('models', models);
store.registerModule('documents', documents);

export default store;