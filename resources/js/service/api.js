import axios from "axios";
import store from "../store";
import router from "../router.js";

const api = axios.create({});

api.interceptors.request.use((config) => {
        const token = localStorage.getItem("token");
        if (token) {
            config.headers = {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            };
        } else {
            config.headers = { Accept: "application/json" };
        }
        store.commit("SET_LOADING", true);
        return config;
    },
    (error) => Promise.reject(error));

api.interceptors.response.use(
    (response) => {
        store.commit("SET_LOADING", false);
        return response;
    },
    async (error) => {
        if (error.response.status === 401) {
            localStorage.removeItem("token");
            localStorage.removeItem('permissions');
            await router.push('/login');
        }
        await store.dispatch('showError', error)
        store.commit("SET_LOADING", false);
        return Promise.reject(error);
    }
);

export default api;
