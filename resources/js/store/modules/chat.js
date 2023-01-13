import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        prompt: '',
        pageInfo: [],
    },

    getters: {},

    mutations: {
        set_chat: (state, list) => {
            state.list.push(list);
        },
        set_prompt: (state, prompt) => {
            state.prompt = state.prompt+prompt;
        },
        set_page_info: (state, pageInfo) => {
            state.pageInfo = pageInfo;
        },
        set_reset_state: (state) => {
            state.list = [];
            state.prompt = '';
            state.pageInfo = [];
        },
    },

    actions: {
        chat: (context, data) => {
            if(data.history){
                context.commit('set_prompt',data.msg);
                data.msg = context.state.prompt;
            }
            console.log(data.msg);
            return axios.post('/api/chat/chat', data).then((response) => {
                let res = context.state.pageInfo.aiprefix != null ? context.state.pageInfo.aiprefix+' '+response.data : response.data;
                let bot = {
                    msg: res,
                    user: 'ai'
                };
                context.commit('set_prompt', res);
                context.commit('set_chat', bot);
            });
        },
        chat_textarea: (context, data) => {
            return axios.post('/api/chat/chat', data);
        },
        set_user_msg: (context, data) => {
            let user = {
                msg: data.msg,
                user: 'user'
            }
            context.commit('set_chat', user);
        },
        page_info: (context, data) => {
            return axios.post('/api/chat/page-info', data).then((response) => {
                context.commit('set_page_name', response.data.name);
                context.commit('set_page_img', response.data.img);
                context.commit('set_page_pre_text', response.data.pretext);
                context.commit('set_page_placeholder', response.data.placeholder);
                context.commit('set_page_prefix', response.data.prefix);
                context.commit('set_page_divider', response.data.divider);
                context.commit('set_prompt', response.data.pretext);
                context.commit('set_page_ai_prefix', response.data.aiprefix);
                context.commit('set_page_style', response.data.style);
                context.commit('set_page_is_textarea', response.data.isTextarea);
                context.commit('set_page_textarea_chat', response.data.pretext);
            });
        },
        page_textarea_pretext: (context, data) => {
            return axios.post('/api/chat/page-info', data);
        },

        get_page_info: (context, data) => {
            return axios.post('/api/chat/page-info', data).then((response) => {
                context.commit('set_page_info', response.data);
            });
        },
        reset_state: (context, data) => {
            context.commit('set_reset_state');
        },
    },
};
