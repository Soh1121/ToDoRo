<template>
  <v-progress-circular
    :rotate="-90"
    :size="400"
    :width="10"
    :value="timerCircular"
    color="primary"
  >
    <span class="u-text__font-size--4em">{{ minutes }}：{{ seconds }}</span>
  </v-progress-circular>
</template>

<script>
export default {
  props: {
    timer: {
      type: Number
    },
    isStarted: {
      type: Boolean
    },
    started: {
      type: Boolean
    }
  },

  data() {
    return {
      time: this.timer,
      fulltime: 1500,
      interval: {},
      timerId: null
    };
  },

  computed: {
    timerCircular: function() {
      return ((this.fulltime - this.time) * 100) / this.fulltime;
    },

    minutes: function() {
      return ("00" + Math.trunc(this.time / 60)).slice(-2);
    },

    seconds: function() {
      return ("00" + (this.time % 60)).slice(-2);
    }
  },

  watch: {
    isStarted: function() {
      if (this.isStarted) {
        this.timerId = setInterval(() => {
          if (this.time === 0) {
            this.isStarted = false;
            this.$emit("isStarted", false);
            return null;
          }
          this.time -= 1;
        }, 1000);
      } else {
        clearInterval(this.timerId);
      }
    },

    started: function() {
      if (!this.isStarted && !this.started) {
        this.time = this.fulltime;
      }
    }
  }
};
</script>
