<template>
	<div class="admin sidebar" :class="{close: isActive}">
        <div class="logo-details">
            <i class='bx bx-beer'></i>
            <span class="logo_name">EasyWrite</span>
        </div>
        <ul class="nav-links">
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
                    <router-link :to="{ name: 'commonBox', params: { prompt: 'essay-outline' }}">
                        <img src="/assets/images/freechat.svg">
                        <router-link class="nav-link link_name" :to="{ name: 'commonBox', params: { prompt: 'essay-outline' }}">Essay Outline</router-link>
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
</template>

<script>
export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            isActive: false,
        }
    },

    computed: {
        isActiveToggle() {
            return this.isActive ? `bx-menu-alt-left` : `bx-menu-alt-right`
        },
    },
}
</script>