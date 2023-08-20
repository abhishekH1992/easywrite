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
                <li class="nav-billing">
                    <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'chat' }}"><i class="fa fa-commenting" aria-hidden="true"></i>Chat</router-link>
                </li>
                <li class="nav-billing">
                    <router-link class="nav-link link_name" :to="{ name: 'documentsList'}"><i class="fa fa-book" aria-hidden="true"></i>Chat Doc</router-link>
                </li>
                <li class="nav-billing">
                    <router-link class="nav-link link_name" :to="{ name: 'customChatList'}"><i class="fa fa-comments" aria-hidden="true"></i>Custom Chat</router-link>
                </li>
                <li class="nav-billing">
                    <router-link class="nav-link link_name" :to="{ name: 'archive'}"><i class="fa fa-database" aria-hidden="true"></i>Project</router-link>
                </li>
                <li class="nav-billing">
                    <router-link class="nav-link link_name" :to="{ name: 'dashboard'}"><i class="fa fa-list-alt" aria-hidden="true"></i>Template</router-link>
                </li>
                <li class="nav-billing">
                    <router-link class="nav-link link_name" :to="{ name: 'plans'}"><i class="fa fa-credit-card" aria-hidden="true"></i>Billing</router-link>
                </li>
                <!-- <li class="nav-billing">
                    <router-link class="nav-link link_name" :to="{ name: 'documentsList'}">Chat Doc</router-link>
                </li>
                <li class="nav-billing">
                    <router-link class="nav-link link_name" :to="{ name: 'customChatList'}">Custom Chat</router-link>
                </li> -->
                <!-- <div class="nav-font-main-section header" v-for="(navs, i) in models" :key="i">
                    {{ i }}
                    <li v-for="nav in navs" :key="nav.id">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: nav.slug.split('/')[2] }}"><i class="fa-solid fa-arrow-right"></i> {{ nav.name }}</router-link>
                    </li>
                </div>
                <li class="nav-billing nav-font-main-section">
                    <router-link class="nav-link link_name" :to="{ name: 'plans'}">Billing</router-link>
                </li>
                <li class="nav-font-main-section">
                    <router-link class="nav-link link_name" :to="{ name: 'archive'}">Archive</router-link>
                </li> -->
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
        models() {
            return this.$store.state.models.list;
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
}
</script>
