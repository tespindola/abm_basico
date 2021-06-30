require('./bootstrap');
import Vue from 'vue';

// Librerias
import router from '@r/routes'; // Vue router para el manejo de rutas del cliente

import ConfigAxios from "@/server/config";
Vue.prototype.$axios = ConfigAxios; // Definimos la variable global $axios para poder utilizarla

// Archivo en el cual se renderizan los componentes de vue.
import Render from '@/Render';

new Vue({
    router,
    render: (h) => h(Render)
}).$mount('#app');
