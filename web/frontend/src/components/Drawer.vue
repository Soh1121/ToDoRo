<template>
  <v-navigation-drawer
    v-model="drawer"
    :clipped="$vuetify.breakpoint.lgAndUp"
    app
  >
    <v-card
      height="100%"
      tile
      class="l-sidebar"
    >
      <Menu />
      <Calendar class="l-sidebar__inner--bottom"/>
    </v-card>
  </v-navigation-drawer>
</template>

<script>
import Menu from "./Drawer_menu.vue";
import Calendar from "./Drawer_calendar.vue";

export default {
  components: {
    Menu,
    Calendar,
  }
}
</script>
