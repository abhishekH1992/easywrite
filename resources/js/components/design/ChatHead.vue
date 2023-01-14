<template>
    <div class="chat-head">
        <mobile-nav :name="name"/>
        <img :src="img" v-if="img"> <span class="name">{{ name }}</span>
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
            type: String,
        },
    },
    components: {
        MobileNav,
    },
}
</script>
