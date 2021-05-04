<template>
  <div style="height: 100%;" class="u-position__relative">
    <BackButton />
    <TimerControl :task="task" />
  </div>
</template>

<script>
import BackButton from "../components/timer/BackButton.vue";
import TimerControl from "../components/timer/TimerControle.vue";

export default {
  components: {
    BackButton,
    TimerControl
  },

  props: {
    task: {
      type: Object
    }
  },

  // タスクがセットされていなければトップへ遷移
  created() {
    if (this.task === undefined) {
      this.$router.push({ path: "/" });
    }
  }
};
</script>
