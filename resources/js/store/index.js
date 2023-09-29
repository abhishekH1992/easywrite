import {createStore} from 'vuex'
import chat from './modules/chat';
import subscription from './modules/subscription';
import models from './modules/models';
import documents from './modules/documents';
import speech from './modules/speech';
import chatSuite from './modules/chatSuite';
import finetune from './modules/finetune';
import freeDocumentChat from './modules/freeDocumentChat';

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
store.registerModule('speech', speech);
store.registerModule('chatSuite', chatSuite);
store.registerModule('finetune', finetune);
store.registerModule('freeDocumentChat', freeDocumentChat);

export default store;