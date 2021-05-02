import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import Setting from "../views/Setting.vue";
import Timer from "../views/Timer.vue";
import SystemError from "../views/System.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home
  },
  {
    path: "/timer",
    name: "Timer",
    component: Timer,
    props: true
  },
  {
    path: "/setting",
    name: "Setting",
    component: Setting
  },
  {
    path: "/500",
    component: SystemError
  }
];

const router = new VueRouter({
  mode: "history",
  routes
});

export default router;
