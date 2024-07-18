<template>
  <section class="bg-white py-8 antialiased dark:bg-gray-900">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
      <h1
        class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-3xl dark:text-white"
      >
        Reviews
      </h1>

      <div class="my-6 gap-8 sm:flex sm:items-start md:my-8">
        <div class="shrink-0 space-y-4">
          <p
            class="text-2xl font-semibold leading-none text-gray-900 dark:text-white"
          >
            {{ productStore.singleProduct?.overall_rating?.overall }} out of 5
          </p>
          <button
            v-show="
              singleRating?.user?.id == authStore?.user?.data.id &&
              !productStore.singleProduct?.isProductRatedByLoggedInUser?.isRated
            "
            type="button"
            data-modal-target="review-modal"
            data-modal-toggle="review-modal"
            class="mb-2 me-2 rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:text-indigo-700 dark:text-indigo dark:bg-white dark:hover:bg-indigo-100 dark:hover:text-indigo-700 dark:focus:ring-primary-800 transition-all"
          >
            Write a review
          </button>
        </div>

        <div class="mt-6 min-w-0 flex-1 space-y-3 sm:mt-0">
          <div
            class="flex items-center gap-2"
            v-for="(ratePercentage, index) in productStore.singleProduct
              .percentageRating"
            :key="index"
          >
            <p
              class="w-2 shrink-0 text-start text-sm font-medium leading-none text-gray-900 dark:text-white"
            >
              {{ ratePercentage.key }}
            </p>
            <svg
              class="h-4 w-4 shrink-0 text-yellow-300"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
              />
            </svg>
            <div class="h-1.5 w-80 rounded-full bg-gray-200 dark:bg-gray-700">
              <div
                class="h-1.5 rounded-full bg-yellow-300"
                :style="'width:' + ratePercentage.percentage + '%'"
              ></div>
            </div>
            <a
              href="#"
              class="w-8 shrink-0 text-right text-sm font-medium leading-none text-primary-700 hover:underline dark:text-primary-500 sm:w-auto sm:text-left dark:text-white"
              >{{ ratePercentage.countRating }}
              <span class="hidden sm:inline">reviews</span></a
            >
          </div>
        </div>
      </div>

      <div class="mt-6 divide-y divide-gray-200 dark:divide-gray-700 rounded">
        <div
          v-for="(singleRating, index) in productStore.singleProduct.rating"
          :key="index"
          :class="
            singleRating?.user?.id == authStore.user.data.id &&
            productStore.singleProduct.isProductRatedByLoggedInUser.isRated
              ? 'h-36 w-full rounded-md bg-gradient-to-r from-indigo-300 to-indigo-500 p-1 mb-2'
              : ''
          "
        >
          <div
            class="w-full h-full gap-3 pt-6 pb-3 sm:flex sm:items-start mb-4 hover:text-white dark:text-white"
            :class="
              singleRating.user.id == authStore.user.data.id &&
              productStore.singleProduct.isProductRatedByLoggedInUser.isRated
                ? 'bg-gray-800 p-3'
                : ''
            "
          >
            <div class="shrink-0 space-y-2 sm:w-48 md:w-72">
              <div class="flex items-center gap-0.5">
                <svg
                  v-for="(singleStar, index) in reviewerStars"
                  :key="index"
                  class="h-4 w-4 text-yellow-300"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  :fill="
                    singleRating.rating >= singleStar ? 'currentColor' : 'gray'
                  "
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                  />
                </svg>
              </div>

              <div class="space-y-0.5">
                <p
                  class="text-base font-semibold text-gray-900 dark:text-white"
                >
                  {{ singleRating.user.name }}
                </p>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                  {{ singleRating.created_at }}
                </p>
              </div>

              <div class="inline-flex items-center gap-1">
                <svg
                  class="h-5 w-5 text-primary-700 dark:text-primary-500"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill-rule="evenodd"
                    d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z"
                    clip-rule="evenodd"
                  />
                </svg>
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                  Verified purchase
                </p>
              </div>
            </div>

            <div class="mt-4 min-w-0 flex-1 space-y-4 sm:mt-0">
              <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                {{ singleRating.message }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-6 text-center">
        <button
          type="button"
          class="mb-2 me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
        >
          View more reviews
        </button>
      </div>
    </div>
  </section>

  <!-- Add review modal -->
  <div
    id="review-modal"
    tabindex="-1"
    aria-hidden="true"
    class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 antialiased"
  >
    <div class="relative max-h-full w-full max-w-2xl p-4">
      <!-- Modal content -->
      <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
        <!-- Modal header -->
        <div
          class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 dark:border-gray-700 md:p-5"
        >
          <div>
            <h3
              class="mb-1 text-lg font-semibold text-gray-900 dark:text-white"
            >
              Add a review
            </h3>
          </div>
          <button
            type="button"
            class="absolute right-5 top-5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-toggle="review-modal"
          >
            <svg
              class="h-3 w-3"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 14 14"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
              />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>

        <!-- Modal body -->
        <form ref="inner_modal" class="p-4 md:p-5">
          <div class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2">
              <div class="flex items-center">
                <!-- Rating -->
                <div class="flex flex-row-reverse justify-end items-center">
                  <input
                    @click="rate(5)"
                    id="hs-ratings-readonly-1"
                    type="radio"
                    class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
                    name="hs-ratings-readonly"
                  />
                  <label
                    for="hs-ratings-readonly-1"
                    class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600"
                  >
                    <svg
                      class="flex-shrink-0 size-5"
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      viewBox="0 0 16 16"
                    >
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                      ></path>
                    </svg>
                  </label>
                  <input
                    @click="rate(4)"
                    id="hs-ratings-readonly-2"
                    type="radio"
                    class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
                    name="hs-ratings-readonly"
                    value="4"
                    v-model="data.rating"
                  />
                  <label
                    for="hs-ratings-readonly-2"
                    class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600"
                  >
                    <svg
                      class="flex-shrink-0 size-5"
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      viewBox="0 0 16 16"
                    >
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                      ></path>
                    </svg>
                  </label>
                  <input
                    @click="rate(3)"
                    id="hs-ratings-readonly-3"
                    type="radio"
                    class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
                    name="hs-ratings-readonly"
                    value="3"
                    v-model="data.rating"
                  />
                  <label
                    for="hs-ratings-readonly-3"
                    class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600"
                  >
                    <svg
                      class="flex-shrink-0 size-5"
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      viewBox="0 0 16 16"
                    >
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                      ></path>
                    </svg>
                  </label>
                  <input
                    @click="rate(2)"
                    id="hs-ratings-readonly-4"
                    type="radio"
                    class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
                    name="hs-ratings-readonly"
                    value="2"
                    v-model="data.rating"
                  />
                  <label
                    for="hs-ratings-readonly-4"
                    class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600"
                  >
                    <svg
                      class="flex-shrink-0 size-5"
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      viewBox="0 0 16 16"
                    >
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                      ></path>
                    </svg>
                  </label>

                  <input
                    @click="rate(1)"
                    id="hs-ratings-readonly-5"
                    type="radio"
                    class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
                    name="hs-ratings-readonly"
                    value="1"
                    v-model="data.rating"
                  />
                  <label
                    for="hs-ratings-readonly-5"
                    class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600"
                  >
                    <svg
                      class="flex-shrink-0 size-5"
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      viewBox="0 0 16 16"
                    >
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                      ></path>
                    </svg>
                  </label>
                </div>
                <!-- End Rating -->
                <span
                  class="ms-2 text-lg font-bold text-gray-900 dark:text-white"
                  >{{ data.rating }} out of 5</span
                >
              </div>
            </div>
            <div class="col-span-2">
              <label
                for="description"
                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                >Review description</label
              >
              <textarea
                id="description"
                rows="6"
                class="mb-2 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                required=""
                v-model="data.message"
              ></textarea>
              <p class="ms-auto text-xs text-gray-500 dark:text-gray-400">
                Problems with the product or delivery?
                <a
                  href="#"
                  class="text-primary-600 hover:underline dark:text-primary-500"
                  >Send a report</a
                >.
              </p>
            </div>
            <div class="col-span-2">
              <div class="flex items-center">
                <input
                  id="review-checkbox"
                  type="checkbox"
                  value=""
                  class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-primary-600 focus:ring-2 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                />
                <label
                  for="review-checkbox"
                  class="ms-2 text-sm font-medium text-gray-500 dark:text-gray-400"
                  >By publishing this review you agree with the
                  <a
                    href="#"
                    class="text-primary-600 hover:underline dark:text-primary-500"
                    >terms and conditions</a
                  >.</label
                >
              </div>
            </div>
          </div>
          <div
            class="border-t border-gray-200 pt-4 dark:border-gray-700 md:pt-5"
          >
            <button
              @click.prevent="submitRating(productStore.singleProduct.id)"
              type="submit"
              class="me-2 inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 dark:text-indigo-700 dark:hover:text-indigo-900 focus:ring-primary-300 dark:bg-white dark:hover:bg-indigo-100 dark:focus:ring-indigo-800"
            >
              Add review
            </button>
            <button
              type="button"
              data-modal-toggle="review-modal"
              class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
            >
              Cancel
            </button>
          </div>
        </form>

        <!-- Main modal -->
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { useProductStore } from "../stores/products";
import { useRatingStore } from "../stores/rating";
import { initFlowbite, Modal } from "flowbite";
import { useAuthStore } from "../stores/auth";

const productStore = useProductStore();
const ratingStore = useRatingStore();
const authStore = useAuthStore();
const reviewerStars = ref([1, 2, 3, 4, 5]);
const data = ref({
  productID: "",
  rating: 1,
  message: "",
});
function rate(value) {
  data.value.rating = value;
}

function submitRating(productID) {
  data.value.productID = productID;
  ratingStore.addRating(data);
}

onMounted(() => {});
</script>