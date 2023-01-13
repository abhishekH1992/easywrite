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
                    <router-link :to="{ name: 'chatBox', params: { prompt: 'freechat' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'freechat' }}">Freechat</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'chatBox', params: { prompt: 'qa' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'qa' }}">Q&A</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'chatBox', params: { prompt: 'grammer-checker' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'grammer-checker' }}">Grammar Checker</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'chatBox', params: { prompt: 'summary' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'summary' }}">Summary</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'chatBox', params: { prompt: 'ad' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'ad' }}">Ad from product description</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'chatBox', params: { prompt: 'keywords' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'keywords' }}">Keywords</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'chatBox', params: { prompt: 'note-to-summary' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'note-to-summary' }}">Note to summary</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'chatBox', params: { prompt: 'essay-outline' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'essay-outline' }}">Essay Outline</router-link>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'chatBox', params: { prompt: 'interview-question' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'chatBox', params: { prompt: 'interview-question' }}">Interview Questions</router-link>
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
