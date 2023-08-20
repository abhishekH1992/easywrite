<template>
    <div class="chatbox-container">
        <chat-head :name="`Choose a Plan`"/>
        <section class="pricing-section">
            <div class="container">
                <div class="sec-title text-center">
                    <span class="title">Get plan</span>
                    <h2>Choose a Plan</h2>
                    <div class="free-trial-end">
                        <p>
                            We hope you've enjoyed your free trial with us and have been able to explore the exciting features of our platform. We are writing to inform you that your trial period has now concluded. To continue accessing our extensive range of services, we'll need to transition you to a full membership. This requires updated payment information, specifically your credit card details.
                        </p>
                        <p>
                            Moving to a full membership will allow you to continue using all the great features you have been enjoying during the trial period without any disruptions or limitations.
                        </p>
                        <p>
                            We look forward to continuing to serve you. If you have any further questions or concerns, please don't hesitate to get in touch with our customer support team via email
                        </p>
                        <p>Thank you for choosing us, and we hope to continue making your experience on our platform beneficial.</p>
                    </div>
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
                                <div class="btn-box" v-if="userPlan.stripe_price === plan.stripe_plan && userOnGracePeriod">
                                    <button class="btn theme-btn" @click="resumeSubscription" :disabled="isDisabled">REACTIVATE</button>
                                    <span>Your subscribtion will end this month.</span>
                                </div>
                                <div class="btn-box" v-else-if="userPlan.stripe_price === plan.stripe_plan">
                                    <button class="btn theme-btn" @click="cancelSubscription" :disabled="isDisabled">CANCEL</button>
                                    <span>You are subscribed to {{ plan.name }}</span>
                                </div>
                                <div class="btn-box" v-else>
                                    <button class="btn theme-btn" @click="redirectTosubscription(plan.id)" :disabled="isDisabled">SUBSCRIBE NOW</button>
                                    <span></span>
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
        isDisabled: false,
    }),
    components: {
        ChatHead,
    },
    computed: {
        plans() {
            return this.$store.state.subscription.list;
        },
        userPlan() {
            return this.$store.state.subscription.userPlan;
        },
        userOnGracePeriod() {
            return this.$store.state.subscription.userGrace;
        },
    },
    methods: {
        redirectTosubscription(id){
            localStorage.setItem('selectedPlanId', id);
            this.$router.push({ name: 'subscription' });
        },
        cancelSubscription(id){
            this.isDisabled = true;
            localStorage.removeItem('selectedPlanId', id);
            this.$store.dispatch('subscription/cancel_subscription').then((response) => {
                this.$notify({
                    group: 'success',
                    text: 'Success! Subscription canceled.',
                    closeOnClick: true,
                });
                this.isDisabled = false;
                this.$router.push({ name: 'plans' });
            });
        },
        resumeSubscription(id){
            this.isDisabled = true;
            localStorage.removeItem('selectedPlanId', id);
            this.$store.dispatch('subscription/resume_subscription').then((response) => {
                this.$notify({
                    group: 'success',
                    text: 'Success! Subscription resume.',
                    closeOnClick: true,
                });
                this.isDisabled = false;
                this.$router.push({ name: 'plans' });
            });
        }
    },
    mounted() {
        this.$store.dispatch('subscription/get_plans');
        this.$store.dispatch('subscription/get_active_plan_user');
        this.$store.dispatch('subscription/is_user_on_grace');
    },
}
</script>