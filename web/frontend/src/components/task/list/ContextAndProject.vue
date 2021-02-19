<template>
  <v-list-item-content class="hidden-sm-and-down text-truncate">
    <v-list-subtitle>
      <v-icon>mdi-clock-time-eight</v-icon>
      {{ task.context }}
    </v-list-subtitle>
    <v-list-subtitle>
      <v-icon>mdi-folder</v-icon>
      {{ task.project }}
    </v-list-subtitle>
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
