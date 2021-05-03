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
  async function loadData() {
    // プロジェクト・コンテキスト・タスクを取得する
    async function fetch(target, user_id) {
      await store.dispatch(target + "/index", [user_id]);
    }

    // 繰り返し・優先度を取得する
    async function fetchDefaultData(target) {
      await store.dispatch(target + "/index");
    }

    await store.dispatch("auth/currentUser");
    const user_id = store.getters["auth/user_id"];
    if (user_id) {
      const functions = [
        fetch("task", user_id),
        fetch("context", user_id),
        fetch("project", user_id),
        fetchDefaultData("repeat"),
        fetchDefaultData("priority")
      ];
      await Promise.all(functions);
      // Promise.all(functions);
    }
  }

  new Vue({
    router,
    store,
    vuetify,
    render: h => h(App)
  }).$mount("#app");

  // ロード画面の表示
  store.dispatch("load/changeLoading", true);
  await loadData();
  // ロード画面の非表示
  store.dispatch("load/changeLoading", false);
};

createApp();
