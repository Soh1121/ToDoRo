import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../util";

const state = {
  tasks: null,
  taskControlForm: null,
  apiStatus: null,
  taskAddErrorMessages: null,
  isPersistedItem: false,
  display: false
};

const getters = {
  tasks: state => state.tasks,
  taskControlForm: state => state.taskControlForm,
  isPersistedItem: state => !!state.isPersistedItem,
  display: state => !!state.display
};

const mutations = {
  setTasks(state, tasks) {
    state.tasks = tasks;
  },

  setTaskControlForm(state, task) {
    state.taskControlForm = task;
  },

  setApiStatus(state, status) {
    state.apiStatus = status;
  },

  setAddTaskErrorMessages(state, messages) {
    state.taskAddErrorMessages = messages;
  },

  setIsPersistedItem(state, status) {
    state.isPersistedItem = status;
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

  async update(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.patch("/api/tasks/" + data[0], data[1]);

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      context.commit("setTaskControlForm", {});
      return false;
    }

    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit("setAddTaskErrorMessages", response.data.errors);
    } else {
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  async remove(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.delete(
      "/api/tasks/" + data[0],
      data[1]
    );

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  async index(context, data) {
    context.commit("setApiStatus", null);
    const response = await window.axios.get("/api/tasks/" + data[0]);

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setTasks", response.data);
      context.commit("setTaskControlForm", {});
      return false;
    }

    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },

  open(context, item) {
    context.commit("setTaskControlForm", item);
    context.commit("setAddTaskErrorMessages", null);
    if (Object.keys(item).length) {
      context.commit("setIsPersistedItem", true);
    } else {
      context.commit("setIsPersistedItem", false);
    }
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
