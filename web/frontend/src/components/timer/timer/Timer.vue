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
import { mapGetters } from 'vuex';
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
    ...mapGetters({
      minutes: "pomodoro/minutes",
      seconds: "pomodoro/seconds",
      timerCircular: "pomodoro/timerCircular"
    })
  },

  methods: {
    timerReset: function() {
      console.log(this.mode);
      if (this.mode === "concentration") {
        this.time = this.fulltime;
      } else if (this.mode === "break") {
        this.count += 1;
        if (this.count % 4 === 0) {
          this.time = 15;
        } else {
          this.time = 5;
        }
      }
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
        // this.time = this.fulltime;
        this.timerReset();
      }
    }
  }
};
</script>
