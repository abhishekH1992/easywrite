<template>
	<div class="admin sidebar" :class="{close: isActive}">
        <div class="logo-details">
            <span class="logo_name">EasyWrite</span>
        </div>
        <ul class="nav-links">
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