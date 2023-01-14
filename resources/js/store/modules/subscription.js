import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        plan: [],
        intent: ''
    },

    getters: {},

    mutations: {
        set_plans: (state, list) => {
            state.list = list;
        },
        set_plan: (state, list) => {
            state.list = list;
        },
        set_intent: (state, intent) => {
            state.intent = intent;
        },
    },

    actions: {
        get_plans: (context, data) => {
            return axios.get('/api/subscription/get-plans', data).then((response) => {
                context.commit('set_plans', response.data);
            });
        },
        get_plan_by_slug: (context, data) => {
            return axios.get('/api/subscription/get-plan-by-slug', data).then((response) => {
                context.commit('set_plan', response.data.plan);
                context.commit('set_intent', response.data.intent);
            });
        },
    },
};
