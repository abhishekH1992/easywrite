import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        pageInfo: [],
        chatList: [],
    },

    getters: {},

    mutations: {
        set_list: (state, list) => {
            state.list = list;
        },
        set_page_info: (state, pageInfo) => {
            state.pageInfo = pageInfo;
        },
        set_chat_list: (state, chatList) => {
            state.chatList.push(chatList);
        },
    },

    actions: {
        get_list: (context, data) => {
            if(data){
                return axios.get('/api/free-document-chat/get-list?term='+data).then((response) => {
                    context.commit('set_list', response.data);
                });
            } else {
                return axios.get('/api/free-document-chat/get-list').then((response) => {
                    context.commit('set_list', response.data);
                });
            }
        },
        new_document: (context, data) => {
            return axios.post('/api/free-document-chat/create', data);
        },
        get_page_info: (context, data) => {
            return axios.get('/api/free-document-chat/get-page-info?slug='+data).then((response) => {
                context.commit('set_page_info', response.data);
            });
        },
        set_user_msg: (context, data) => {
            context.commit('set_chat_list', data);
        },
        document_chat: (context, data) => {
            return axios.post('/api/free-document-chat/chat', data).then((response) => {
                let bot = {
                    msg: response.data.data?.text,
                    user: 'ai'
                };
                context.commit('set_chat_list', bot);
            });
        }
    },
};
