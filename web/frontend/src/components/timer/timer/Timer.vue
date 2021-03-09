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
    }
  },

  data() {
    return {
      fulltime: 1500,
      interval: {}
    };
  },

  computed: {
    timerCircular: function() {
      return ((this.fulltime - this.timer) * 100) / this.fulltime;
    },

    minutes: function() {
      return ("00" + Math.trunc(this.timer / 60)).slice(-2);
    },

    seconds: function() {
      return ("00" + (this.timer % 60)).slice(-2);
    }
  },

  watch: {
    isStarted: function() {
      setInterval(() => {
        if (!this.isStarted) {
          return null;
        }
        if (this.timer === 0) {
          this.isStarted = false;
          this.$emit("isStarted", false);
          return null;
        }
        this.timer -= 1;
      },
      1000);
    }
  }
};
</script>
