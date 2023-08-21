import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        pageInfo: [],
        documentList: [],
        chatList: [],
    },

    getters: {},

    mutations: {
        set_list: (state, list) => {
            state.list = list;
        },
        set_document_list: (state, documentList) => {
            state.documentList = documentList;
        },
        set_page_info: (state, pageInfo) => {
            state.pageInfo = pageInfo;
        },
        set_chat_list: (state, chatList) => {
            state.chatList.push(chatList);
        },
        set_chat_list_initial: (state, chatList) => {
            state.chatList = chatList ? chatList : [];
        },
        set_reset_state: (state) => {
            state.chatList = [];
        },
        set_chat_list_translation: (state, chatList) => {
            state.chatList = chatList;
        },
        set_reset_chat: (state) => {
            state.chatList = [];
        },
    },

    actions: {
        get_documents: (context, data) => {
            if(data){
                return axios.get('/api/documents/get-documents?term='+data).then((response) => {
                    context.commit('set_list', response.data);
                });
            } else {
                return axios.get('/api/documents/get-documents').then((response) => {
                    context.commit('set_list', response.data);
                });
            }
        },
        new_document: (context, data) => {
            return axios.post('/api/documents/create', data);
        },
        get_documents_info: (context, data) => {
            return axios.post('/api/documents/page-info', data).then((response) => {
                context.commit('set_page_info', response.data);
                context.commit('set_chat_list_initial', JSON.parse(response.data.list));
            });
        },
        upload_file: (context, data) => {
            return axios.post('/api/documents/upload-document', data);
        },
        get_document_list: (context, data) => {
            return axios.get('/api/documents/get-document-list?documentid='+data).then((response) => {
                context.commit('set_document_list', response.data);
            });
        },
        remove_document_file: (context, data) => {
            return axios.post('/api/documents/remove', data);
        },
        set_user_msg: (context, data) => {
            context.commit('set_chat_list', data);
        },
        document_chat: (context, data) => {
            return axios.post('/api/documents/chat', data).then((response) => {
                let bot = {
                    msg: response.data.data?.text,
                    user: 'ai'
                };
                context.commit('set_chat_list', bot);
            });
        },
        reset_state: (context, data) => {
            context.commit('set_reset_state');
        },
        remove_document: (context, data) => {
            return axios.post('/api/documents/destroy', data);
        },
        translate_chat: (context, data) => {
            return axios.post('/api/chat/translate', data).then((response) => {
                let list = context.state.chatList;
                list.map((l, key) => {
                    if (key == data.key) {
                        let translate = '\n\nTranslation to '+ data.language.name +' language:\n';
                        translate = translate + response.data;
                        list[key].msg = l.msg + translate;
                    }
                });
                context.commit('set_chat_list_translation', list);
            });
        },
        save: (context, data) => {
            return axios.post('/api/documents/save', data);
        },
        clean_chat: (context, data) => {
            context.commit('set_reset_chat');
        },
    },
};
