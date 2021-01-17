import Vue from "vue";
import Vuex from "vuex";
import auth from "./auth";
import context from "./context";
import error from "./error";
import project from "./project";
import repeat from "./repeat";

Vue.use(Vuex);
Vue.config.devtools = true;

export default new Vuex.Store({
  modules: {
    auth,
    context,
    error,
    project,
    repeat
  }
});
