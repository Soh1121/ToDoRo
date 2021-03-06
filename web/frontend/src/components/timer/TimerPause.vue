<template>
  <div class="u-position__flexbox u-position__flexbox--center u-position__flexbox--column">
    <Timer />
    <PauseButton />
  </div>
</template>

<script>
import Timer from "./timer/Timer.vue";
import PauseButton from "./button/PauseButton.vue";

export default {
  components: {
    Timer,
    PauseButton,
  }
}
</script>
