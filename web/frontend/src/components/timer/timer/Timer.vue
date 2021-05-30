<template>
  <div>
    <v-progress-circular
      :rotate="-90"
      :size="size"
      :width="10"
      :value="timerCircular"
      :color="color"
    >
      <span :class="fontSizeClass">{{ minutes }}：{{ seconds }}</span>
    </v-progress-circular>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      minutes: "pomodoro/minutes",
      seconds: "pomodoro/seconds",
      timerCircular: "pomodoro/timerCircular",
      color: "pomodoro/color"
    }),

    size: function() {
      if (this.windowSize < 600) {
        return "300";
      } else {
        return "400";
      }
    },

    fontSizeClass: function() {
      if (this.windowSize < 600) {
        return "u-text__font-size--35em";
      } else {
        return "u-text__font-size--40em";
      }
    }
  },

  data() {
    return {
      windowSize: 0
    };
  },

  created() {
    this.windowSize = window.innerWidth;
  }
};
</script>
