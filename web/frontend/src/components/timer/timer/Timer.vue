<template>
  <v-progress-circular
    :rotate="-90"
    :size="400"
    :width="10"
    :value="value"
    color="primary"
  >
    <span class="u-text__font-size--4em">{{ value }}</span>
  </v-progress-circular>
</template>

<script>
export default {
  data() {
    return {
      value: 80
    }
  }
}
</script>
