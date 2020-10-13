<template>
  <v-card>
    <v-list
      dense
      width="100%"
    >
      <v-list-group
        :value="true"
        prepend-icon="mdi-clock-time-eight"
      >
        <template v-slot:activator>
          <v-list-item-title>Context</v-list-item-title>
        </template>
      </v-list-group>
      <v-list-group
        prepend-icon="mdi-group"
      >
        <template v-slot:activator>
          <v-list-item-title>Project</v-list-item-title>
        </template>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
    </v-list>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      drawer: true,
      items: [
        { title: "context", icon: '' },
        { title: "project", icon: '' },
      ],
    }
  },
}
</script>
