const state = {
  FULLTIME: 1500,
  mode: "concentration",
  playMode: "stop",
  time: 0,
  timerId: null
};

const getters = {
  playMode: state => state.playMode,

  minutes: function(state) {
    return ("00" + Math.trunc(state.time / 60)).slice(-2);
  },

  seconds: function(state) {
    return ("00" + (state.time % 60)).slice(-2);
  },

  timerCircular: function(state) {
    return ((state.FULLTIME - state.time) * 100) / state.FULLTIME;
  }
};

const mutations = {
  setTime(state, time) {
    state.time = time;
  },

  setPlayMode(state, mode) {
    state.playMode = mode;
  },

  setTimerId(state, timerId) {
    // state.timerId = setInterval(() => {
    //   if (state.time === 0) {
    //     state.playMode = "stop";
    //     return null;
    //   }
    //   state.time -= 1;
    // }, 1000);
    state.timerId = timerId;
  },

  decrementTime(state) {
    state.time -= 1;
  }
};

const actions = {
  setStateTime(context, time) {
    context.commit("setTime", time);
  },

  start(context) {
    context.commit("setPlayMode", "play");
    const timerId = setInterval(() => {
      if (state.time === 0) {
        context.commit("setPlayMode", "stop");
        return null;
      }
      context.commit("decrementTime");
    }, 1000);
    context.commit("setTimerId", timerId);
  },

  pause(context) {
    context.commit("setPlayMode", "pause");
    clearInterval(state.timerId);
  },

  continueTimer(context) {
    context.commit("setPlayMode", "play");
    context.commit("setTimerId");
  },

  reset(context) {
    context.commit("setPlayMode", "stop");
    context.commit("setTime", state.FULLTIME);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
