<template>
    <div class="chat-head">
        <mobile-nav :name="name"/>
        <img :src="img"> <span class="name">{{ name }}</span>
    </div>
</template>
<script>
import MobileNav from '../design/MobileNav.vue'
export default {
    props: {
        name: {
            required: true,
        },
        img: {
            required: true,
        },
    },
    components: {
        MobileNav,
    },
}
</script>
