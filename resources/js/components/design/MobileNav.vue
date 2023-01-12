<template>
    <div class="hamburger-menu">
        <div class="hamburger" @click="toggleMobileMenu" :class="{open: isActive}">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <ul class="mobile-menu">
                <li class="logo">
                    <router-link :to="{ name: 'chatBox'}">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox'}">
                            <span class="first">E</span>asyChat
                        </router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'chatBox'}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox'}">Freechat</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'qa' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'qa' }}">Q&A</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'grammer-checker' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'grammer-checker' }}">Grammar Checker</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'summary' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'summary' }}">Summary</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'ad' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'ad' }}">Ad from product description</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'keywords' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'keywords' }}">Keywords</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'note-to-summary' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'note-to-summary' }}">Note to summary</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'note-to-summary' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'note-to-summary' }}">Essay Outline</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'interview-question' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'interview-question' }}">Interview Questions</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'output-language' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'output-language' }}">Output Language</router-link>
                    </router-link>
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
            isActive: false
        };
    },
    props: {
        name: {
            required: true,
        },
    },
    methods: {
        toggleMobileMenu() {
            this.isActive = !this.isActive;
        }
    },
}
</script>
