import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        pageInfo: [],
        sectionList: [],
        sectionPageInfo: [],
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
        set_section_list: (state, sectionList) => {
            state.sectionList = sectionList;
        },
        set_page_info_section: (state, sectionPageInfo) => {
            state.sectionPageInfo = sectionPageInfo;
        },
        set_chat_list: (state, chatList) => {
            state.chatList.push(chatList);
        },
    },

    actions: {
        get_chat_suite_sections: (context, data) => {
            if(data){
                return axios.get('/api/chat-suite/get-list?term='+data).then((response) => {
                    context.commit('set_list', response.data);
                });
            } else {
                return axios.get('/api/chat-suite/get-list').then((response) => {
                    context.commit('set_list', response.data);
                });
            }
        },
        get_page_info: (context, data) => {
            return axios.get('/api/chat-suite/get-page-info?slug='+data).then((response) => {
                context.commit('set_page_info', response.data);
            });
        },
        get_chat_suite_sections_child: (context, data) => {
            return axios.get('/api/chat-suite/get-section-list?id='+data.id+'&term='+data.term).then((response) => {
                context.commit('set_section_list', response.data);
            });
        },
        get_page_info_section: (context, data) => {
            return axios.get('/api/chat-suite/get-page-info-section?slug='+data).then((response) => {
                context.commit('set_page_info_section', response.data);
            });
        },
        set_user_msg: (context, data) => {
            let user = {
                msg: data.msg,
                user: 'user'
            }
            context.commit('set_chat_list', user);
        },
        chat: (context, data) => {
            return axios.post('/api/chat-suite/chat', data).then((response) => {
                let bot = {
                    msg: response.data,
                    user: 'ai'
                };
                context.commit('set_chat_list', bot);
            });
        },
    },
};
