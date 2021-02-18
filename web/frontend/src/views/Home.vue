<template>
  <v-list
    two-line
  >
    <template
      v-for="(task, index) in tasks"
    >
    <v-divider :key="`div-${index}`"></v-divider>
    <v-list-item
      :key="task.id"
    >
      <v-list-item-action>
        <v-checkbox v-model="task.done"></v-checkbox>
        <v-icon>mdi-play-circle-outline</v-icon>
      </v-list-item-action>
      <v-list-item-content
        class="text-truncate"
      >
        <v-list-item-title>
          {{ task.name }}
        </v-list-item-title>
        <v-list-item-subtitle>
          <v-icon>mdi-av-timer</v-icon>
          {{ task.finished }} / {{ task.term }}
        </v-list-item-subtitle>
      </v-list-item-content>
      <v-list-item-content
        class="hidden-sm-and-down text-truncate"
      >
        <v-list-subtitle>
          <v-icon>mdi-clock-time-eight</v-icon>
          {{ task.context }}
        </v-list-subtitle>
        <v-list-subtitle>
          <v-icon>mdi-folder</v-icon>
          {{ task.project }}
        </v-list-subtitle>
      </v-list-item-content>
      <v-list-item-content
        class="hidden-sm-and-down"
      >
        <v-list-subtitle>
          <v-icon>mdi-calendar-arrow-right</v-icon>
          {{ task.start_date }}
        </v-list-subtitle>
        <v-list-subtitle>
          <v-icon>mdi-calendar-arrow-left</v-icon>
          {{ task.due_date }}
        </v-list-subtitle>
      </v-list-item-content>
      <v-list-item-content
        class="hidden-md-and-down text-truncate"
      >
        <v-list-subtitle>
          <v-icon>mdi-repeat</v-icon>
          {{ task.repeat }}
        </v-list-subtitle>
        <v-list-subtitle>
          <v-icon>mdi-chevron-triple-up</v-icon>
          {{ task.priority }}
        </v-list-subtitle>
      </v-list-item-content>
      <v-list-item-action>
        <v-icon>mdi-pencil</v-icon>
        <v-icon>mdi-delete</v-icon>
      </v-list-item-action>
    </v-list-item>
    <v-divider
      v-if="tasks.length === index + 1"
      :key="`div-${index}`"
    ></v-divider>
    </template>
  </v-list>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      tasks: []
    }
  },

  computed: {
    ...mapGetters({
      userId: "auth/user_id",
      storeTasks: "task/tasks"
    })
  },

  methods: {
  },

  watch: {
    storeTasks(values) {
      if (values) {
        this.tasks = values["data"].map(
          function(item) {
            const start_date = item.start_date.split(" ");
            const due_date = item.due_date.split(" ");
            return {
              task_id: item.id,
              done: item.done,
              name: item.name,
              context: item.context,
              project: item.project,
              start_date: start_date[0],
              due_date: due_date[0],
              term: item.term,
              finished: item.finished,
              repeat: item.repeat,
              priority: item.priority
            };
          }
        )
      }
    }
  }
}
</script>
