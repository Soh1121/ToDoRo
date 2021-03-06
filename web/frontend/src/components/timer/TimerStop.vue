<template>
  <div class="u-position__flexbox u-position__flexbox--center u-position__flexbox--column">
    <Timer />
    <div class="u-position__flexbox">
      <ContinueButton />
      <StopButton />
    </div>
  </div>
</template>

<script>
import Timer from "./timer/Timer.vue";
import ContinueButton from "./button/ContinueButton.vue";
import StopButton from "./button/StopButton.vue";

export default {
  components: {
    Timer,
    ContinueButton,
    StopButton
  }
}
</script>
