import { CREATED, UNPROCESSABLE_ENTITY } from "../util";

const state = {
  tasks: null,
  apiStatus: null,
  taskAddErrorMessages: null,
  display: false
};

const getters = {
  display: state => !!state.display
};

const mutations = {
  setTasks(state, tasks) {
    state.tasks = tasks;
  },

  setApiStatus(state, status) {
    state.apiStatus = status;
  },

  setAddTaskErrorMessages(state, messages) {
    state.taskAddErrorMessages = messages;
  },

  setDisplay(state, status) {
    state.display = status;
  }
};

const actions = {
  async create(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.post("/api/tasks/" + data[0], data[1]);

    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setAddTaskErrorMessages", response.data.errors);
    } else {
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  open(context) {
    context.commit("setAddTaskErrorMessages", null);
    context.commit("setDisplay", true);
  },

  close(context) {
    context.commit("setDisplay", false);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
