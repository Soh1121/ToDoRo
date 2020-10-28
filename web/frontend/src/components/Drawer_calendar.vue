<template>
  <v-list dense width="100%">
    <v-divider />

    <List
      v-for="schedule in schedules"
      v-bind:key="schedule.id"
      v-bind:icon="schedule.icon"
      v-bind:title="schedule.title"
      v-bind:count="schedule.count"
    />
  </v-list>
</template>

<script>
import List from "./Drawer_list.vue";

export default {
  components: {
    List
  },
  data() {
    return {
      drawer: true,
      schedules: [
        { id: 1, title: "今　日", icon: "mdi-weather-sunny", count: 1 },
        { id: 2, title: "明　日", icon: "mdi-moon-waning-crescent", count: 2 },
        { id: 3, title: "近日中", icon: "mdi-timer", count: 3 },
        { id: 4, title: "いつか", icon: "mdi-calendar-arrow-right", count: 100 }
      ]
    };
  }
};
</script>
