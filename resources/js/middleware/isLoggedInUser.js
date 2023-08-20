
export default function isLoggedInUser({ store, next, router }) {
    store.dispatch('subscription/is_user_logged_in').then((response) => {
        return next();
    })
    .catch((error) => {
        window.location.href = '/login';
    });
}