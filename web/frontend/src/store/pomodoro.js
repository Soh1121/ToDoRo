const state = {
  // FULLTIME: 1500,
  FULLTIME: 15,
  // SHORT_BREAK: 300,
  SHORT_BREAK: 5,
  // LONG_BREAK: 900,
  LONG_BREAK: 10,
  LONG_BREAK_COUNT: 4,
  pomodoroCount: 0,
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
    if (state.mode === "concentration") {
      return ((state.FULLTIME - state.time) * 100) / state.FULLTIME;
    } else if (state.mode === "break") {
      return ((state.SHORT_BREAK - state.time) * 100) / state.SHORT_BREAK;
    }
  },

  color: function(state) {
    if (state.mode === "concentration") {
      return "error";
    } else if (state.mode === "break") {
      return "primary";
    }
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
    state.timerId = timerId;
  },

  decrementTime(state) {
    state.time -= 1;
  },

  setMode(state, mode) {
    state.mode = mode;
  },

  incrementPomodoroCount(state) {
    state.pomodoroCount += 1;
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
        if (state.mode === "concentration") {
          context.commit("incrementPomodoroCount");
          if (state.pomodoroCount % state.LONG_BREAK_COUNT === 0) {
            context.commit("setTime", state.LONG_BREAK);
          } else {
            context.commit("setTime", state.SHORT_BREAK);
          }
          context.commit("setMode", "break");
        } else if (state.mode === "break") {
          context.commit("setTime", state.FULLTIME);
          context.commit("setMode", "concentration");
        }
        clearInterval(state.timerId);
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

  reset(context) {
    context.commit("setPlayMode", "stop");
    if (state.mode === "concentration") {
      context.commit("incrementPomodoroCount");
      context.commit("setTime", state.SHORT_BREAK);
      context.commit("setMode", "break");
    } else if (state.mode === "break") {
      context.commit("setTime", state.FULLTIME);
      context.commit("setMode", "concentration");
    }
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
