<template>
  <div
    class="grid sm:px-10 lg:grid-cols-2 lg:px-20 xl:px-32 pt-5 dark:bg-gray-800"
  >
    <div class="px-4 pt-8">
      <p class="text-xl font-medium dark:text-white">Order Summary</p>
      <p class="text-gray-400">
        Check your items. And select a suitable shipping method.
      </p>
      <div
        class="mt-8 space-y-3 rounded-lg border bg-white px-2 py-4 sm:px-6 dark:bg-gray-700"
      >
        <div
          v-for="(singleCartItem, index) in useCart.cart"
          :key="index"
          class="flex flex-col rounded-lg bg-white sm:flex-row dark:bg-gray-800"
        >
          <img
            class="m-2 h-24 w-28 rounded-md border object-cover object-center"
            :src="singleCartItem.product?.images[0]?.ImagePath"
            alt=""
          />
          <div class="flex w-full flex-col px-4 py-4">
            <div class="flex justify-between">
              <span class="font-semibold dark:text-white">{{
                singleCartItem.product.name
              }}</span>
              <span class="font-semibold dark:text-white">{{
                singleCartItem.quantity
              }}</span>
            </div>
            <span class="float-right dark:text-gray-400">  {{
                singleCartItem.sku?.variant[0]?.subOptions[0]
                  ? singleCartItem.sku.variant[0].subOptions[0]?.Attribute.name +
                    " : "
                  : singleCartItem.sku?.variant[0]
                  ? singleCartItem.sku.variant[0].Attribute.name + " : "
                  : ""
              }}

              {{
                singleCartItem.sku?.variant[0]?.subOptions[0]
                  ? singleCartItem.sku?.variant[0]?.subOptions[0].value
                  : singleCartItem.sku.variant[0]?.value
              }}</span>
            <p class="text-lg font-bold dark:text-white">
              ${{ singleCartItem.totalPrice }}
            </p>
          </div>
        </div>
          <div
          v-show="useCart.count <= 0"
          class="flex flex-col rounded-lg bg-white sm:flex-row dark:bg-gray-800"
        >
          <div class="flex w-full flex-col px-4 py-4">
            <div class="flex justify-between">
              <span class="font-semibold dark:text-white">No items in the cart</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="mt-10 bg-gray-50 px-4 pt-8 lg:mt-0 dark:bg-gray-700 rounded-lg pb-2"
    >
      <p class="text-xl font-medium dark:text-white">Payment Details</p>
      <p class="dark:text-gray-400">
        Complete your order by providing your payment details.
      </p>
      <div class="">
        <label
          for="email"
          class="mt-4 mb-2 block text-sm font-medium dark:text-white"
          >Email</label
        >
        <div class="relative">
          <input
            v-model="billingAddress.emailAddress"
            type="text"
            id="email"
            name="email"
            class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
            placeholder="your.email@gmail.com"
          />
          <div
            class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4 text-gray-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
              />
            </svg>
          </div>
        </div>
        <label
          for="card-holder"
          class="mt-4 mb-2 block text-sm font-medium dark:text-white"
          >Card Holder</label
        >
        <div class="relative">
          <input
            type="text"
            id="card-holder-name "
            name="card-holder"
            class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm uppercase shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
            placeholder="Your full name here"
          />
          <div
            class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4 text-gray-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"
              />
            </svg>
          </div>
        </div>
        <label
          for="card-no"
          class="mt-4 mb-2 block text-sm font-medium dark:text-white"
          >Card Details</label
        >

        <div class="stripe-card-element-wrapper">
          <div id="card-element" class="text-white stripe-card-element"></div>
          <div id="card-errors" class="text-red-500 text-sm" role="alert"></div>
        </div>

        <label
          for="billing-address"
          class="mt-4 mb-2 block text-sm font-medium dark:text-white"
          >Billing Address</label
        >
        <div class="flex flex-col sm:flex-row">
          <div class="relative flex-shrink-0 sm:w-7/12">
            <input
              v-model="billingAddress.streetAddress"
              type="text"
              id="billing-address"
              name="billing-address"
              class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
              placeholder="Street Address"
            />
            <div
              class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3"
            >
              <img
                class="h-4 w-4 object-contain"
                src="https://flagpack.xyz/_nuxt/4c829b6c0131de7162790d2f897a90fd.svg"
                alt=""
              />
            </div>
          </div>
          <input
            v-model="billingAddress.state"
            type="text"
            id="state-address"
            name="state-address"
            class="w-full rounded-md border border-gray-200 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
            placeholder="Street Address"
          />
          <input
            v-model="billingAddress.zipCode"
            id="postal-code"
            type="text"
            name="billing-zip"
            class="flex-shrink-0 rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none sm:w-1/6 focus:z-10 focus:border-blue-500 focus:ring-blue-500"
            placeholder="ZIP"
          />
        </div>

        <!-- Total -->
        <div class="mt-6 border-t border-b py-2">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-900 dark:text-white">
              Subtotal
            </p>
            <p class="font-semibold text-gray-900 dark:text-white">${{Total}}</p>
          </div>
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-900 dark:text-white">
              Shipping
            </p>
            <p class="font-semibold text-gray-900 dark:text-white">free</p>
          </div>
        </div>
        <div class="mt-6 flex items-center justify-between">
          <p class="text-sm font-medium text-gray-900 dark:text-white">Total</p>
          <p class="text-2xl font-semibold text-gray-900 dark:text-white">
            ${{Total}}
          </p>
        </div>
      </div>
      <button
        @click.prevent="generateStripePaymentToken"
        class="mt-4 mb-8 w-full rounded-md bg-gray-900 px-6 py-3 font-medium text-white disabled:bg-gray-400 disabled:cursor-not-allowed"
        :disabled="useCart.count <= 0"
      >
      <loading-indicator v-if="useCart.isLoading"></loading-indicator>
        Place Order
      </button>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted , computed } from "vue";
import { loadStripe } from "@stripe/stripe-js";
import axios from "axios";
import { useCartStore } from "../stores/cart";
import LoadingIndicator from "../components/LoadingIndicator.vue";
const useCart = useCartStore();
const stripe = ref(null);
const elements = ref(null);
const card = ref(null);
const cardHolderName = ref();
const paymentStripeToken = ref(null);
const billingAddress = ref({
  emailAddress: "",
  streetAddress: "",
  state: "",
  zipCode: "",
});

const Total = computed(()=>{
    return useCart.cart.reduce( (total , item )=> total + item.totalPrice , 0) 
})


const style = {
  base: {
    color: "#32325d",
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: "antialiased",
    backgroundColor: "#f9f9f9",
    fontSize: "16px",
    "::placeholder": {
      color: "#aab7c4",
    },
    padding: "400px !important",
  },
  invalid: {
    color: "#fa755a",
    iconColor: "#fa755a",
  },
};
async function preparePaymentForm() {
  stripe.value = await loadStripe(
    "pk_test_51PBHBoP2wod00dHxC1LV5lKNTXTeX1jb4gUaQDtY6yLmHsMDSAG3awDveryZDclqB81IBObMLvd6e1wBzgWU8iHp007lfAWxrj"
  );
  elements.value = stripe.value.elements();
  card.value = elements.value.create("card", { style });
  card.value.mount("#card-element");
}
async function generateStripePaymentToken() {
  const result = await stripe.value.createPaymentMethod({
    type: "card",
    card: card.value,
    billing_details: {
      name: cardHolderName.value,
    },
  });
  if (result.error) {
    const errorElement = document.getElementById("card-errors");
    errorElement.textContent = result.error.message;
  } else {
    // The card has been verified successfully...    // Send the token to your server.
    // Insert the token ID into the form so it gets submitted to the server
    paymentStripeToken.value = result.paymentMethod.id;
    useCart.payment(paymentStripeToken.value);
  }
}

onMounted(() => {
  preparePaymentForm();
});
</script>


<style scoped>
.stripe-card-element {
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px; /* Add padding here */
  background-color: #f9f9f9; /* Set background color */
}
</style>