<template>
  <v-navigation-drawer
    v-model="drawer"
    :clipped="$vuetify.breakpoint.lgAndUp"
    app
    width="300px"
    @input="handleInput"
  >
    <v-card height="100%" tile class="l-sidebar">
      <Group />
      <Calendar class="l-sidebar__inner--bottom" />
    </v-card>
  </v-navigation-drawer>
</template>

<script>
import Group from "./Drawer_group.vue";
import Calendar from "./Drawer_calendar.vue";

export default {
  components: {
    Group,
    Calendar
  },

  props: ["drawer"],

  methods: {
    handleInput(e) {
      this.$emit("drawerOpenAndClose", e);
    }
  }
};
</script>
