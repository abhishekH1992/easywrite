<template>
    <div class="chatbox-container">
        <chat-head :name="`Choose a Plan`"/>
        <section class="pricing-section payment-section">
            <div class="container">
                <div class="sec-title text-center">
                    <span class="title">Subscribe</span>
                    <span class="title-1">You will be charged NZD {{ plans.price }} for {{ plans.name }}/Month Plan</span>
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
                    <div class="pricing-block">
                        <div class="inner-box">
                            <div class="fields">
                                <div class="validate-input">
                                    <div class="wrap-input">
                                        <input class="block mt-1 w-full input" type="name" v-model="name" required/>
                                        <span class="label" data-placeholder="Card Holdername"></span>
                                    </div>
                                </div>
                                <div id="card-element"></div>
                            </div>
                            <div class="btn-box submit-btn-block">
                                <button class="btn submit-btn" @click="submitPayment" :disabled="isDisabled">
                                    {{ isDisabled ? btnLoading : btnLabel }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="loader-container" v-if="setLoader">
                    <div class="loader"></div>
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
            stripe: '',
            elements: '',
            card: '',
            name: '',
            isDisabled: false,
            btnLabel: 'SUBSCRIBE',
            btnLoading: 'SUBSCRIBING...',
            errorDisplay: true,
            setLoader: false,
        }
    },
    components: {
        ChatHead,
    },
    computed: {
        plans() {
            return this.$store.state.subscription.list;
        },
        intent() {
            return this.$store.state.subscription.intent;
        },
    },
    methods: {
        includeStripe( URL, callback ){
            var documentTag = document, tag = 'script',
                object = documentTag.createElement(tag),
                scriptTag = documentTag.getElementsByTagName(tag)[0];
            object.src = '//' + URL;
            if (callback) { object.addEventListener('load', function (e) { callback(null, e); }, false); }
            scriptTag.parentNode.insertBefore(object, scriptTag);
        },
        configureStripe(){
            console.log(this.stripeAPIToken);
            this.stripe = Stripe( this.stripeAPIToken );
            console.log(this.stripe);
            this.elements = this.stripe.elements();
            this.card = this.elements.create('card', {
                hidePostalCode: true,
                style: {
                    base: {
                        iconColor: '#666EE8',
                        color: '#555555',
                        lineHeight: '1.2',
                        fontSize: '15px',
                        '::placeholder': {
                            color: '#CFD7E0',
                        },
                    },
                }, 
            });
            this.card.mount('#card-element');
        },
        updateSubscription(payment_method){
            let payload = {
                plan: this.plans.id,
                payment: payment_method
            }
            this.$store.dispatch('subscription/update_subscription', payload).then((response) => {
                this.isDisabled = false;
                this.setLoader = false;
                this.$notify({
                    group: 'success',
                    text: 'Success! Subscription complete.',
                    closeOnClick: true,
                });
                this.$router.push({ name: 'dashboard' });
            });
        },
        submitPayment(){
            this.isDisabled = true;
            this.setLoader = true;
            this.stripe.confirmCardSetup(
                this.intent.client_secret, {
                    payment_method: {
                        card: this.card,
                        billing_details: {
                            name: this.name
                        }
                    }
                }
            ).then((response) => {
                console.log(response);
                if(Object.hasOwn(response, 'error')){
                    this.$notify({
                        group: 'error',
                        text: response.error.message,
                        closeOnClick: true,
                    });
                    this.errorDisplay = false;
                } else {
                    this.updateSubscription(response.setupIntent.payment_method);
                }
                this.card.clear();
                this.name = '';
            })
            .catch((error) => {
                this.card.clear();
                this.name = '';
                this.isDisabled = false;
                this.setLoader = false;
                if(this.errorDisplay){
                    this.$notify({
                        group: 'error',
                        text: 'Something went wrong! Please refresh the page.',
                        closeOnClick: true,
                    });
                }
                this.errorDisplay = true;
            });
        },
    },
    mounted() {
        //Add stripe js
        this.includeStripe('js.stripe.com/v3/', function(){
            this.configureStripe();
        }.bind(this));

        //Setup user intent for subscription
        this.$store.dispatch('subscription/setup_intent');

        this.$store.dispatch('subscription/get_plans');
    },
}
</script>