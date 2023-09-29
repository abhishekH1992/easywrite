
export default function isSubscribed({ store, next, router }) {
    store.dispatch('models/is_admin_without_state').then((response) => {
        return response ? next() : next({ name: 'dashbaord' });
    });
}