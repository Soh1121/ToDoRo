<template>
  <v-list-item-content class="text-truncate">
    <v-list-item-title>
      {{ task.name }}
    </v-list-item-title>
    <v-list-item-subtitle>
      <v-icon>mdi-av-timer</v-icon>
      {{ task.done }} / {{ task.term }}
    </v-list-item-subtitle>
  </v-list-item-content>
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
