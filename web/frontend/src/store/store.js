import Vue from "vue";
import Vuex from "vuex";
import auth from "./auth";
import context from "./context";
import error from "./error";
import priority from "./priority";
import project from "./project";
import repeat from "./repeat";
import task from "./task";

Vue.use(Vuex);
Vue.config.devtools = true;

export default new Vuex.Store({
  modules: {
    auth,
    context,
    error,
    priority,
    project,
    repeat,
    task
  }
});
