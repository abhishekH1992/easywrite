import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        search: [],
        saved: [],
        isSevenDayTrial: false,
        navMenu: [],
        isAdmin: false,
    },

    getters: {},

    mutations: {
        set_models: (state, list) => {
            state.list = list;
        },
        set_search_models: (state, search) => {
            state.search = search;
        },
        set_search_saved_models: (state, saved) => {
            state.saved = saved;
        },
        set_is_seven_day_trial: (state, isSevenDayTrial) => {
            state.isSevenDayTrial = isSevenDayTrial;
        },
        set_nav_menu: (state, navMenu) => {
            state.navMenu = navMenu;
        },
        set_is_admin: (state, isAdmin) => {
            state.isAdmin = isAdmin;
        },
    },

    actions: {
        get_models: (context, data) => {
            return axios.get('/api/site/get-models').then((response) => {
                context.commit('set_models', response.data);
            });
        },

        get_search_models: (context, data) => {
            if(data){
                return axios.get('/api/site/get-search-models?term='+data).then((response) => {
                    context.commit('set_search_models', response.data);
                });
            } else {
                return axios.get('/api/site/get-search-models').then((response) => {
                    context.commit('set_search_models', response.data);
                });
            }
        },

        get_saved_models: (context, data) => {
            if(data){
                return axios.get('/api/chat/get-user-chats?term='+data).then((response) => {
                    context.commit('set_search_saved_models', response.data);
                });
            } else {
                return axios.get('/api/chat/get-user-chats').then((response) => {
                    context.commit('set_search_saved_models', response.data);
                });
            }
        },
        get_is_seven_day_trial: (context, data) => {
            return axios.get('/api/site/is-seven-day-trial').then((response) => {
                context.commit('set_is_seven_day_trial', response.data);
            });
        },

        get_custom_chat_search_models: (context, data) => {
            if(data){
                return axios.get('/api/site/get-custom-chat-search-models?term='+data).then((response) => {
                    context.commit('set_search_models', response.data);
                });
            } else {
                return axios.get('/api/site/get-custom-chat-search-models').then((response) => {
                    context.commit('set_search_models', response.data);
                });
            }
        },

        get_nav_menu_models: (context, data) => {
            return axios.get('/api/site/get-nav-menu-models').then((response) => {
                context.commit('set_nav_menu', response.data);
            });
        },

        is_admin: (context, data) => {
            return axios.get('/api/site/is-admin').then((response) => {
                context.commit('set_is_admin', response.data);
            });
        },
    },
};
