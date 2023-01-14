<template>
    <div class="chatbox-container">
        <chat-head :name="`Subscribe`"/>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            You will be charged NZD {{ plan.price }} for {{ plan.name }} Plan
                        </div>
                        <div class="card-body">
                            <form id="payment-form">
                                <input type="hidden" name="plan" id="plan" value="{{ $plan->id }}">
        
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" name="name" id="card-holder-name" class="form-control" value="" placeholder="Name on the card">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="">Card details</label>
                                            <div id="card-element"></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                    <hr>
                                        <button type="submit" class="btn btn-primary" id="card-button" :data-secret="intent">Purchase</button>
                                    </div>
                                </div>
        
                            </form>
  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ChatHead from '../design/ChatHead.vue'
export default {
    data: () => ({
        // icon: [
        //     'fas fa-paper-plane',
        //     'fas fa-gem',
        //     'fas fa-rocket'
        // ],
    }),
    components: {
        ChatHead,
    },
    computed: {
        plan() {
            return this.$store.state.subscription.plan;
        },
        intent() {
            return this.$store.state.subscription.intent;
        },
    },
    mounted() {
        let payload = {
            slug: this.$route.params.plan
        }
        this.$store.dispatch('subscription/get_plan_by_slug', payload);
    },
}
</script>