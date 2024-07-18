import { createRouter  , createWebHistory} from "vue-router";
import ProductPage from './views/ProductView.vue';
import SingleProduct from './views/SingleProduct.vue';
import LoginPage from './views/LoginPage.vue'
import RegisterPage from './views/RegisterPage.vue'
import RequestPassword from './views/RequestResetPassword.vue'
import ResetPassword from './views/ResetPassword.vue';
import CheckoutPage from './views/CheckoutPage.vue';
import SuccessPage from './views/SuccessPage.vue';  
import PaymentPage from './views/PaymentPage.vue'
import Page404 from './views/Page404.vue'
import OrdersPage from './views/OrdersPage.vue'
import { useAuthStore } from './stores/auth.js';
const router = createRouter({
    history: createWebHistory(),
    routes:[
        {path:'/products' , name: 'Products', component: ProductPage},
        {path:'/product/:slug' , name: 'SingleProduct', component: SingleProduct, props:true},
        { path: '/login', name: "Login", component: LoginPage },
        { path: '/register', name: "Register", component: RegisterPage },
        { path: '/request-password', name: "RequestPassword", component: RequestPassword },
        { path: '/reset-password/:token', name: "ResetPassword", component: ResetPassword  , props:true},
        { path: '/checkout' , name:'Checkout' , component:CheckoutPage},
        { path: '/payment' , name:'Payment' , component:PaymentPage},
        { path: '/success' , name:'Success' , component:SuccessPage},
        { path: '/404' , name:'404-PAGE' , component:Page404},
        { path: '/Orders' , name:'Orders' , component:OrdersPage},
    ]
})






export default router