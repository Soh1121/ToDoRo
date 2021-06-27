import Vue from "vue";
import Vuex from "vuex";
import auth from "./auth";
import context from "./context";
import error from "./error";
import load from "./load";
import pomodoro from "./pomodoro";
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
    load,
    pomodoro,
    priority,
    project,
    repeat,
    task
  }
});
