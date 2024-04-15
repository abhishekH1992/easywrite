<template>
	<div class="admin sidebar" :class="{close: isActive}">
        <div class="logo-details">
            <img src="/assets/images/EasyWrite.svg">
        </div>
        <ul class="nav-links">
            <div class="header" v-for="(navs, i) in navMenu" :key="i">
                {{ i }}
                <li v-for="nav in navs" :key="nav.id" class="nav-font-main-section">
                    <router-link class="nav-link link_name" :to="nav.slug"><i class="fa-solid fa-arrow-right"></i> {{ nav.name }}</router-link>
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
            <div class="fixed-li">
                <li class="nav-font-main-section" v-if="!isSevenDayTrial">
                    <router-link class="nav-link link_name" :to="{ name: 'billing'}" v-if="customerStripeId"><i class="fa fa-credit-card" aria-hidden="true"></i>Billing</router-link>
                    <router-link class="nav-link link_name" :to="{ name: 'plans'}" v-else><i class="fa fa-credit-card" aria-hidden="true"></i>Billing</router-link>
                </li>
                <li class="nav-font-main-section">
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
</template>

<script>
export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            isActive: false,
            language: '',
            tone: '',
        }
    },
    computed: {
        isActiveToggle() {
            return this.isActive ? `bx-menu-alt-left` : `bx-menu-alt-right`
        },
        models() {
            return this.$store.state.models.list;
        },
        languageList() {
            return this.$store.state.chat.languageList;
        },
        toneList() {
            return this.$store.state.chat.toneList;
        },
        isSevenDayTrial() {
            return this.$store.state.models.isSevenDayTrial;
        },
        navMenu() {
            return this.$store.state.models.navMenu;
        },
        customerStripeId() {
            return this.$store.state.subscription.customerStripeId;
        },
        isAdmin() {
            return this.$store.state.models.isAdmin;
        },
    },
    methods: {
        submit() {
            this.$refs.logout.submit();
        },
        setLangauge() {
            if(this.language || Object.keys(this.languageList).length) {
                localStorage.removeItem('language');
                this.language = this.language ? this.language : this.languageList[0].name;
                localStorage.setItem('language', this.language);
            }
        },
        setTone() {
            if(this.tone || Object.keys(this.toneList).length) {
                localStorage.removeItem('tone');
                this.tone = this.tone ? this.tone : this.toneList[0].name;
                localStorage.setItem('tone', this.tone);
            }
        },
    },
    mounted() {
        this.$store.dispatch('models/get_models');
        this.$store.dispatch('models/get_nav_menu_models');
        this.$store.dispatch('models/get_is_seven_day_trial');
        this.$store.dispatch('chat/get_language_list');
        this.$store.dispatch('chat/get_tone_list');
        this.$store.dispatch('subscription/get_customer_stripe_id');
        this.$store.dispatch('models/is_admin');
        this.setLangauge();
        this.setTone();
    },
    watch: {
        $route(to, from) {
            this.setLangauge();
            this.setTone();
        }
    }
}
</script>