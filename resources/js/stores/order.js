import { defineStore } from "pinia";
import axios from "axios";
import { loadStripe } from "@stripe/stripe-js";
import { createRouter } from "vue-router";
import router from "../router";

export const useOrderStore = defineStore("orders", {
    state: () => ({
        orders: [],
        isLoading: false,
        errors: {},
    }),
    getters: {
        order: (state) => state.orders,
    },
    actions: {
        async getOrders() {
            await axios.get("http://127.0.0.1:8000/api/v1/orders")
                .then((response) => {
                    this.orders = response.data.data;
                })
                .catch((error) => {
                    this.errors = error.data;
                })
        }
    },
});


