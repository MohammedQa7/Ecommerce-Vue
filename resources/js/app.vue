<template>
    <div class="navbar" v-if="navShow" >    
        <navbar> </navbar>
    </div>

    <div class="main h-screen" :class="appendMargin">
        <router-view></router-view>
    </div>
</template>

<script setup>
import {computed} from 'vue'
import navbar from './components/NavbarComponent.vue'
import { useRoute } from 'vue-router';
const route = useRoute();
const navShow = computed(()=>{
     return route.name !== 'Checkout' && route.name !=='Login' && route.name !=='Register' && route.name !=='Success' && route.name !=='404-PAGE' && route.name !=='Payment'
});
const appendMargin = computed (()=>{
    return route.name !== 'Checkout' && route.name !=='Login' && route.name !=='Register' && route.name !=='Payment' ?  'mt-5 pt-5': '' ;
});
</script>