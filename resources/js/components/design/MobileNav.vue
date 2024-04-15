<template>
    <div class="hamburger-menu">
        <div class="hamburger" @click="toggleMobileMenu" :class="{open: isActive}">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <ul class="mobile-menu">
                <li class="logo">
                    <img src="/assets/images/EasyWrite.svg">
                </li>
                <div class="header" v-for="(navs, i) in navMenu" :key="i">
                    {{ i }}
                    <li v-for="nav in navs" :key="nav.id" class="nav-font-main-section ">
                        <router-link class="nav-link link_name" :to="nav.slug"><i class="fa-solid fa-arrow-right"></i> {{ nav.name }}</router-link>
                    </li>
                </div>
                <div class="header">
                    Document Analyzer
                    <li class="nav-font-main-section">
                        <router-link class="nav-link link_name" to="/documents"><i class="fa-solid fa-arrow-right"></i> Chat</router-link>
                    </li>
                </div>
                <div class="header">
                    Pre-built Template
                    <li class="nav-font-main-section">
                        <router-link class="nav-link link_name" to="/"><i class="fa-solid fa-arrow-right"></i> All Templates</router-link>
                    </li>
                </div>
                <div class="header">
                    Saved Projects
                    <li class="nav-font-main-section">
                        <router-link class="nav-link link_name" to="/archive"><i class="fa-solid fa-arrow-right"></i> Archive</router-link>
                    </li>
                </div>
                <li class="nav-billing nav-font-main-section">
                    <router-link class="nav-link link_name" :to="{ name: 'plans'}">Billing</router-link>
                </li>
                <li class="nav-font-main-section">
                    <router-link class="nav-link link_name" :to="{ name: 'archive'}">Archive</router-link>
                </li>
                <li class="nav-billing logout-btn nav-font-main-section">
                    <span class="text logout" @click="submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Logout
                        <form id="logout-form" action="/logout" method="POSt" style="display: none;" ref="logout">
                            <input type="hidden" name="_token" :value="csrf">
                        </form>
                    </span>
                </li>
            </ul>
        </div>
        <div class="page-name" v-if="!isActive">{{ name }}</div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            isActive: false,
            language: '',
            tone: '',
            isInput: false,
        };
    },
    props: {
        name: {
            required: true,
        },
    },
    computed: {
        // models() {
        //     return this.$store.state.models.list;
        // },
        navMenu() {
            return this.$store.state.models.navMenu;
        },
        customerStripeId() {
            return this.$store.state.subscription.customerStripeId;
        },
        isSevenDayTrial() {
            return this.$store.state.models.isSevenDayTrial;
        },
        isAdmin() {
            return this.$store.state.models.isAdmin;
        },
    },
    methods: {
        toggleMobileMenu() {
            this.isActive = !this.isActive;
        },
        submit() {
            this.$refs.logout.submit();
        },
    },
    mounted() {
        this.$store.dispatch('models/is_admin');
        this.$store.dispatch('models/get_is_seven_day_trial');
        this.$store.dispatch('subscription/get_customer_stripe_id');
    },
}
</script>
