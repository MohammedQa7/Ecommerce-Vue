import { defineStore } from "pinia";
import axios from "axios";
import { useCartStore } from "./cart";
import router from "../router";
axios.defaults.baseURL = "http://127.0.0.1:8000/api/v1/"
export const useProductStore = defineStore("products", {
    state: () => ({
        products: [],
        singleProduct: [],
        isLoading: false,
        isFavoriteLoading: false,
        isAddedToCart: false,
        errors: {},
        successMessages: {},
        quantity: 1,
    }),
    getters: {
        Products: (state) => state.products,
    },
    actions: {
        async getProducts() {
            this.isLoading = true;
            await axios.get("products")
                .then((response) => {
                    this.products = response.data.data;
                    this.isLoading = false;
                })
                .catch((error) => {
                    if (error.status === 404) {
                        this.errors = error.response;
                        this.isLoading = false;
                    }
                }).finally(() => {
                    this.isLoading = false;
                });
        },

        async getSingleProduct(slug) {
            await axios.get("product/" + slug)
                .then((response) => {
                    this.singleProduct = response.data.data;
                })

                .catch((error) => {
                    if (error.response.status == 404) {
                        router.push({ name: "404-PAGE" });
                        this.errors = error.response;
                    }
                })
        },

        async favoriteProduct() {
            this.isFavoriteLoading = true;
            let product = this.singleProduct
            if (product) {
                if (!product.is_favorited) {
                    // favorite
                    await axios.post('http://127.0.0.1:8000/api/v1/favorite', { product_id: product.id })
                        .then((response) => {
                            if (response.status == 200) {
                                product.is_favorited = !product.is_favorited;
                                this.isFavoriteLoading = false;
                                this.successMessages.value = response.data;
                            }
                        })
                        .catch((error) => {
                            this.errors = error.response;
                            this.isFavoriteLoading = false;
                        });
                } else {
                    //unfavorite
                    await axios.delete('http://127.0.0.1:8000/api/v1/favorite/' + product.id)
                        .then((response) => {
                            if (response.status == 200) {
                                product.is_favorited = !product.is_favorited;
                                this.isFavoriteLoading = false;
                                this.successMessages.value = response.data;
                            }
                        })
                        .catch((error) => {
                            this.errors = error.response;
                            this.isFavoriteLoading = false;
                        });
                }
            }
            return product;
        },

        async AddToCart(data, skuCode) {
            let product = this.products.find((p) => p.id == data.value.productId);
            // these two variable for grapping the sku code and its suboption of available otherwise we will get the first Sku from the product.
            var subOptionsDetails = {};

            // Add to cart from home screen
            if (skuCode == null) {
                console.log(data);
                await axios.post('http://127.0.0.1:8000/api/v1/add-to-cart', {
                    product_id: data.value.productId,
                    sku_code: product.skus[0] ? product.skus[0].code : product.skus.code,
                    sub_option: product.skus[0] ? null : product.skus.variant[0].subOptions[0].id,
                    quantity: data.value.quantity,
                })
                    .then((response) => {
                        if (response.status == 200) {
                            this.successMessages = response.data;
                            useCartStore().itemCount += 1;
                            subOptionsDetails = {};
                            setTimeout(() => {
                                this.isAddedToCart = true;
                            }, 500);

                            setTimeout(() => {
                                this.isAddedToCart = false;
                            }, 2000);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });






                // this is the OLD CODE BEFORE modifing the sku code and variant sub options.

                // for (let index = 0; index < product.skus.length; index++) {
                //     if (typeof product.skus[index].variant[0] !== "undefined") {
                //         if (product.skus[index].variant[0].subOptions.length > 0) {
                //             subOptionsDetails.subOptionsId = product.skus[index].variant[0].subOptions[0].id;
                //             subOptionsDetails.skuCode = product.skus[index].code;
                //         }
                //     }
                // }

                // if (Object.keys(subOptionsDetails).length !== 0) {
                //     await axios.post('http://127.0.0.1:8000/api/v1/add-to-cart', {
                //         product_id: data.value.productId,
                //         sku_code: subOptionsDetails.skuCode,
                //         sub_option: subOptionsDetails.subOptionsId,
                //         quantity: data.value.quantity,
                //     })
                //         .then((response) => {
                //             if (response.status == 200) {
                //                 this.successMessages = response.data
                //                 useCartStore().itemCount += 1;
                //                 subOptionsDetails = {};
                //             }
                //         })
                //         .catch((error) => {
                //             console.log(error);
                //         });
                // }else{
                //     await axios.post('http://127.0.0.1:8000/api/v1/add-to-cart', {
                //         product_id: data.value.productId,
                //         sku_code: product.skus[0].code,
                //         quantity: data.value.quantity,
                //     })
                //         .then((response) => {
                //             if (response.status == 200) {
                //                 console.log('test');
                //                 this.successMessages = response.data;
                //                 useCartStore().itemCount += 1;
                //                 subOptionsDetails = {};
                //             }
                //         })
                //         .catch((error) => {
                //             console.log(error);
                //         });
                // }

            } else {
                // Add to cart from product details screen
                console.log(skuCode, 'sku is not null');
                await axios.post('http://127.0.0.1:8000/api/v1/add-to-cart', {
                    product_id: data.value.productID,
                    sku_code: skuCode,
                    sub_option: data.value.subOptionID,
                    quantity: this.quantity,
                })
                    .then((response) => {
                        if (response.status == 200) {
                            this.successMessages = response.data;
                            useCartStore().itemCount += 1;
                            subOptionsDetails = {};
                            setTimeout(() => {
                                this.isAddedToCart = true;
                            }, 500);

                            setTimeout(() => {
                                this.isAddedToCart = false;
                            }, 2000);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },


        updateQuantityByIncrement(isOptionSelected) {
            if (isOptionSelected.value.code != null) {
                let skuProduct = this.singleProduct.skus.find(
                    (p) => p.code == isOptionSelected.value.code
                );
                if (skuProduct.variant[0]?.subOptions.length > 0) {
                    if (isOptionSelected.value.subOptionID != null) {
                        let selectedSubOption = skuProduct.variant[0]?.subOptions.find(
                            (subOptionID) => subOptionID.id == isOptionSelected.value.subOptionID
                        );
                        this.quantity < selectedSubOption.stock ? this.quantity++ : "";
                    } else {
                        this.quantity = 1;
                    }
                } else {
                    if (skuProduct.stock > 0 && this.quantity < skuProduct.stock) {
                        this.quantity++;
                    } else if (this.quantity > skuProduct.stock) {
                        this.quantity = skuProduct.stock;
                    }
                }
            }
        },

        updateQuantityByDecrement(isOptionSelected) {
            if (isOptionSelected.value.code != null) {
                let skuProduct = this.singleProduct.skus.find(
                    (p) => p.code == isOptionSelected.value.code
                );
                if (skuProduct.variant[0]?.subOptions.length > 0) {
                    if (isOptionSelected.value.subOptionID != null) {
                        let selectedSubOption = skuProduct.variant[0]?.subOptions.find(
                            (subOptionID) => subOptionID.id == isOptionSelected.value.subOptionID
                        );
                        this.quantity > selectedSubOption.stock ? this.quantity-- : "";
                        console.log(this.quantity);
                    } else {
                        this.quantity = 1;
                    }
                } else {
                    if (skuProduct.stock > 0 && this.quantity < skuProduct.stock && this.quantity > 1) {
                        this.quantity--;
                    } else if (this.quantity < skuProduct.stock) {
                        this.quantity = 1;
                    }
                }
            }
        },

        

    },
});


