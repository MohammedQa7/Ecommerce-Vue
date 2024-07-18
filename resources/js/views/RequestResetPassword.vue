<template>
  <section class="bg-gray-50 dark:bg-gray-900">
    <div
      class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
    >
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
      >
        <div v-if="!isSent" class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1
            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
          >
            Rest Password
          </h1>
          <form class="space-y-4 md:space-y-6" action="#">
            <div>
              <label
                for="email"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your email</label
              >
              <input
                v-model="email"
                type="email"
                name="email"
                id="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="name@company.com"
                required=""
              />
            </div>

            <button
              @click.prevent="resetPasswordRequest"
              :disabled="isLoading"
              :class="isLoadingChangeClass"
              class="w-full text-white focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-sky-500"
            >
              <p v-if="!isLoading">Send Rest Link</p>
              <loading-indicator v-else></loading-indicator>
            </button>
          </form>
          <div
            v-if="errors?.message"
            class="flex text-sm text-red-800 rounded-lg bg-red-50 dark:text-red-400 p-2 mt-2"
            role="alert"
          >
            <svg
              class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
              />
            </svg>
            <span class="sr-only">Danger</span>
            <div>
              <span class="font-medium">{{ errors.message }}</span>
            </div>
          </div>
        </div>
        <success-pop-up v-if="isSent" :successMessage="success"></success-pop-up>
      </div>
    </div>
  </section>
</template>


<script setup>
import { ref, computed } from "vue";
import axios from "axios";
import LoadingIndicator from "../components/LoadingIndicator.vue";
import SuccessPopUp from "../components/SuccessPopUp.vue";
axios.defaults.baseURL = "http://127.0.0.1:8000/api/v1/";
const email = ref();
const errors = ref([]);
const success = ref("asdlknaslkdn");
let isLoading = ref(false);
let isSent = ref(false);

async function resetPasswordRequest() {
  isLoading.value = !isLoading.value;
  // try {
  //   const res = await axios.post("forgot-password", {
  //     email: email.value,
  //   })
  //    success.value = res.response.data;
  //     isLoading.value = !isLoading.value;
  //     isSent.value = !isSent.value;
  // } catch (error) {
  //   // isLoading.value = !isLoading.value;
  //   if (error.response) {
  //     if (error.response.status === 422) {
  //       errors.value = error.response.data;
  //     }
  //   }
  // }

  await axios
    .post("forgot-password", { email: email.value })
    .then((response) => {
      success.value = response.data.status;
      isLoading.value = !isLoading.value;
      isSent.value = !isSent.value;
    })
    .catch((error) => {
      if (error.response) {
        if (error.response.status === 422) {
          errors.value = error.response.data;
        }
      }
    });
}

const isLoadingChangeClass = computed(() => {
  return { "bg-gray-600": isLoading.value == true };
});
</script>