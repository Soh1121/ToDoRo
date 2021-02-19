<template>
  <v-list-item-action>
    <v-checkbox v-model="task.done"></v-checkbox>
    <v-icon>mdi-play-circle-outline</v-icon>
  </v-list-item-action>
</template>

<script>
export default {
  props: {
    task: {
      type: Object
    }
  }
};
</script>
