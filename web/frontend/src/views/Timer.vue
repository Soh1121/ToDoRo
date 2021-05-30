<template>
  <div style="height: 100%;" class="u-position__relative">
    <BackButton />
    <div
      class="u-position__absolute u-size__width--100per u-size__height--100per u-position__top--0"
    >
      <TimerControl :task="task" />
    </div>
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
