import axios from 'axios';

export default {
    namespaced: true,
    state: {
        list: [],
        plan: [],
        intent: [],
        userPlan: [],
        userGrace: false,
    },

    getters: {},

    mutations: {
        set_plans: (state, list) => {
            state.list = list;
        },
        set_plan: (state, plan) => {
            state.plan = plan;
        },
        set_intent: (state, intent) => {
            state.intent = intent;
        },
        set_user_plan: (state, userPlan) => {
            state.userPlan = userPlan;
        },
        set_is_user_grace: (state, userGrace) => {
            state.userGrace = userGrace;
        },
    },

    actions: {
        get_plans: (context, data) => {
            return axios.get('/api/subscription/get-plans', data).then((response) => {
                context.commit('set_plans', response.data);
            });
        },
        get_plan_by_id: (context, data) => {
            return axios.get('/api/subscription/get-plan-by-id?id='+data.id).then((response) => {
                context.commit('set_plan', response.data);
            });
        },
        setup_intent: (context, data) => {
            return axios.get('/api/subscription/setup-intent').then((response) => {
                context.commit('set_intent', response.data);
            });
        },
        update_subscription: (context, data) => {
            return axios.post('/api/subscription/subscription', data);
        },
        is_subscribed_user: (context, data) => {
            return axios.get('/api/subscription/is-subscribed-user');
        },
        is_valid_plan_selected: (context, data) => {
            return axios.get('/api/subscription/is-valid-plan-selected?id='+data.id);
        },
        get_active_plan_user: (context, data) => {
            return axios.get('/api/subscription/get-active-plan-user').then((response) => {
                context.commit('set_user_plan', response.data);
            });
        },
        cancel_subscription: (context, data) => {
            return axios.post('/api/subscription/cancel');
        },
        resume_subscription: (context, data) => {
            return axios.post('/api/subscription/resume');
        },
        is_user_on_grace: (context, data) => {
            return axios.get('/api/subscription/is-user-on-grace').then((response) => {
                context.commit('set_is_user_grace', response.data);
            });
        },
        is_user_logged_in: (context, data) => {
            return axios.get('/api/user/is-user-logged-in');
        },
    },
};
