<template>
    <div class="hamburger-menu">
        <div class="hamburger" @click="toggleMobileMenu" :class="{open: isActive}">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <ul class="mobile-menu">
                <li class="logo mb-4">
                    <img src="/assets/images/arlo-logo.svg">
                </li>
                <div class="header">
                    <li v-for="nav in navMenu" :key="nav.id" class="nav-font-main-section nav-div">
                        <router-link class="nav-link link_name nav-div mb-3" :to="nav.slug"> 
                            <i :class="nav.img"></i>
                            {{ nav.name }}
                        </router-link>
                    </li>
                    <li class="nav-font-main-section nav-div">
                        <router-link class="nav-link link_name nav-div" :to="`/archive`"> 
                            <i class="fa fa-archive"></i>
                        Archive
                        </router-link>
                    </li>
                </div>
                <div class="header">
                    <li class="nav-billing nav-font-main-section">
                        <router-link class="nav-link link_name" :to="{ name: 'plans'}">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>Billing</router-link>
                    </li>
                </div>
                <div class="header">
                    <li class="nav-billing logout-btn nav-font-main-section">
                        <span class="text logout" @click="submit();">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Logout
                            <form id="logout-form" action="/logout" method="POSt" style="display: none;" ref="logout">
                                <input type="hidden" name="_token" :value="csrf">
                            </form>
                        </span>
                    </li>
                </div>
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
