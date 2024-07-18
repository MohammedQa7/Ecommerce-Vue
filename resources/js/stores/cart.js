import { defineStore } from "pinia";
import axios from "axios";
import { loadStripe } from "@stripe/stripe-js";
import { createRouter } from "vue-router";
import router from "../router";

export const useCartStore = defineStore("carts", {
    state: () => ({
        cartItems: [],
        itemCount: 0,
        isLoading: false,
        errors: {},
        successMessages: {},
    }),
    getters: {
        cart: (state) => state.cartItems,
        count: (state) => state.itemCount
    },
    actions: {
        async getCartItems() {
            this.isLoading = true;
            await axios.get("http://127.0.0.1:8000/api/v1/add-to-cart")
                .then((response) => {
                    this.cartItems = response.data.data;
                    this.itemCount = response.data.cartCount;
                    this.isLoading = false;
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.errors.value = error.response;
                        this.isLoading = false;
                    }
                }).finally(() => {
                    this.isLoading = false;
                });
        },

        async deleteItemFromCart(cartItemID) {
            let cartIndex = this.cartItems.findIndex((c) => c.id == cartItemID);

            await axios.delete("http://127.0.0.1:8000/api/v1/add-to-cart/" + cartItemID)
                .then((response) => {
                    this.successMessages.value = response.data;
                    let cartIndex = this.cartItems.findIndex((c) => c.id == cartItemID);
                    if (cartIndex >= 0) {
                        this.cartItems.splice(cartIndex , 1);
                    }
                })

                .catch((error) => {
                    this.errors.value = error.response;
                })
        },

        updateIncrementValue(productID) {
            const cartItems = this.cartItems.find((c) => c.product.id == productID);
            if (cartItems.sku.variant[0] && cartItems.sku.variant[0].subOptions[0] !== undefined && cartItems.sku.variant[0].subOptions[0]) {
                if (cartItems.quantity < cartItems.sku.variant[0].subOptions[0].stock) {
                    cartItems.quantity = cartItems.quantity += 1;
                    cartItems.totalPrice = cartItems.sku.variant[0].subOptions[0].price * cartItems.quantity;
                }
                // console.log(cartItems.sku.variant[0].subOptions[0]);
            } else {
                if (cartItems.quantity < cartItems.sku.stock) {
                    cartItems.quantity = cartItems.quantity += 1;
                    cartItems.totalPrice = cartItems.sku.price * cartItems.quantity;
                }
            }
        },


        updateDecrementValue(productID) {
            const cartItems = this.cartItems.find((c) => c.product.id == productID);
            if (cartItems.sku.variant[0] && cartItems.sku.variant[0].subOptions[0] !== undefined && cartItems.sku.variant[0].subOptions[0]) {
                if (cartItems.quantity <= cartItems.sku.variant[0].subOptions[0].stock && cartItems.quantity > 1) {
                    cartItems.quantity = cartItems.quantity -= 1;
                    cartItems.totalPrice = cartItems.sku.variant[0].subOptions[0].price * cartItems.quantity;
                }
                // console.log(cartItems.sku.variant[0].subOptions[0]);
            } else {
                if (cartItems.quantity <= cartItems.sku.stock && cartItems.quantity > 1) {
                    cartItems.quantity = cartItems.quantity -= 1;
                    cartItems.totalPrice = cartItems.sku.price * cartItems.quantity;
                }
            }
        },

        // async payment(){
        //     // const stripe = await loadStripe('pk_test_51PBHBoP2wod00dHxC1LV5lKNTXTeX1jb4gUaQDtY6yLmHsMDSAG3awDveryZDclqB81IBObMLvd6e1wBzgWU8iHp007lfAWxrj');
        //     this.isLoading = true;
        //     await axios.post("http://127.0.0.1:8000/api/v1/checkout")
        //     .then((response)=>{
        //         this.isLoading = false;
        //         // return stripe.redirectToCheckout({ sessionId: response.data.id});
        //         // const stripeCheckoutUrl = `https://checkout.stripe.com/c/pay/${response.data.id}`;

        //         // window.open(stripeCheckoutUrl, '_blank');
        //     })
        //     .catch((error)=>{
        //         this.isLoading = false;
        //     })
        // }

        async payment(paymentToken) {
            // const stripe = await loadStripe('pk_test_51PBHBoP2wod00dHxC1LV5lKNTXTeX1jb4gUaQDtY6yLmHsMDSAG3awDveryZDclqB81IBObMLvd6e1wBzgWU8iHp007lfAWxrj');
            this.isLoading = true;
            await axios.post("http://127.0.0.1:8000/api/v1/checkout", {
                payment_token: paymentToken
            })
                .then((response) => {
                    this.isLoading = false; 
                    router.push({name:'Success'});
                })
                .catch((error) => {
                    this.isLoading = false;
                })
        }

    },
});


