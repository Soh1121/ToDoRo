<template>
  <TimerStart :task="task" />
</template>

<script>
import TimerStart from "../components/timer/TimerStart.vue";

export default {
  components: {
    TimerStart
  },

  props: {
    task: {
      type: Object
    }
  }
};
</script>
