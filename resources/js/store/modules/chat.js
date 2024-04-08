import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        prompt: '',
        pageInfo: [],
        tone: '',
        language: '',
        toneList: [],
        languageList: [],
        translateLanguage: [],
        suggestions: [],
    },

    getters: {},

    mutations: {
        set_chat: (state, list) => {
            state.list.push(list);
        },
        set_chat_list: (state, list) => {
            state.list = list;
        },
        set_reset_chat: (state) => {
            state.list = [];
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
            state.suggestions = [];
        },
        set_tone: (state, tone) => {
            state.tone = tone;
        },
        set_language: (state, language) => {
            state.language = language;
        },
        set_tone_list: (state, toneList) => {
            state.toneList = toneList;
        },
        set_language_list: (state, languageList) => {
            state.languageList = languageList;
        },
        set_translate_language: (state, translateLanguage) => {
            state.translateLanguage = translateLanguage;
        },
        set_suggestions: (state, suggestions) => {
            state.suggestions = suggestions;
        },
    },

    actions: {
        chat: (context, data) => {
            if(data.history){
                context.commit('set_prompt',data.msg);
                data.msg = context.state.prompt;
            }
            return axios.post('/api/chat/chat', data).then((response) => {
                let res = context.state.pageInfo.aiprefix != null ? context.state.pageInfo.aiprefix+' '+response.data : response.data;
                if(data.isPythonSuggestions) {
                    context.commit('set_suggestions', res.suggestions);
                } else if(data.isPython && res.text) {
                    let bot = {
                        msg: res.text,
                        user: 'ai',
                        related: res.related_questions
                    };
                    context.commit('set_prompt', res);
                    context.commit('set_chat', bot);
                } else {
                    let bot = {
                        msg: res,
                        user: 'ai'
                    };
                    context.commit('set_prompt', res);
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

        get_page_info: (context, data) => {
            return axios.post('/api/chat/page-info', data).then((response) => {
                context.commit('set_page_info', response.data);
            });
        },
        reset_state: (context, data) => {
            context.commit('set_reset_state');
        },
        clean_chat: (context, data) => {
            context.commit('set_reset_chat');
            context.commit('set_prompt', '');
            context.commit('set_suggestions', []);
        },
        save: (context, data) => {
            return axios.post('/api/chat/save', data);
        },
        get_user_chat: (context, data) => {
            return axios.get('/api/chat/get-user-chat?id='+data.id);
        },
        set_user_chat: (context, data) => {
            context.commit('set_reset_chat');
            context.commit('set_chat_list', data);
        },
        delete_user_chat: (context, data) => {
            return axios.post('/api/chat/destroy', data);
        },
        get_tone_list: (context, data) => {
            return axios.get('/api/site/get-tone-list').then((response) => {
                context.commit('set_tone_list', response.data);
            });
        },
        get_language_list: (context, data) => {
            return axios.get('/api/site/get-language-list').then((response) => {
                context.commit('set_language_list', response.data);
            });
        },
        translate_chat: (context, data) => {
            return axios.post('/api/chat/translate', data).then((response) => {
                let list = context.state.list;
                list.map((l, key) => {
                    if (key == data.key) {
                        let translate = '\n\nTranslation to '+ data.language.name +' language:\n';
                        translate = translate + response.data;
                        list[key].msg = l.msg + translate;
                    }
                });
                context.commit('set_chat_list', list);
            });
        },
        translate_language: (context, data) => {
            return axios.post('/api/chat/translate/language', data).then((response) => {
                context.commit('set_translate_language', response.data);
            });
        }
    },
};
