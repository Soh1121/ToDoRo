<template>
  <v-list two-line>
    <template v-for="(task, index) in tasks">
      <v-divider :key="`div-${index}`"></v-divider>
      <v-list-item :key="task.id">
        <CheckboxAndPlayButton :task="task" />
        <NameAndPomodoro :task="task" />
        <ContextAndProject :task="task" />
        <Date :task="task" />
        <RepeatAndPriority :task="task" />
        <EditButtonAndDeleteButton :task="task" />
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
import NameAndPomodoro from "../components/task/list/NameAndPomodoro.vue";
import CheckboxAndPlayButton from "../components/task/list/CheckboxAndPlayButton.vue";
import ContextAndProject from "../components/task/list/ContextAndProject.vue";
import Date from "../components/task/list/Date.vue";
import RepeatAndPriority from "../components/task/list/RepeatAndPriority.vue";
import EditButtonAndDeleteButton from "../components/task/list/EditButtonAndDeleteButton.vue";

export default {
  components: {
    CheckboxAndPlayButton,
    NameAndPomodoro,
    ContextAndProject,
    Date,
    RepeatAndPriority,
    EditButtonAndDeleteButton
  },

  data() {
    return {
      tasks: []
    };
  },

  computed: {
    ...mapGetters({
      userId: "auth/user_id",
      storeTasks: "task/tasks"
    })
  },

  methods: {},

  watch: {
    storeTasks(values) {
      if (values) {
        this.tasks = values["data"].map(function(item) {
          const start_date = item.start_date.split(" ");
          const due_date = item.due_date.split(" ");
          return {
            task_id: item.id,
            done: item.done,
            name: item.name,
            context_id: item.context_id,
            context: item.context,
            project_id: item.project_id,
            project: item.project,
            start_date: start_date[0],
            due_date: due_date[0],
            term: item.term,
            finished: item.finished,
            repeat_id: item.repeat_id,
            repeat: item.repeat,
            priority_id: item.priority_id,
            priority: item.priority
          };
        });
      }
    }
  }
};
</script>
