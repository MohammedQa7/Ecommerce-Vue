<template>
  <section class="py-24 relative dark:bg-gray-800">
    <div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto pb-6">
      <h2
        class="title font-manrope font-bold text-4xl leading-10 mb-8 text-center text-black dark:text-white"
      >
        Shopping Cart
      </h2>
      <div class="hidden lg:grid grid-cols-2 py-6">
        <div
          class="font-normal text-xl leading-8 text-gray-500 dark:text-gray-300"
        >
          Product
        </div>
        <p
          class="font-normal text-xl leading-8 text-gray-500 flex items-center justify-between"
        >
          <span class="w-full max-w-[260px] text-center dark:text-gray-300"
            >Quantity</span
          >
          <span class="w-full max-w-[200px] text-center dark:text-gray-300"
            >Total</span
          >
          <span
            class="w-full max-w-[200px] text-center dark:text-gray-300"
          ></span>
        </p>
      </div>
      <!-- Cart items -->
      <div
        v-for="(cartItem, index) in useCart.cart"
        :key="index"
        class="grid grid-cols-1 lg:grid-cols-2 min-[550px]:gap-6 border-t border-gray-200 py-6"
      >
        <div
          class="flex items-center flex-col min-[550px]:flex-row gap-3 min-[550px]:gap-6 w-full max-xl:justify-center max-xl:max-w-xl max-xl:mx-auto"
        >
          <div class="img-box">
            <img
              src="https://pagedone.io/asset/uploads/1701162850.png"
              alt="perfume bottle image"
              class="xl:w-[140px]"
            />
          </div>
          <div class="pro-data w-full max-w-sm">
            <h5
              class="font-semibold text-xl leading-8 text-black max-[550px]:text-center dark:text-white"
            >
              {{ cartItem.product.name }}
            </h5>
            <p
              class="font-normal text-lg leading-8 text-gray-500 my-2 min-[550px]:my-3 max-[550px]:text-center"
            >
              {{
                cartItem.sku?.variant[0]?.subOptions[0]
                  ? cartItem.sku?.variant[0]?.subOptions[0].Attribute.name +
                    " : "
                  : cartItem.sku?.variant[0]
                  ? cartItem.sku?.variant[0]?.Attribute.name + " : "
                  : ""
              }}

              {{
                cartItem.sku?.variant[0]?.subOptions[0]
                  ? cartItem.sku?.variant[0]?.subOptions[0].value
                  : cartItem.sku?.variant[0]?.value
              }}
            </p>
            <h6
              class="font-medium text-lg leading-8 text-indigo-600 max-[550px]:text-center dark:text-indigo-300"
            >
              ${{
                cartItem.sku?.variant[0]?.subOptions[0]
                  ? cartItem.sku?.variant[0]?.subOptions[0]?.price
                  : cartItem.sku?.price
              }}
            </h6>
          </div>
        </div>
        <div
          class="flex items-center flex-col min-[550px]:flex-row w-full max-xl:max-w-xl max-xl:mx-auto gap-2"
        >
          <div class="flex items-center w-full mx-auto justify-start">
            <button
              :disabled="isDecrementDisabled(cartItem.product.id)"
              @click.prevent="updateQuantityByDencrement(cartItem.product.id)"
              class="group rounded-l-full px-6 py-[18px] border border-gray-200 flex items-center justify-center shadow-sm shadow-transparent transition-all duration-500 hover:shadow-gray-200 hover:border-gray-300 hover:bg-gray-50 dark:bg-gray-600 disabled:bg-gray-800 disabled:cursor-not-allowed"
            >
              <svg
                class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black"
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 22 22"
                fill="none"
              >
                <path
                  d="M16.5 11H5.5"
                  stroke=""
                  stroke-width="1.6"
                  stroke-linecap="round"
                />
                <path
                  d="M16.5 11H5.5"
                  stroke=""
                  stroke-opacity="0.2"
                  stroke-width="1.6"
                  stroke-linecap="round"
                />
                <path
                  d="M16.5 11H5.5"
                  stroke=""
                  stroke-opacity="0.2"
                  stroke-width="1.6"
                  stroke-linecap="round"
                />
              </svg>
            </button>
            <input
              type="text"
              class="border-y border-gray-200 outline-none text-gray-900 font-semibold text-lg w-full max-w-[118px] min-w-[80px] placeholder:text-white py-[15px] text-center bg-transparent dark:text-white"
              :value="cartItem.quantity"
            />

            <h1></h1>
            <button
              :disabled="isIncrementDisabled(cartItem.product.id)"
              @click.prevent="updateQuantityByIncrement(cartItem.product.id)"
              class="group rounded-r-full px-6 py-[18px] border border-gray-200 flex items-center justify-center shadow-sm shadow-transparent transition-all duration-500 hover:shadow-gray-200 hover:border-gray-300 hover:bg-gray-50 dark:bg-gray-600 disabled:bg-gray-800 disabled:cursor-not-allowed"
            >
              <svg
                class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black"
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 22 22"
                fill="none"
              >
                <path
                  d="M11 5.5V16.5M16.5 11H5.5"
                  stroke=""
                  stroke-width="1.6"
                  stroke-linecap="round"
                />
                <path
                  d="M11 5.5V16.5M16.5 11H5.5"
                  stroke=""
                  stroke-opacity="0.2"
                  stroke-width="1.6"
                  stroke-linecap="round"
                />
                <path
                  d="M11 5.5V16.5M16.5 11H5.5"
                  stroke=""
                  stroke-opacity="0.2"
                  stroke-width="1.6"
                  stroke-linecap="round"
                />
              </svg>
            </button>
          </div>
          <h6
            class="text-indigo-300 font-manrope font-bold text-2xl leading-9 w-full max-w-[176px] text-center"
          >
            ${{ cartItem.totalPrice }}
          </h6>

          <!-- Delete button -->
          <div class="flex items-center w-full mx-auto justify-center">
            <button
              @click.prevent="deleteItemCart(cartItem.id)"
              class="rounded-full group flex items-center justify-center focus-within:outline-red-500"
            >
              <svg
                width="53"
                height="53"
                viewBox="0 0 34 34"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <circle
                  class="fill-red-50 transition-all duration-500 group-hover:fill-red-400"
                  cx="17"
                  cy="17"
                  r="17"
                  fill=""
                />
                <path
                  class="stroke-red-500 transition-all duration-500 group-hover:stroke-white"
                  d="M14.1673 13.5997V12.5923C14.1673 11.8968 14.7311 11.333 15.4266 11.333H18.5747C19.2702 11.333 19.834 11.8968 19.834 12.5923V13.5997M19.834 13.5997C19.834 13.5997 14.6534 13.5997 11.334 13.5997C6.90804 13.5998 27.0933 13.5998 22.6673 13.5997C21.5608 13.5997 19.834 13.5997 19.834 13.5997ZM12.4673 13.5997H21.534V18.8886C21.534 20.6695 21.534 21.5599 20.9807 22.1131C20.4275 22.6664 19.5371 22.6664 17.7562 22.6664H16.2451C14.4642 22.6664 13.5738 22.6664 13.0206 22.1131C12.4673 21.5599 12.4673 20.6695 12.4673 18.8886V13.5997Z"
                  stroke="#EF4444"
                  stroke-width="1.6"
                  stroke-linecap="round"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div
        class="bg-gray-50 rounded-xl p-6 w-full mb-8 max-lg:max-w-xl max-lg:mx-auto dark:bg-gray-500"
      >
        <div class="flex items-center justify-between w-full mb-6">
          <p
            class="font-normal text-xl leading-8 text-gray-400 dark:text-white"
          >
            Sub Total
          </p>
          <h6
            class="font-semibold text-xl leading-8 text-gray-900 dark:text-white"
          >
            ${{Total}}
          </h6>
        </div>
        <div
          class="flex items-center justify-between w-full pb-6 border-b border-gray-200"
        >
          <p
            class="font-normal text-xl leading-8 text-gray-400 dark:text-white"
          >
            Delivery Charge
          </p>
          <h6
            class="font-semibold text-xl leading-8 text-gray-900 dark:text-white"
          >
            $0
          </h6>
        </div>
        <div class="flex items-center justify-between w-full py-6">
          <p
            class="font-manrope font-medium text-2xl leading-9 text-gray-900 dark:text-white"
          >
            Total
          </p>
          <h6
            class="font-manrope font-medium text-2xl leading-9 text-indigo-200"
          >
            ${{Total}}
          </h6>
        </div>
      </div>
      <div
        class="flex items-center flex-col sm:flex-row justify-center gap-3 mt-8"
      >
        <button
          class="rounded-full py-4 w-full max-w-[280px] flex items-center bg-indigo-50 justify-center transition-all duration-500 hover:bg-indigo-100"
        >
          <span class="px-2 font-semibold text-lg leading-8 text-indigo-600"
            >Add Coupon Code</span
          >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="22"
            height="22"
            viewBox="0 0 22 22"
            fill="none"
          >
            <path
              d="M8.25324 5.49609L13.7535 10.9963L8.25 16.4998"
              stroke="#4F46E5"
              stroke-width="1.6"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </button>
        <button
          @click.prevent="payment"
          class="rounded-full w-full max-w-[280px] py-4 text-center justify-center items-center bg-indigo-600 font-semibold text-lg text-white flex transition-all duration-500 hover:bg-indigo-700"
        >
          <div class="btn-text flex items-center justify-center">
            Continue to Payment

            <svg
              class="ml-2"
              xmlns="http://www.w3.org/2000/svg"
              width="23"
              height="22"
              viewBox="0 0 23 22"
              fill="none"
            >
              <path
                d="M8.75324 5.49609L14.2535 10.9963L8.75 16.4998"
                stroke="white"
                stroke-width="1.6"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </div>
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { loadStripe } from "@stripe/stripe-js";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import LoadingIndicator from "../components/LoadingIndicator.vue";
import { useCartStore } from "../stores/cart";
const router = useRouter();
const useCart = useCartStore();

const isIncrementDisabled = (productID) => {
  const cartItems = useCart.cart.find((c) => c.product.id == productID);
  if (cartItems?.sku?.variant[0] && cartItems?.sku?.variant[0]?.subOptions[0]) {
    if (cartItems?.quantity >= cartItems.sku?.variant[0]?.subOptions[0]?.stock) {
      return "disabled";
    }
    // console.log(cartItems.sku.variant[0].subOptions[0]);
  } else {
    if (cartItems.quantity >= cartItems.sku.stock) {
      return "disabled";
    }
  }
};


const isDecrementDisabled = (productID) => {
  const cartItems = useCart.cart.find((c) => c.product.id == productID);
  if (cartItems?.sku?.variant[0] && cartItems?.sku?.variant[0]?.subOptions[0]) {
    if (cartItems.quantity == 1) {
      return "disabled";
    }
    // console.log(cartItems.sku.variant[0].subOptions[0]);
  } else {
    if (cartItems.quantity == 1) {
      return "disabled";
    }
  }
};

function updateQuantityByIncrement(productID) {
  useCart.updateIncrementValue(productID);
}

function updateQuantityByDencrement(productID) {
  useCart.updateDecrementValue(productID);
  // const cartItems = useCart.cart.find((c) => c.product.id == productID);
  //   if (cartItems.sku.variant[0] && cartItems.sku.variant[0].subOptions[0]) {
  //     if (cartItems.quantity <= cartItems.sku.variant[0].subOptions[0].stock && cartItems.quantity > 1) {
  //       cartItems.quantity = cartItems.quantity -= 1;
  //     }
  //     // console.log(cartItems.sku.variant[0].subOptions[0]);
  //   } else {
  //     if (cartItems.quantity <= cartItems.sku.stock && cartItems.quantity > 1) {
  //         console.log(cartItems.quantity);
  //     //   cartItems.quantity = cartItems.quantity -= 1;
  //     }
  //   }
}
const Total = computed(()=>{
    return useCart.cart.reduce( (total , item )=> total + item.totalPrice , 0) 
})

function payment() {
  router.push({name : "Payment"});
}

function deleteItemCart(cartItemID) {
  useCart.deleteItemFromCart(cartItemID);
}


onMounted(async () => {
  await useCart.getCartItems();
});
</script>