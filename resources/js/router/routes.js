import Vue from 'vue';
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'principal',
        component: () => import('@v/Principal')
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;