<template>
  <nav class="bg-white dark:bg-gray-800 antialiased fixed z-10 w-full top-0">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-8">
          <div class="shrink-0">
            <a href="#" title="" class="">
              <img
                class="block w-auto h-8 dark:hidden"
                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/logo-full.svg"
                alt=""
              />
              <img
                class="hidden w-auto h-8 dark:block"
                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/logo-full-dark.svg"
                alt=""
              />
            </a>
          </div>

          <ul
            class="hidden lg:flex items-center justify-start gap-6 md:gap-8 py-3 sm:justify-center"
          >
            <router-link :to="{ name: 'Products' }">
              <li class="shrink-0">
                <a
                  title=""
                  class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500"
                >
                  Products
                </a>
              </li>
            </router-link>
            <li class="shrink-0">
              <a
                href="#"
                title=""
                class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500"
              >
                Categories
              </a>
            </li>
          </ul>
        </div>

        <div class="flex items-center lg:space-x-2 relative">
          <button
            @click="getCartItems"
            id="myCartDropdownButton1"
            data-dropdown-toggle="myCartDropdown1"
            type="button"
            class="relative inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white"
          >
            <div
              :class="
                useProduct.isAddedToCart
                  ? cartAddStartAnimation
                  : cartAddEndAnimation
              "
            >
              <div
                v-show="useProduct.isAddedToCart"
                class="flex items-center justify-center"
              >
                <div
                  class="w-9 h-9 rounded-full bg-green-100 dark:bg-green-900 p-2 flex items-center justify-center mx-auto"
                >
                  <svg
                    aria-hidden="true"
                    class="w-6 h-6 text-green-500 dark:text-green-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                  <span class="sr-only">Success</span>
                </div>
                <p
                  class="ms-2 text-md font-semibold text-gray-900 dark:text-white"
                >
                  {{ useProduct?.successMessages?.message }}
                </p>
              </div>
            </div>

            <span class="sr-only"> Cart </span>
            <svg
              class="w-5 h-5 lg:me-1"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"
              />
            </svg>
            <span class="hidden sm:flex">My Cart</span>
            <svg
              class="hidden sm:flex w-4 h-4 text-gray-900 dark:text-white ms-1"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m19 9-7 7-7-7"
              />
            </svg>
            <!-- cart count -->
            <div
              v-if="useCart.count > 0"
              class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900"
            >
              {{ useCart.count }}
            </div>
          </button>

          <div
            id="myCartDropdown1"
            class="z-10 hidden mx-auto max-w-sm space-y-4 rounded-lg bg-white p-4 antialiased shadow-lg dark:bg-gray-700"
          >
            <div
              class="cart-items-container w-80"
              v-if="useCart.cart.length > 0"
            >
              <ul
                class="py-2 overflow-y-auto text-gray-700 dark:text-gray-200"
                style="height: 20rem"
                aria-labelledby="dropdownUsersButton"
              >
                <cart-skeleton v-if="useCart.isLoading"></cart-skeleton>
                <div
                  v-for="(singleCartItem, index) in useCart.cart"
                  :key="index"
                  class="grid grid-cols-3 mt-5"
                >
                  <div class="me-4">
                    <img
                      :src="singleCartItem.product.images[0]?.ImagePath"
                      class="aspect-square w-full"
                      alt="product image"
                    />
                  </div>
                  <div>
                    <a
                      href="#"
                      class="truncate text-sm font-semibold leading-none text-gray-900 dark:text-white hover:underline"
                      >{{ singleCartItem.product.name }}</a
                    >
                    <p
                      class="mt-0.5 truncate text-sm font-normal text-gray-500 dark:text-gray-400"
                    >
                      ${{ singleCartItem.totalPrice }}
                    </p>
                  </div>

                  <div class="flex items-start justify-end gap-6">
                    <p
                      class="text-sm font-normal leading-none text-gray-500 dark:text-gray-400"
                    >
                      Qty: {{ singleCartItem.quantity }}
                    </p>

                    <button
                      data-tooltip-target="tooltipRemoveItem1a"
                      type="button"
                      class="text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-600"
                    >
                      <span class="sr-only"> Remove </span>
                      <svg
                        class="h-4 w-4"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm7.7-3.7a1 1 0 0 0-1.4 1.4l2.3 2.3-2.3 2.3a1 1 0 1 0 1.4 1.4l2.3-2.3 2.3 2.3a1 1 0 0 0 1.4-1.4L13.4 12l2.3-2.3a1 1 0 0 0-1.4-1.4L12 10.6 9.7 8.3Z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </ul>
              <router-link :to="{ name: 'Checkout' }">
                <a
                  class="flex items-center justify-center p-3 text-sm font-medium text-white-600 border-t border-gray-200 rounded-b-lg bg-gray-50 dark:border-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
                >
                  Procced To Checkout
                </a>
              </router-link>
            </div>

            <div class="empty-cart" v-else>
              <div
                class="p-10 overflow-y-auto text-gray-700 dark:text-gray-200"
              >
                <h1>{{ useCart.errors?.value?.data?.message }}</h1>
              </div>
            </div>
          </div>

          <button
            id="userDropdownButton1"
            data-dropdown-toggle="userDropdown1"
            type="button"
            class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white"
          >
            <svg
              class="w-5 h-5 me-1"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke="currentColor"
                stroke-width="2"
                d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
              />
            </svg>
            Account
            <svg
              class="w-4 h-4 text-gray-900 dark:text-white ms-1"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m19 9-7 7-7-7"
              />
            </svg>
          </button>

          <div
            id="userDropdown1"
            class="hidden z-10 w-56 divide-y divide-gray-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dark:divide-gray-600 dark:bg-gray-700"
          >
            <ul
              class="p-2 text-start text-sm font-medium text-gray-900 dark:text-white"
            >
              <li>
                <a
                  href="#"
                  title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                >
                  My Account
                </a>
              </li>
              <router-link :to="{ name: 'Orders' }">
               <a
                  title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                >
                  My Orders
                </a>
              </router-link>
              <li>
                <a
                  href="#"
                  title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                >
                  Settings
                </a>
              </li>
              <li>
                <a
                  href="#"
                  title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                >
                  Favourites
                </a>
              </li>
              <li>
                <a
                  href="#"
                  title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                >
                  Delivery Addresses
                </a>
              </li>
              <li>
                <a
                  href="#"
                  title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                >
                  Billing Data
                </a>
              </li>
            </ul>

            <div class="p-2 text-sm font-medium text-gray-900 dark:text-white">
              <a
                @click.prevent="Logout"
                title=""
                class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer"
              >
                Sign Out
              </a>
            </div>
          </div>

          <button
            type="button"
            data-collapse-toggle="ecommerce-navbar-menu-1"
            aria-controls="ecommerce-navbar-menu-1"
            aria-expanded="false"
            class="inline-flex lg:hidden items-center justify-center hover:bg-gray-100 rounded-md dark:hover:bg-gray-700 p-2 text-gray-900 dark:text-white"
          >
            <span class="sr-only"> Open Menu </span>
            <svg
              class="w-5 h-5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-width="2"
                d="M5 7h14M5 12h14M5 17h14"
              />
            </svg>
          </button>
        </div>
      </div>

      <div
        id="ecommerce-navbar-menu-1"
        class="bg-gray-50 dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg py-3 hidden px-4 mt-4"
      >
        <ul
          class="text-gray-900 dark:text-white text-sm font-medium dark:text-white space-y-3"
        >
          <li>
            <a
              href="#"
              class="hover:text-primary-700 dark:hover:text-primary-500"
              >Home</a
            >
          </li>
          <li>
            <a
              href="#"
              class="hover:text-primary-700 dark:hover:text-primary-500"
              >Best Sellers</a
            >
          </li>
          <li>
            <a
              href="#"
              class="hover:text-primary-700 dark:hover:text-primary-500"
              >Gift Ideas</a
            >
          </li>
          <li>
            <a
              href="#"
              class="hover:text-primary-700 dark:hover:text-primary-500"
              >Games</a
            >
          </li>
          <li>
            <a
              href="#"
              class="hover:text-primary-700 dark:hover:text-primary-500"
              >Electronics</a
            >
          </li>
          <li>
            <a
              href="#"
              class="hover:text-primary-700 dark:hover:text-primary-500"
              >Home & Garden</a
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";
import { useCartStore } from "../stores/cart.js";
import { useAuthStore } from "../stores/auth.js";
import CartSkeleton from "./CartSkeleton.vue";
import { useProductStore } from "../stores/products.js";
axios.defaults.baseURL = "http://127.0.0.1:8000/api/v1/";
const router = useRouter();
const route = useRoute();
const errors = ref({});
const useCart = useCartStore();
const useUser = useAuthStore();
const useProduct = useProductStore();
const cartAddStartAnimation =
  " flex items-center justify-center top-full w-64 h-16 rounded-lg dark:bg-gray-400 transition-all duration-300";
const cartAddEndAnimation =
  " flex items-center justify-center top-full w-0 h-0 rounded-lg  transition-all duration-300";

function getCartItems() {
  useCart.getCartItems();
}

async function Logout() {
  await axios
    .post("logout")
    .then((response) => {
      sessionStorage.clear();
      useUser.clearSession();
      sessionStorage.removeItem("auth");
      router.push({ name: "Login" });
    })
    .catch((error) => {
      if (error.response.status === 401) {
        errors.value = error.response.data;
      }
    });
}

onMounted(async () => {
  await router.isReady();
  if (
    route.name !== "Checkout" &&
    route.name !== "Login" &&
    route.name !== "Register"
  ) {
    useCart.getCartItems();
  }
});
</script>

