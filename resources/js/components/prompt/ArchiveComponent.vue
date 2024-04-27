<template>
	<div class="chatbox-container container">
        <div class="row head-title">
            <chat-head :name="`Archive`" class="sm:col-6"/>
            <div class="sm:col-6 mt-4 sm:mt-0 input-search-box p-3">
                <input type="text" v-model="term" @input="search" placeholder="Search..."/>
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>
        </div>
        <section class="dashbaord-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-3" v-for="(model, i) in models" :key="i">
                        <div class="model-section">
                            <router-link class="model" :to="{ name: 'savedChatBox', params: { prompt: model.prompt.slug.split('/')[2], id: model.id }}" v-if="!model.prompt.isSystem">
                                <div class="img"><i :class="model.prompt.img"></i></div>
                                <div class="content">
                                    <div class="name">{{ model.name }}</div>
                                    <div class="outline">{{ model.prompt.outline }}</div>
                                    <div class="created">Created: {{ model.human_readable_date }}</div>
                                </div>
                            </router-link>
                            <router-link class="model" :to="{ name: 'savedCustomChatBox', params: { prompt: model.prompt.slug.split('/')[2], id: model.id }}" v-else>
                                <div class="img"><i :class="model.prompt.img"></i></div>
                                <div class="content">
                                    <div class="name">{{ model.name }}</div>
                                    <div class="outline">{{ model.prompt.outline }}</div>
                                    <div class="created">Created: {{ model.human_readable_date }}</div>
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import ChatHead from '../design/ChatHead.vue'
export default {
    data() {
        return {
            term: '',
        }
    },
    components: {
        ChatHead,
    },
    computed: {
        models() {
            return this.$store.state.models.saved;
        },
    },
    methods: {
        search() {
            this.$store.dispatch('models/get_saved_models', this.term);
        },
    },
    mounted() {
        this.$store.dispatch('models/get_saved_models');
    },
}
</script>