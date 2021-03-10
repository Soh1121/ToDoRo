<template>
  <TimerControl :task="task" />
</template>

<script>
import TimerControl from "../components/timer/TimerControl.vue";

export default {
  components: {
    TimerControl
  },

  props: {
    task: {
      type: Object
    }
  }
};
</script>
