<template>
    <div class="chat-head" :class="{noImgPadding: !img}">
        <mobile-nav :name="name"/>
        <div class="img"><img :src="img" v-if="img"></div>
        <div class="content" v-if="!isInput">
            <div class="name">{{ name }}</div>
            <div class="outline" v-if="!savedId">{{ outline }}</div>
        </div>
        <div class="content edit-name" v-if="savedId && !isInput" @click="isInput = true">
            <i class="fa fa-pencil" aria-hidden="true"></i> Edit & Save
        </div>
        <div class="content" v-if="isInput">
            <div class="input">
                <input type="text" v-model="newName" class="form-control" placeholder="Chat name..."/>
            </div>
            <div class="saveNameBtn">
                <button class="btn" @click="save">Save</button>
                <button class="btn" @click="isInput = false">Cancel</button>
            </div>
        </div>
        <notifications position="top right" group="success" classes="success-notification"/>
        <notifications position="top right" group="error" classes="error-notification"/>
    </div>
</template>
<script>
import MobileNav from '../design/MobileNav.vue'
export default {
    data() {
        return {
            isInput: false,
            newName: '',
        }
    },
    props: {
        name: {
            required: true,
        },
        img: {
            type: String,
        },
        outline: {
            type: String,
        },
        savedId: {
            default: 0,
            type: Number,
            required: false,
        }
    },
    components: {
        MobileNav,
    },
    methods: {
        save() {
            this.$emit('name-changes', this.newName);
            this.isInput = false;
            this.newName = '';
        }
    }
}
</script>
