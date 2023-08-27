import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        pageInfo: [],
        chatList: [],
        audioList: [],
        translateLanguage: [],
    },

    getters: {},

    mutations: {
        set_list: (state, list) => {
            state.list = list;
        },
        set_page_info: (state, pageInfo) => {
            state.pageInfo = pageInfo;
        },
        set_chat_list_initial: (state, chatList) => {
            state.chatList = chatList ? chatList : [];
        },
        set_chat_list: (state, chatList) => {
            state.chatList.push(chatList);
        },
        set_audio_list: (state, audioList) => {
            state.audioList = audioList ? audioList : [];
        },
        set_reset_chat: (state) => {
            state.chatList = [];
        },
        set_translate_language: (state, translateLanguage) => {
            state.translateLanguage = translateLanguage;
        },
    },

    actions: {
        get_speech_to_text: (context, data) => {
            if(data){
                return axios.get('/api/speech-to-text/get-chat?term='+data).then((response) => {
                    context.commit('set_list', response.data);
                });
            } else {
                return axios.get('/api/speech-to-text/get-chat').then((response) => {
                    context.commit('set_list', response.data);
                });
            }
        },
        new_chat: (context, data) => {
            return axios.post('/api/speech-to-text/new-chat', data);
        },
        get_speech_to_text_info: (context, data) => {
            return axios.post('/api/speech-to-text/page-info', data).then((response) => {
                context.commit('set_page_info', response.data);
                context.commit('set_chat_list_initial', JSON.parse(response.data.list));
            });
        },
        remove: (context, data) => {
            return axios.post('/api/speech-to-text/destroy', data);
        },
        get_audio_list: (context, data) => {
            return axios.get('/api/speech-to-text/get-audio-list?speech_id='+data).then((response) => {
                context.commit('set_audio_list', response.data);
            });
        },
        upload_file: (context, data) => {
            return axios.post('/api/speech-to-text/upload-audio', data);
        },
        remove_file: (context, data) => {
            return axios.post('/api/speech-to-text/remove-audio', data);
        },
        add_new_audio_chat: (context, data) => {
            context.commit('set_chat_list', data);
        },
        set_user_msg: (context, data) => {
            let user = {
                msg: data.msg,
                user: 'user'
            }
            context.commit('set_chat_list', user);
        },
        chat: (context, data) => {
            return axios.post('/api/chat/chat', data).then((response) => {
                let bot = {
                    msg: response.data,
                    user: 'ai'
                };
                context.commit('set_chat_list', bot);
            });
        },
        resend: (context, data) => {
            return axios.post('/api/speech-to-text/resend-audio', data);
        },
        save: (context, data) => {
            return axios.post('/api/speech-to-text/save', data);
        },
        clean: (context, data) => {
            context.commit('set_reset_chat');
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
                context.commit('set_chat_list', list);
            });
        },
        translate_language: (context, data) => {
            return axios.post('/api/chat/translate/language', data).then((response) => {
                context.commit('set_translate_language', response.data);
            });
        },
    },
};
