import {
  OK,
  CREATED,
  INTERNAL_SERVER_ERROR,
  UNPROCESSABLE_ENTITY
} from "../util";

const state = {
  contexts: null,
  apiStatus: null,
  display: false
};

const getters = {
  contexts: state => state.contexts,
  display: state => !!state.display
};

const mutations = {
  setContexts(state, contexts) {
    state.contexts = contexts;
  },

  setApiStatus(state, status) {
    state.apiStatus = status;
  },

  setStoreErrorMessages(state, messages) {
    state.stateErrorMessages = messages;
  },

  reverseDisplay(state, property) {
    state.display = property;
  }
};

const actions = {
  async store(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.post(
      "/api/contexts/" + data[0],
      data[1]
    );

    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setContexts", response.data);
      context.commit("reverseDisplay", false);
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setStoreErrorMessages", response.data.errors);
    } else {
      if (response.status === INTERNAL_SERVER_ERROR) {
        context.commit("reverseDisplay", false);
      }
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async index(context, data) {
    const route = "/api/contexts/" + data[0];
    const response = await window.axios.get(route);

    if (response.status !== OK) {
      context.commit("error/setCode", response.status, { root: true });
      return false;
    }

    context.commit("setApiStatus", true);
    context.commit("setContexts", response.data);
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
