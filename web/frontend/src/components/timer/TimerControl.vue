<template>
  <div
    class="u-position__flexbox u-position__flexbox--center u-position__flexbox--column"
  >
    <Timer :isStarted="isStarted" :started="started" />
    <PauseButton v-if="playMode === 'play'" />
    <!-- <div class="u-position__flexbox" v-else-if="!isStarted && started">
      <ContinueButton @timerContinue="timerContinue" />
      <StopButton @reset="reset" />
    </div> -->
    <StartButton v-if="playMode === 'stop'" />
  </div>
</template>

<script>
import Timer from "./timer/Timer.vue";
import StartButton from "./button/StartButton.vue";
import PauseButton from "./button/PauseButton.vue";
// import ContinueButton from "./button/ContinueButton.vue";
// import StopButton from "./button/StopButton.vue";
import { mapGetters } from 'vuex';

export default {
  components: {
    Timer,
    StartButton,
    PauseButton,
    // ContinueButton,
    // StopButton
  },

  props: {
    task: {
      type: Object
    }
  },

  data() {
    return {
      // isStarted: false,
      // started: false
    };
  },

  computed: {
    ...mapGetters({
      playMode: "pomodoro/playMode"
    })
  },

  // methods: {
  //   pause() {
  //     this.isStarted = false;
  //   },

  //   timerContinue() {
  //     this.isStarted = true;
  //   },

  //   reset() {
  //     this.started = false;
  //   }
  // }
};
</script>
