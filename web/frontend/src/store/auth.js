import {
  OK,
  CREATED,
  INTERNAL_SERVER_ERROR,
  UNPROCESSABLE_ENTITY
} from "../util";

const state = {
  user: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null,
  display: false
};

const getters = {
  check: state => !!state.user,
  username: state => (state.user ? state.user.name : ""),
  display: state => !!state.display
};

const mutations = {
  setUser(state, user) {
    state.user = user;
  },
  setApiStatus(state, status) {
    state.apiStatus = status;
  },
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages;
  },
  setRegisterErrorMessages(state, messages) {
    state.registerErrorMessages = messages;
  },
  reverseDisplay(state, property) {
    state.display = property;
  }
};

const actions = {
  async register(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.post("/api/register", data);

    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setUser", response.data);
      context.commit("reverseDisplay", false);
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setRegisterErrorMessages", response.data.errors);
    } else {
      if (response.status === INTERNAL_SERVER_ERROR) {
        context.commit("reverseDisplay", false);
      }
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async login(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.post("/api/login", data);

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setUser", response.data);
      context.commit("reverseDisplay", false);
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setLoginErrorMessages", response.data.errors);
    } else {
      if (response.status === INTERNAL_SERVER_ERROR) {
        context.commit("reverseDisplay", false);
      }
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async logout(context) {
    context.commit("setApiStatus", null);
    const response = await window.axios.post("/api/logout");

    if (response.status === OK) {
      context.commit("setUser", null);
      context.commit("reverseDisplay", false);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  async currentUser(context) {
    context.commit("setApiStatus", null);
    const response = await window.axios.get("/api/user");
    const user = response.data || null;

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setUser", user);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  open(context) {
    context.commit("reverseDisplay", true);
  },

  close(context) {
    context.commit("reverseDisplay", false);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
