import Vue from "vue";
import Vuex from "vuex";
import auth from "./auth";
import context from "./context";
import error from "./error";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    auth,
    context,
    error
  }
});
