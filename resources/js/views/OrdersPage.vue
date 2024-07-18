<template>
  <section class="py-24 relative dark:bg-gray-900 h-full">
    <div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto">
      <h1
        class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 dark:text-white mb-5"
      >
        {{ route.name }}
      </h1>
      <div class="flex items-start flex-col gap-6 xl:flex-row">
        <div class="w-full max-w-sm md:max-w-full max-xl:mx-auto">
          <div class="grid grid-cols-1 gap-6">
            <div
              v-for="(singleOrder, index) in orderStore.order"
              :key="index"
              class="bg-gray-700 rounded-3xl p-6 bg-gray-100 border border-gray-400 flex flex-col md:flex-row md:items-center gap-5 transition-all duration-500 hover:border-gray-100"
            >
              <div
                class="img-box border-white bg-indigo-100 p-4 rounded-lg flex justify-center items-center"
              >
                <svg
                  version="1.1"
                  id="Layer_1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  viewBox="0 0 512 512"
                  xml:space="preserve"
                  fill="#000000"
                  width="80px"
                  height="80px"
                >
                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                  <g
                    id="SVGRepo_tracerCarrier"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></g>
                  <g id="SVGRepo_iconCarrier">
                    <path
                      style="fill: #ffe6b8"
                      d="M441.249,432.314H70.751c-33.441,0-60.552-27.11-60.552-60.553l0,0 c0-33.442,27.111-60.552,60.552-60.552h370.497c33.442,0,60.552,27.111,60.552,60.552l0,0 C501.801,405.203,474.69,432.314,441.249,432.314z"
                    ></path>
                    <g>
                      <circle
                        style="fill: #ffad61"
                        cx="70.507"
                        cy="371.761"
                        r="24.611"
                      ></circle>
                      <circle
                        style="fill: #ffad61"
                        cx="162.575"
                        cy="371.761"
                        r="24.611"
                      ></circle>
                      <circle
                        style="fill: #ffad61"
                        cx="255.541"
                        cy="371.761"
                        r="24.611"
                      ></circle>
                      <circle
                        style="fill: #ffad61"
                        cx="348.517"
                        cy="371.761"
                        r="24.611"
                      ></circle>
                      <circle
                        style="fill: #ffad61"
                        cx="441.493"
                        cy="371.761"
                        r="24.611"
                      ></circle>
                      <rect
                        x="131.57"
                        y="79.686"
                        style="fill: #ffad61"
                        width="248.861"
                        height="231.522"
                      ></rect>
                    </g>
                    <rect
                      x="227.442"
                      y="79.686"
                      style="fill: #ffe6b8"
                      width="57.116"
                      height="68.335"
                    ></rect>
                    <g>
                      <path
                        style="fill: #4d3d36"
                        d="M131.57,69.487c-5.632,0-10.199,4.566-10.199,10.199v221.323h-50.62 C31.739,301.009,0,332.749,0,371.761s31.739,70.752,70.751,70.752h370.498c39.012,0,70.751-31.739,70.751-70.752 s-31.739-70.752-70.751-70.752h-50.62V79.686c0-5.633-4.567-10.199-10.199-10.199C380.43,69.487,131.57,69.487,131.57,69.487z M274.359,89.886v47.936h-36.717V89.886C237.641,89.886,274.359,89.886,274.359,89.886z M141.769,89.886h75.474v58.135 c0,5.633,4.567,10.199,10.199,10.199h57.116c5.632,0,10.199-4.566,10.199-10.199V89.886h75.474v211.124H266.199v-80.574 c0-5.633-4.567-10.199-10.199-10.199c-5.632,0-10.199,4.566-10.199,10.199v80.574H141.769V89.886z M441.249,422.114H70.751 c-27.765,0-50.352-22.588-50.352-50.353c0-27.765,22.587-50.353,50.352-50.353h370.498c27.765,0,50.352,22.588,50.352,50.353 C491.602,399.526,469.014,422.114,441.249,422.114z"
                      ></path>
                      <path
                        style="fill: #4d3d36"
                        d="M70.507,336.951c-19.194,0-34.81,15.616-34.81,34.81c0,19.194,15.616,34.81,34.81,34.81 s34.811-15.616,34.811-34.81C105.318,352.567,89.701,336.951,70.507,336.951z M70.507,386.172c-7.946,0-14.411-6.465-14.411-14.411 c0-7.946,6.465-14.411,14.411-14.411c7.947,0,14.412,6.465,14.412,14.411C84.92,379.707,78.454,386.172,70.507,386.172z"
                      ></path>
                      <path
                        style="fill: #4d3d36"
                        d="M162.57,336.951c-19.194,0-34.81,15.616-34.81,34.81c0,19.194,15.616,34.81,34.81,34.81 s34.811-15.616,34.811-34.81C197.381,352.567,181.764,336.951,162.57,336.951z M162.57,386.172 c-7.946,0-14.411-6.465-14.411-14.411c0-7.946,6.465-14.411,14.411-14.411c7.947,0,14.412,6.465,14.412,14.411 C176.983,379.707,170.517,386.172,162.57,386.172z"
                      ></path>
                      <path
                        style="fill: #4d3d36"
                        d="M255.544,336.951c-19.194,0-34.81,15.616-34.81,34.81c0,19.194,15.616,34.81,34.81,34.81 c19.194,0,34.811-15.616,34.811-34.81C290.355,352.567,274.738,336.951,255.544,336.951z M255.544,386.172 c-7.946,0-14.411-6.465-14.411-14.411c0-7.946,6.465-14.411,14.411-14.411c7.947,0,14.412,6.465,14.412,14.411 C269.957,379.707,263.491,386.172,255.544,386.172z"
                      ></path>
                      <path
                        style="fill: #4d3d36"
                        d="M348.519,336.951c-19.194,0-34.811,15.616-34.811,34.81c0,19.194,15.617,34.81,34.811,34.81 c19.194,0,34.81-15.616,34.81-34.81C383.329,352.567,367.713,336.951,348.519,336.951z M348.519,386.172 c-7.947,0-14.413-6.465-14.413-14.411c0-7.946,6.465-14.411,14.413-14.411c7.946,0,14.411,6.465,14.411,14.411 C362.931,379.707,356.465,386.172,348.519,386.172z"
                      ></path>
                      <path
                        style="fill: #4d3d36"
                        d="M441.493,336.951c-19.194,0-34.811,15.616-34.811,34.81c0,19.194,15.617,34.81,34.811,34.81 s34.81-15.616,34.81-34.81C476.303,352.567,460.687,336.951,441.493,336.951z M441.493,386.172 c-7.947,0-14.413-6.465-14.413-14.411c0-7.946,6.465-14.411,14.413-14.411c7.946,0,14.411,6.465,14.411,14.411 C455.904,379.707,449.439,386.172,441.493,386.172z"
                      ></path>
                      <path
                        style="fill: #4d3d36"
                        d="M256,195.957c5.632,0,10.199-4.566,10.199-10.199v-3.06c0-5.633-4.567-10.199-10.199-10.199 c-5.632,0-10.199,4.566-10.199,10.199v3.06C245.801,191.391,250.368,195.957,256,195.957z"
                      ></path>
                    </g>
                  </g>
                </svg>
              </div>
              <div
                class="grid grid-cols-1 md:grid-cols-2 w-full gap-3 md:gap-8"
              >
                <div>
                  <h2
                    class="font-medium text-lg leading-8 text-black mb-3 dark:text-white"
                  >
                    Order Number:
                    <span class="font-bold text-xl"
                      >#{{ singleOrder.orderNumber }}</span
                    >
                  </h2>
                  <p
                    class="font-normal text-lg leading-8 text-gray-500 dark:text-gray-200"
                  >
                    {{ singleOrder.createdAt }}
                  </p>
                </div>

                <div class="status-badge text-end">
                  <span
                    class="bg-blue-100 text-blue-800 text-md font-medium me-2 px-4 py-1.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400"
                    :class="singleOrder.status =='Pending' ? 'bg-blue-100 text-blue-800 text-md font-medium me-2 px-4 py-1.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400' : singleOrder.status == 'Shipped' ? 'bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300' : 'bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400'"
                     
                    >{{singleOrder.status}}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted ,computed} from "vue";
import { useRoute, useRouter } from "vue-router";
import { useOrderStore } from "../stores/order.js";
const router = useRouter();
const route = useRoute();
const orderStore = useOrderStore();


onMounted(async () => {
  await orderStore.getOrders();
});
</script>