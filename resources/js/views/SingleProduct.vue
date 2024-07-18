<template>
  <section class="py-24 dark:bg-gray-900 flex items-center flex-col">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="slider-box w-full h-full max-lg:mx-auto mx-0">
          <div class="swiper-images">
            <swiper-container
              style="
                --swiper-navigation-color: #fff;
                --swiper-pagination-color: #fff;
              "
              class="mySwiper border rounded-lg overflow-hidden shadow"
              thumbs-swiper=".mySwiper2"
              space-between="10"
              navigation="true"
            >
              <swiper-slide
                v-for="(productImage, index) in productStore.singleProduct
                  .images"
                :key="index"
              >
                <img :src="productImage.ImagePath" />
              </swiper-slide>
            </swiper-container>

            <swiper-container
              class="mySwiper2"
              space-between="10"
              slides-per-view="4"
              free-mode="true"
              watch-slides-progress="true"
            >
              <swiper-slide
                class="border rounded-lg overflow-hidden shadow"
                v-for="(productImage, index) in productStore.singleProduct
                  .images"
                :key="index"
              >
                <img :src="productImage.ImagePath" />
              </swiper-slide>
            </swiper-container>
          </div>
        </div>
        <div class="flex justify-center items-center">
          <div
            class="pro-detail w-full max-lg:max-w-[608px] lg:pl-8 xl:pl-16 max-lg:mx-auto max-lg:mt-8"
          >
            <div class="flex items-center justify-between gap-6 mb-6">
              <div class="text">
                <h2
                  class="font-manrope font-bold text-3xl leading-10 text-gray-900 mb-2 dark:text-white"
                >
                  {{ productStore.singleProduct.name }}
                </h2>
                <p class="font-normal text-base text-gray-500 dark:text-white">
                  {{ productStore.singleProduct?.category?.name }}
                </p>
              </div>
              <button
                class="group transition-all duration-500 p-0.5 bg-white p-3.5 rounded-full"
                @click.prevent="favorite()"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  :class="
                    isFavorited(productStore?.singleProduct?.is_favorited).class
                  "
                >
                  <path
                    class="transition-all duration-500"
                    :stroke="
                      isFavorited(productStore?.singleProduct?.is_favorited)
                        .stroke
                    "
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"
                  />
                </svg>
              </button>
            </div>

            <div
              class="flex flex-col min-[400px]:flex-row min-[400px]:items-center mb-8 gap-y-3"
            >
              <div class="flex items-center">
                <h5
                  class="font-manrope font-semibold text-2xl leading-9 text-gray-900 dark:text-white"
                >
                  $ {{ getPriceBasedOnSelectedSubOption?.price }}
                </h5>
                <span class="ml-3 font-semibold text-lg text-indigo-600"
                  >30% off</span
                >
              </div>
              <svg
                class="mx-5 max-[400px]:hidden"
                xmlns="http://www.w3.org/2000/svg"
                width="2"
                height="36"
                viewBox="0 0 2 36"
                fill="none"
              >
                <path d="M1 0V36" stroke="#E5E7EB" />
              </svg>
              <button
                class="flex items-center gap-1 rounded-lg bg-amber-400 py-1.5 px-2.5 w-max"
              >
                <svg
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g clip-path="url(#clip0_12657_16865)">
                    <path
                      d="M8.10326 2.26718C8.47008 1.52393 9.52992 1.52394 9.89674 2.26718L11.4124 5.33818C11.558 5.63332 11.8396 5.83789 12.1653 5.88522L15.5543 6.37768C16.3746 6.49686 16.7021 7.50483 16.1086 8.08337L13.6562 10.4738C13.4205 10.7035 13.313 11.0345 13.3686 11.3589L13.9475 14.7343C14.0877 15.5512 13.2302 16.1742 12.4966 15.7885L9.46534 14.1948C9.17402 14.0417 8.82598 14.0417 8.53466 14.1948L5.5034 15.7885C4.76978 16.1742 3.91235 15.5512 4.05246 14.7343L4.63137 11.3589C4.68701 11.0345 4.57946 10.7035 4.34378 10.4738L1.89144 8.08337C1.29792 7.50483 1.62543 6.49686 2.44565 6.37768L5.8347 5.88522C6.16041 5.83789 6.44197 5.63332 6.58764 5.33818L8.10326 2.26718Z"
                      fill="white"
                    />
                    <g clip-path="url(#clip1_12657_16865)">
                      <path
                        d="M8.10326 2.26718C8.47008 1.52393 9.52992 1.52394 9.89674 2.26718L11.4124 5.33818C11.558 5.63332 11.8396 5.83789 12.1653 5.88522L15.5543 6.37768C16.3746 6.49686 16.7021 7.50483 16.1086 8.08337L13.6562 10.4738C13.4205 10.7035 13.313 11.0345 13.3686 11.3589L13.9475 14.7343C14.0877 15.5512 13.2302 16.1742 12.4966 15.7885L9.46534 14.1948C9.17402 14.0417 8.82598 14.0417 8.53466 14.1948L5.5034 15.7885C4.76978 16.1742 3.91235 15.5512 4.05246 14.7343L4.63137 11.3589C4.68701 11.0345 4.57946 10.7035 4.34378 10.4738L1.89144 8.08337C1.29792 7.50483 1.62543 6.49686 2.44565 6.37768L5.8347 5.88522C6.16041 5.83789 6.44197 5.63332 6.58764 5.33818L8.10326 2.26718Z"
                        fill="white"
                      />
                    </g>
                  </g>
                  <defs>
                    <clipPath id="clip0_12657_16865">
                      <rect width="18" height="18" fill="white" />
                    </clipPath>
                    <clipPath id="clip1_12657_16865">
                      <rect width="18" height="18" fill="white" />
                    </clipPath>
                  </defs>
                </svg>
                <span class="text-base font-medium text-white">{{
                  productStore.singleProduct?.overall_rating?.overall
                }}</span>
              </button>
            </div>

            <div
              v-for="(singleAttributeName, index) in AttributeName"
              :key="index"
              class="product-variants"
            >
              <p class="font-medium text-lg text-gray-900 mb-2 dark:text-white">
                {{ singleAttributeName }}
              </p>
              <div
                class="grid grid-cols-2 min-[400px]:grid-cols-4 gap-3 mb-3 min-[400px]:mb-8"
              >
                <button
                  v-for="(singleProductSku, index) in productStore.singleProduct
                    .skus"
                  :key="index"
                  v-show="
                    singleProductSku?.variant[0] &&
                    singleProductSku.variant[0]?.Attribute.name ===
                      singleAttributeName
                  "
                  @click.prevent="
                    getSubOptionDataBasedOnSelection(singleProductSku?.code)
                  "
                  :class="
                    isOptionSelected?.code == singleProductSku?.code
                      ? isOptionSelected?.isActiveClass
                      : isOptionSelected?.isNotActiveClass
                  "
                >
                  {{ singleProductSku?.variant[0]?.value }}
                </button>
              </div>
            </div>
            <div
              v-show="subOptionsDataBasedOnSelection?.length > 0"
              class="sub-options-dropdown mb-5 relative"
            >
              <p class="font-medium text-lg text-gray-900 mb-2 dark:text-white">
                Select an option
              </p>
              <button
                id="dropdownToggleButton"
                data-dropdown-toggle="dropdownToggle"
                class="relative justify-between text-white w-full bg-gray-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-gray-600 dark:hover:bg-white dark:focus:ring-indigo-800 dark:focus:bg-white dark:focus:text-black dark:hover:text-black"
                type="button"
              >
                {{
                  isOptionSelected.subOptionName !== null
                    ? isOptionSelected.subOptionName
                    : "Select Option.."
                }}
                <svg
                  class="w-2.5 h-2.5 ms-3"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 10 6"
                >
                  <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 4 4 4-4"
                  />
                </svg>
              </button>

              <!-- Dropdown menu -->
              <div
                id="dropdownToggle"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full dark:bg-gray-700 dark:divide-gray-600"
              >
                <div
                  class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                  aria-labelledby="dropdownToggleButton"
                >
                  <div
                    v-for="(
                      subOptionItem, index
                    ) in subOptionsDataBasedOnSelection"
                    :key="index"
                    class="sub-options-btn flex justify-between items-center mb-3"
                  >
                    <button
                      :disabled="subOptionItem.stock == 0"
                      :class="
                        isOptionSelected.subOptionID == subOptionItem.id
                          ? 'dark:bg-white dark:hover:text-black dark:text-black '
                          : ''
                      "
                      @click.prevent="
                        assignSubOptionID(subOptionItem.id, subOptionItem.value)
                      "
                      class="border border-gray-200 whitespace-nowrap text-gray-900 text-sm leading-6 py-2.5 rounded-lg px-5 text-center w-full font-semibold shadow-sm shadow-transparent transition-all duration-300 hover:bg-gray-50 hover:shadow-gray-300 hover:text-black dark:text-white disabled:cursor-not-allowed "
                    >
                      {{ subOptionItem.value }}
                    </button>

                    <p
                      v-show="subOptionItem.stock <= 10"
                      class="ms-5 text-red-400"
                    >
                      {{ subOptionItem?.stock == 0 ? 'OUT OF STOCK' : "only" + subOptionItem.stock + "left in stock" }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="flex items-center flex-col min-[400px]:flex-row gap-3 mb-3 min-[400px]:mb-8"
            >
              <div class="flex items-center w-full mx-auto justify-start">
                <button
                  :disabled="isDecrementDisabled(productStore.singleProduct.id)"
                  @click.prevent="updateQuantityByDecrement()"
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
                  v-model="productStore.quantity"
                  type="text"
                  class="border-y border-gray-200 outline-none text-gray-900 font-semibold text-lg w-full max-w-[118px] min-w-[80px] placeholder:text-white py-[15px] text-center bg-transparent dark:text-white"
                />

                <h1></h1>
                <button
                  :disabled="isIncrementDisabled(productStore.singleProduct.id)"
                  @click.prevent="updateQuantityByIncrement()"
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
              <button
                @click.prevent="addToCart(isOptionSelected.code)"
                class="group py-3 px-5 rounded-full bg-indigo-50 text-indigo-600 font-semibold text-lg w-full flex items-center justify-center gap-2 shadow-sm shadow-transparent transition-all duration-500 hover:shadow-indigo-300 hover:bg-indigo-100"
              >
                <svg
                  class="stroke-indigo-600 transition-all duration-500 group-hover:stroke-indigo-600"
                  width="22"
                  height="22"
                  viewBox="0 0 22 22"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10.7394 17.875C10.7394 18.6344 10.1062 19.25 9.32511 19.25C8.54402 19.25 7.91083 18.6344 7.91083 17.875M16.3965 17.875C16.3965 18.6344 15.7633 19.25 14.9823 19.25C14.2012 19.25 13.568 18.6344 13.568 17.875M4.1394 5.5L5.46568 12.5908C5.73339 14.0221 5.86724 14.7377 6.37649 15.1605C6.88573 15.5833 7.61377 15.5833 9.06984 15.5833H15.2379C16.6941 15.5833 17.4222 15.5833 17.9314 15.1605C18.4407 14.7376 18.5745 14.0219 18.8421 12.5906L19.3564 9.84059C19.7324 7.82973 19.9203 6.8243 19.3705 6.16215C18.8207 5.5 17.7979 5.5 15.7522 5.5H4.1394ZM4.1394 5.5L3.66797 2.75"
                    stroke=""
                    stroke-width="1.6"
                    stroke-linecap="round"
                  />
                </svg>
                Add to cart
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <rating-section-component></rating-section-component>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useProductStore } from "../stores/products";
import { initFlowbite } from "flowbite";
import router from "../router";
import { useAuthStore } from "../stores/auth";
import RatingSectionComponent from "../components/RatingSectionComponent.vue";

const propData = defineProps(["slug"]);
const productStore = useProductStore();
const authStore = useAuthStore();

// we use the Set to make sure only unique values are stored in the array.
const AttributeName = ref(new Set());

const subOptionsDataBasedOnSelection = ref([]);
const isOptionSelected = ref({
  code: null,
  subOptionName: null,
  subOptionID: null,
  isActiveClass:
    "border border-gray-200 whitespace-nowrap text-gray-900 text-sm leading-6 py-2.5 rounded-full px-5 text-center w-full font-semibold shadow-sm shadow-transparent transition-all duration-300  dark:text-black dark:bg-white ",
  isNotActiveClass:
    "border border-gray-200 whitespace-nowrap text-gray-900 text-sm leading-6 py-2.5 rounded-full px-5 text-center w-full font-semibold shadow-sm shadow-transparent transition-all duration-300 hover:bg-gray-50 hover:shadow-gray-300 hover:text-black dark:text-white",
});
const subOptionPrice = ref();

const itemData = ref({
  productID: "",
  skuCode: "",
  subOptionID: "",
});

function pushAllAttributeNameToSeperateArray() {
  console.log(productStore.singleProduct);
  productStore.singleProduct.skus.forEach((singleSku) => {
    if (typeof singleSku.variant[0] !== "undefined") {
      AttributeName.value.add(singleSku.variant[0].Attribute.name);
    }
  });
}

function getSubOptionDataBasedOnSelection(skuCode) {
  isOptionSelected.value = {
    ...isOptionSelected.value,
    code: null,
    subOptionID: null,
    subOptionName: null,
  };
  isOptionSelected.value.code = skuCode;
  productStore.quantity = 1;
  let productSubOptions = productStore.singleProduct.skus.find((p) => {
    if (p.code == skuCode) {
      if (typeof p.variant[0] !== "undefined") {
        if (p.variant[0].subOptions.length > 0) {
          subOptionsDataBasedOnSelection.value = p.variant[0].subOptions;
        } else {
          subOptionsDataBasedOnSelection.value = null;
        }
      }
    }
  });
}

const getPriceBasedOnSelectedSubOption = computed(() => {
  if (
    subOptionsDataBasedOnSelection.value !== null &&
    subOptionsDataBasedOnSelection.value.length > 0
  ) {
    let selectedSubOption = subOptionsDataBasedOnSelection.value.find(
      (s) => s.id == isOptionSelected.value.subOptionID
    );
    return selectedSubOption;
  } else if (isOptionSelected.value.code !== null) {
    // getting the price and stock of a sku code that has no subOptions
    // i am getting the sku code from the "isOptionsSelected" => because every variant i choose it will alaways has a sku code value inside the isOptionsSelected. (i am garanted that im getting a sku code , because i select it).
    let selectedVariant = productStore.singleProduct.skus.find(
      (skuCode) => skuCode.code == isOptionSelected?.value?.code
    );
    return selectedVariant;
  } else {
    console.log(
      typeof productStore?.singleProduct?.skus !== "undefined"
        ? "" //productStore?.singleProduct?.skus[0]
        : ""
    );
  }
});

const assignSubOptionID = (subOptionID, subOptionName) => (
  (isOptionSelected.value.subOptionID = subOptionID),
  (isOptionSelected.value.subOptionName = subOptionName),
  (productStore.quantity = 1)
);

function addToCart(code = null) {
  // updaing object values using The spread operator allows us to make an object as an iteretable element by using ...'name of the object'
  if (authStore.authUser != null) {
    itemData.value = {
      ...itemData.value,
      productID: productStore.singleProduct.id,
      skuCode: code,
      subOptionID: isOptionSelected.value.subOptionID,
    };

    // console.log(itemData);
    productStore.AddToCart(itemData, code);
  } else {
    router.push({ name: "Login" });
  }
}

const isIncrementDisabled = () => {
  // productStore?.singleProduct?.skus?.forEach((element) => {
  //   if (element.sku?.variant[0] && element?.sku?.variant[0]?.subOptions[0]) {
  //     if (quantity.value >= element?.sku?.variant[0]?.subOptions[0]?.stock) {
  //       return "disabled";
  //     }
  //     // console.log(cartItems.sku.variant[0].subOptions[0]);
  //   } else {
  //     if (quantity.value >= element?.sku?.stock) {
  //       return "disabled";
  //     }
  //   }
  // });
};

const isDecrementDisabled = () => {
  // productStore?.singleProduct?.skus?.forEach((element) => {
  //   if (element.sku?.variant[0] && element?.sku?.variant[0]?.subOptions[0]) {
  //     if (quantity.value == 1) {
  //       return "disabled";
  //     }
  //     // console.log(cartItems.sku.variant[0].subOptions[0]);
  //   } else {
  //     if (quantity.value == 1) {
  //       return "disabled";
  //     }
  //   }
  // });
};

function isFavorited(favoriteStatus) {
  if (favoriteStatus) {
    return {
      class:
        "transition-all duration-500 fill-red-500 group-hover:fill-white size-6",
      stroke: "red",
    };
  } else {
    return {
      class: "transition-all duration-500 group-hover:fill-red-500 size-6",
      stroke: "red",
    };
  }
}
function favorite() {
  if (authStore.user != null) {
    productStore.favoriteProduct();
  } else {
    router.push({ name: "Login" });
  }
}

function updateQuantityByIncrement() {
  productStore.updateQuantityByIncrement(isOptionSelected);
}

function updateQuantityByDecrement() {
  productStore.updateQuantityByDecrement(isOptionSelected);
}

function updateQuantityByDencrement() {}

onMounted(async () => {
  await productStore.getSingleProduct(propData.slug);
  pushAllAttributeNameToSeperateArray();
  initFlowbite();
});
</script>








 <style scoped>
swiper-container {
  width: 100%;
  height: 100%;
}

swiper-slide {
  text-align: center;
  font-size: 18px;
  background: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
}

swiper-slide img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: contain;
}

swiper-container {
  width: 100%;
  height: 300px;
  margin-left: auto;
  margin-right: auto;
}

swiper-slide {
  background-size: cover;
  background-position: center;
}

.mySwiper {
  height: 80%;
  width: 100%;
}

.mySwiper2 {
  height: 20%;
  box-sizing: border-box;
  padding: 10px 0;
}

.mySwiper2 swiper-slide {
  width: 25%;
  height: 100%;
  opacity: 0.4;
}

.mySwiper2 .swiper-slide-thumb-active {
  opacity: 1;
}
.swiper-images {
  height: 100%;
  object-fit: cover;
}

.nav-for-slider .swiper-slide {
  height: auto;
  width: auto;
  cursor: pointer;
}
.swiper-wrapper {
  height: auto;
}
.nav-for-slider .swiper-slide img {
  border: 2px solid transparent;
  border-radius: 10px;
}
.nav-for-slider .swiper-slide-thumb-active img {
  border-color: rgb(79 70 229);
}
</style>
