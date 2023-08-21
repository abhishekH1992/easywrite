<template>
    <div class="chatbox-container">
        <chat-head :name="`Billing`"/>
        <section class="pricing-section payment-section billing-section">
            <div class="container">
                <div class="title">Manage Your Subscription</div>
                <div class="title-1">We will redirect you to Stripe to manage your subscription.</div>
                <div class="manage-btn">
                    <button class="btn btn-submit" @click="manageCustomer">MANAGE SUBSCRIPTION</button>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import ChatHead from '../design/ChatHead.vue'
export default {
    data(){
        return {
            stripeAPIToken: process.env.MIX_STRIPE_KEY,
        }
    },
    components: {
        ChatHead,
    },
    computed: {
        customerStripeId() {
            return this.$store.state.subscription.customerStripeId;
        },
    },
    methods: {
        manageCustomer() {
            this.$store.dispatch('subscription/billing_portal_url').then((response) => {
                if(response.data.status) {
                    window.location.href = response.data.url;
                } else {
                    this.$notify({
                        group: 'error',
                        text: 'Something went wrong! Please refresh the page.',
                        closeOnClick: true,
                    });
                }
            })
            .catch((error) => {
                this.$notify({
                    group: 'error',
                    text: 'Something went wrong! Please refresh the page.',
                    closeOnClick: true,
                });
            });
        }
    },
    mounted() {

    },
}
</script>