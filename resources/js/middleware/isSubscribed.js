
export default function isSubscribed({ store, next, router }) {
    store.dispatch('subscription/is_subscribed_user').then((response) => {
        return response.data ? next() : next({ name: 'plans' });
    });
}