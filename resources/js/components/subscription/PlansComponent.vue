<template>
    <div class="chatbox-container">
        <chat-head :name="`Choose a Plan`"/>
        <section class="pricing-section">
            <div class="container">
                <div class="sec-title text-center">
                    <span class="title">Get plan</span>
                    <h2>Choose a Plan</h2>
                </div>
                <div class="outer-box">
                    <div class="row">
                        <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" v-for="(plan, i) in plans" :key="i">
                            <div class="inner-box">
                                <div class="icon-box">
                                    <div class="icon-outer">
                                        <div class="icon">
                                            <i :class="icon[i]"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="price-box">
                                    <div class="title">{{ plan.name }}</div>
                                    <h4 class="price">NZD {{ plan.price }}/month</h4>
                                </div>
                                <div class="plan-content" v-html="plan.description"></div>
                                <div class="btn-box">
                                    <a href="https://codepen.io/anupkumar92" class="theme-btn">BUY plan</a>
                                </div>
                            </div>
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
    data: () => ({
        icon: [
            'fas fa-paper-plane',
            'fas fa-gem',
            'fas fa-rocket'
        ],
    }),
    components: {
        ChatHead,
    },
    computed: {
        plans() {
            return this.$store.state.subscription.list;
        },
    },
    mounted() {
        this.$store.dispatch('subscription/get_plans');
    },
}
</script>