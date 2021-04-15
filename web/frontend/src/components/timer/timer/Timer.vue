<template>
  <v-progress-circular
    :rotate="-90"
    :size="400"
    :width="10"
    :value="timerCircular"
    :color="color"
  >
    <span class="u-text__font-size--4em">{{ minutes }}：{{ seconds }}</span>
  </v-progress-circular>
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
    })
  }
};
</script>
