<template>
  <div
    class="u-position__flexbox u-position__flexbox--center u-position__flexbox--column"
  >
    <Timer :timer="task.timer" :isStarted="isStarted" />
    <PauseButton v-if="isStarted" @pause="pause" />
    <div class="u-position__flexbox" v-else-if="!isStarted && Started">
      <ContinueButton />
      <StopButton />
    </div>
    <StartButton v-else @start="start" />
  </div>
</template>

<script>
import Timer from "./timer/Timer.vue";
import StartButton from "./button/StartButton.vue";
import PauseButton from "./button/PauseButton.vue";
import ContinueButton from "./button/ContinueButton.vue";
import StopButton from "./button/StopButton.vue";

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
    return {
      isStarted: false,
      Started: false
    };
  },

  methods: {
    start(e) {
      this.isStarted = e;
    },

    pause(e) {
      this.isStarted = e;
    }
  }
};
</script>
