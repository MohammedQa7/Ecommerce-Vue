import { defineStore } from "pinia";
import axios from "axios";
import { useProductStore } from "../stores/products";
import { useAuthStore } from "../stores/auth";
export const useRatingStore = defineStore("rating", {
    state: () => ({
        allRatings: null,
        errors: {}
    }),
    getters: {
        ratings: (state) => state.allRatings
    },

    actions: {
        
        async addRating(data) {
            await axios.post('rate', {
                'product_id': data.value.productID,
                'rating': data.value.rating,
                'message': data.value.message,
            })
                .then((response) => {
                    if (response.status == 200) {
                        this.successMessages = response.data
                        useProductStore().singleProduct.rating.unshift({
                            rating:data.value.rating,
                            user:useAuthStore().user.data,
                            message:data.value.message
                        });
                    }
                })
                .catch((error) => {
                    
                    this.errors = error.data;
                })
        }

    }

});