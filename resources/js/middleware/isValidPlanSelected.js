
export default function isSubscribed({ store, next, router }) {
    let payload = {
        id: localStorage.getItem('selectedPlanId')
    }
    store.dispatch('subscription/is_valid_plan_selected', payload).then((response) => {
        return response.data ? next() : next({ name: 'plans' });
    });
}