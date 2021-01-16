<template>
  <v-menu v-model="menu" offset-y :close-on-content-click="false">
    <template v-slot:activator="{ on }">
      <v-btn icon color="orange" dark elevation="0" v-on="on">
        <v-icon>mdi-calendar</v-icon>
      </v-btn>
    </template>
    <v-date-picker v-model="picker" @click="menu = false"/>
  </v-menu>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: new Date().toISOString().substr(0, 10)
    }
  },
  data() {
    return {
      menu: false
    };
  },
  computed: {
    picker: {
      get() {
        return this.value;
      },
      set(val) {
        this.menu = false;
        this.$emit("input", val);
      }
    }
  }
};
</script>
