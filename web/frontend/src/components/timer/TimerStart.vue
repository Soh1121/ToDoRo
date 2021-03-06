<template>
  <div class="u-position__flexbox u-position__flexbox--center u-position__flexbox--column">
    <Timer />
    <StartButton />
  </div>
</template>

<script>
import Timer from "./timer/Timer.vue";
import StartButton from "./button/StartButton.vue";

export default {
  components: {
    Timer,
    StartButton
  }
}
</script>
