<template>
  <div
    class="u-position__flexbox u-position__flexbox--center u-position__flexbox--column"
  >
    <Timer />
    <PauseButton v-if="playMode === 'play'" :task="task" />
    <div class="u-position__flexbox" v-if="playMode === 'pause'">
      <ContinueButton :task="task" />
      <StopButton :task="task" />
    </div>
    <StartButton v-if="playMode === 'stop'" :task="task" />
  </div>
</template>

<script>
import Timer from "./timer/Timer.vue";
import StartButton from "./button/StartButton.vue";
import PauseButton from "./button/PauseButton.vue";
import ContinueButton from "./button/ContinueButton.vue";
import StopButton from "./button/StopButton.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    Timer,
    StartButton,
    PauseButton,
    ContinueButton,
    StopButton
  },

  props: {
    task: {
      type: Object
    }
  },

  data() {
    return {};
  },

  computed: {
    ...mapGetters({
      playMode: "pomodoro/playMode"
    })
  }
};
</script>
