import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authUser: null,
        errors: {}
    }),
    getters: {
        user: (state) => state.authUser
    },

    actions: {
        async getUser() {
            try {
                const res = await axios.get("http://127.0.0.1:8000/api/user");
                this.authUser = res.data;

            } catch (error) {
                if (error.response.status === 401) {
                    this.errors = error.response;
                }
            }
        },

        clearSession(){
            this.authUser = null
            this.user = null
        }
    },

    persist: {
        storage: sessionStorage,
        paths: ['authUser']
    }
});