<template>
  <div
    class="u-position__flexbox u-position__flexbox--center u-position__flexbox--column"
  >
    <Timer :timer="task.timer" :isStarted="isStarted" />
    <PauseButton v-if="isStarted" />
    <StartButton v-else @start="start" />
  </div>
</template>

<script>
import Timer from "./timer/Timer.vue";
import StartButton from "./button/StartButton.vue";
import PauseButton from "./button/PauseButton.vue";

export default {
  components: {
    Timer,
    StartButton,
    PauseButton
  },

  props: {
    task: {
      type: Object
    }
  },

  data() {
    return {
      isStarted: false
    };
  },

  methods: {
    start(e) {
      this.isStarted = e;
    }
  }
};
</script>
