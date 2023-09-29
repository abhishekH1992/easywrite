import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        chatSuiteList: [],
        pageInfo: [],
    },

    getters: {},

    mutations: {
        set_list: (state, list) => {
            state.list = list;
        },
        set_chat_suite: (state, chatSuiteList) => {
            state.chatSuiteList = chatSuiteList;
        },
        set_page_info: (state, pageInfo) => {
            state.pageInfo = pageInfo;
        },
    },

    actions: {
        get_list: (context, data) => {
            if(data){
                return axios.get('/api/fine-tune/get-list?term='+data).then((response) => {
                    context.commit('set_list', response.data);
                });
            } else {
                return axios.get('/api/fine-tune/get-list').then((response) => {
                    context.commit('set_list', response.data);
                });
            }
        },
        get_chat_suite_list: (context, data) => {
            return axios.get('/api/fine-tune/get-chat-suite-list').then((response) => {
                context.commit('set_chat_suite', response.data);
            });
        },
        new_submit: (context, data) => {
            return axios.post('/api/fine-tune/new-fine-tune', data);
        },
        get_page_info: (context, data) => {
            return axios.get('/api/fine-tune/get-page-info?id='+data).then((response) => {
                console.log(response.data);
                context.commit('set_page_info', response.data);
            });
        },
        set_processing: (context, data) => {
            return axios.post('/api/fine-tune/set-processing', data).then((response) => {
                context.commit('set_page_info', response.data);
            });
        },
        upload_file: (context, data) => {
            return axios.post('/api/fine-tune/file-upload', data);
        },
        create_job: (context, data) => {
            return axios.post('/api/fine-tune/create-job', data);
        }
    },
};
