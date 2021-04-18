<template>
  <div style="height: 100%;">
    <BackButton />
    <TimerControl :task="task" />
  </div>
</template>

<script>
import BackButton from "../components/timer/BackButton.vue";
import TimerControl from "../components/timer/TimerControl.vue";

export default {
  components: {
    BackButton,
    TimerControl
  },

  props: {
    task: {
      type: Object
    }
  }
};
</script>
