<template>
  <v-list-item-content class="hidden-md-and-down text-truncate">
    <v-list-subtitle>
      <v-icon>mdi-repeat</v-icon>
      {{ task.repeat }}
    </v-list-subtitle>
    <v-list-subtitle>
      <v-icon>mdi-chevron-triple-up</v-icon>
      {{ task.priority }}
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
