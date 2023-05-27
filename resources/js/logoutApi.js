export const logoutApi = () => {
    window.localStorage.removeItem('SANCTUM_API_TOKEN');
}
