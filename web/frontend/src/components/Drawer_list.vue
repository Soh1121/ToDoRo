<template>
  <v-list-item link @click="filter(id, category)">
    <v-list-item-icon>
      <v-icon>{{ icon }}</v-icon>
    </v-list-item-icon>

    <v-list-item-content class="l-sidebar__item--content">
      <v-list-item-title class="l-sidebar__item--left">
        {{ name }}
      </v-list-item-title>
      <v-list-item-subtitle v-if="id !== 0" class="l-sidebar__item--right">
        {{ maxfifty }}件<span v-if="isOver50">+</span>
      </v-list-item-subtitle>
    </v-list-item-content>
  </v-list-item>
</template>

<script>
export default {
  props: ["id", "icon", "name", "count", "category"],
  data() {
    return {
      menuIcon: "mdi-dots-vertical"
    };
  },

  computed: {
    isOver50: function() {
      return 50 < this.count;
    },
    maxfifty: function() {
      if (50 < this.count) {
        return 50;
      } else {
        return this.count;
      }
    }
  },

  methods: {
    filter: function(id, category) {
      if (category === "context") {
        this.$store.dispatch("task/inputCategoryId", id);
      }
    }
  }
};
</script>
