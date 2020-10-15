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

      <v-list-item-content
        class="l-sidebar__item--content"
      >
        <v-list-item-title
          class="l-sidebar__item--left"
        >
          {{ schedule.title }}
        </v-list-item-title>
        <v-list-item-subtitle
          class="l-sidebar__item--right"
        >
          {{ schedule.count }}件
        </v-list-item-subtitle>
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
        { title: "今　日", icon: "mdi-weather-sunny", count: 1 },
        { title: "明　日", icon: "mdi-moon-waning-crescent", count: 2 },
        { title: "近日中", icon: "mdi-timer", count: 3 },
        { title: "いつか", icon: "mdi-calendar-arrow-right", count: 100 },
      ],
    }
  },
}
</script>
