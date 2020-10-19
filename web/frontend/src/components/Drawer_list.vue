<template>
  <v-list-item
    link
  >
    <v-list-item-icon>
      <v-icon>{{ icon }}</v-icon>
    </v-list-item-icon>

    <v-list-item-content
      class="l-sidebar__item--content"
    >
      <v-list-item-title
        class="l-sidebar__item--left"
      >
        {{ title }}
      </v-list-item-title>
      <v-list-item-subtitle
        class="l-sidebar__item--right"
      >
        {{ count }}件
      </v-list-item-subtitle>
    </v-list-item-content>
  </v-list-item>
</template>

<script>
export default {
  props: ["icon", "title", "count"],
  data() {
  },
}
</script>
