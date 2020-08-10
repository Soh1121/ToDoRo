import "./bootstrap";
import Vue from "vue";
import App from "./App.vue";
import router from "./router/router";
import store from "./store/store";
import vuetify from "./plugins/vuetify";
import "@mdi/font/css/materialdesignicons.css";
require("@/assets/sass/app.scss");

Vue.config.productionTip = false;
Vue.config.devtools = true;

const createApp = async () => {
  await store.dispatch("auth/currentUser");

  new Vue({
    router,
    store,
    vuetify,
    render: h => h(App)
  }).$mount("#app");
};

createApp();
