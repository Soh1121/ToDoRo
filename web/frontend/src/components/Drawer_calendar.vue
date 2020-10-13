<template>
  <v-list
    dense
    width="100%"
    class="l-sidebar__inner--bottom"
  >
    <v-divider />

    <v-list-item
      v-for="schedule in schedules"
      :key="schedule.title"
      link
    >
      <v-list-item-icon>
        <v-icon>{{ schedule.icon }}</v-icon>
      </v-list-item-icon>

      <v-list-item-content>
        <v-list-item-title>{{ schedule.title }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  data() {
    return {
      drawer: true,
      schedules: [
        { title: "今　日", icon: "mdi-weather-sunny" },
        { title: "明　日", icon: "mdi-moon-waning-crescent" },
        { title: "近日中", icon: "mdi-timer" },
        { title: "いつか", icon: "mdi-calendar-arrow-right" },
      ],
    }
  },
}
</script>
