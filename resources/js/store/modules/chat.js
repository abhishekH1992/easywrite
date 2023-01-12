import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        prompt: '',
        pageName: '',
        pageImg: '',
        preText: '',
        placeholder: '',
        prefix: '',
        divider: '',
        aiprefix: '',
        style: '',
        isTextarea: 0,
        textareaChat: '',
    },

    getters: {},

    mutations: {
        set_chat: (state, list) => {
            state.list.push(list);
        },
        set_prompt: (state, prompt) => {
            state.prompt = state.prompt+'\n'+prompt;
        },
        set_page_name: (state, pageName) => {
            state.pageName = pageName;
        },
        set_page_img: (state, pageImg) => {
            state.pageImg = pageImg;
        },
        set_page_pre_text: (state, preText) => {
            state.preText = preText;
        },
        set_page_placeholder: (state, placeholder) => {
            state.placeholder = placeholder;
        },
        set_page_prefix: (state, prefix) => {
            state.prefix = prefix;
        },
        set_page_divider: (state, divider) => {
            state.divider = divider;
        },
        set_page_ai_prefix: (state, aiprefix) => {
            state.aiprefix = aiprefix;
        },
        set_page_style: (state, style) => {
            state.style = style;
        },
        set_page_is_textarea: (state, isTextarea) => {
            state.isTextarea = isTextarea;
        },
        set_page_textarea_chat: (state, textareaChat) => {
            state.textareaChat = textareaChat;
        },
        set_reset_state: (state) => {
            state.list = [];
            state.prompt = '';
            state.pageName = '';
            state.pageImg = '';
            state.pageImg = '';
            state.preText = '';
            state.placeholder = '';
            state.prefix = '';
            state.divider = '';
            state.aiprefix = '';
            state.style = '';
            state.isTextarea = '';
            state.textareaChat = '';
        }
    },

    actions: {
        chat: (context, data) => {
            if(data.history){
                if (data.isTextarea){
                    context.commit('set_page_textarea_chat', data.msg);
                } else {
                    context.commit('set_prompt', data.msg);
                }
                data.msg = context.state.prompt+context.state.divider+data.msg;
            }
            return axios.post('/api/chat/chat', data).then((response) => {
                let bot = {
                    msg: response.data,
                    user: 'ai'
                };
                if (data.isTextarea){
                    console.log(context.state.textareaChat+response.data);
                    context.commit('set_page_textarea_chat', context.state.textareaChat+response.data);
                } else {
                    context.commit('set_prompt', context.state.aiprefix+response.data);
                    context.commit('set_chat', bot);
                }
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
        reset_state: (context, data) => {
            context.commit('set_reset_state');
        }
    },
};
