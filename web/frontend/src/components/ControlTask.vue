<template>
  <v-card>
    <v-card-text>
      <v-container>
        <!-- エラーメッセージ表示部分 -->
        <v-row
          v-if="taskAddErrors"
          class="font-weight-bold red--text text--darken-3"
        >
          <ul v-if="taskAddErrors.name">
            <li v-for="msg in taskAddErrors.name" :key="msg">
              {{ msg }}
            </li>
          </ul>
          <ul v-if="taskAddErrors.start_date">
            <li v-for="msg in taskAddErrors.start_date" :key="msg">
              {{ msg }}
            </li>
          </ul>
          <ul v-if="taskAddErrors.due_date">
            <li v-for="msg in taskAddErrors.due_date" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </v-row>
        <!-- タスク名 -->
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-text-field
              label="タスク名"
              required
              color="orange"
              v-model="taskControlForm.name"
            />
          </v-col>
        </v-row>
        <!-- コンテキスト名 -->
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-select
              label="コンテキスト"
              :items="contexts.data"
              item-text="name"
              item-value="id"
              v-model="taskControlForm.context_id"
            />
          </v-col>
        </v-row>
        <!-- プロジェクト名 -->
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-select
              label="プロジェクト"
              :items="projects.data"
              item-text="name"
              item-value="id"
              v-model="taskControlForm.project_id"
            />
          </v-col>
        </v-row>
        <v-row>
          <!-- 開始日 -->
          <v-col cols="6" sm="6" md="6">
            <v-text-field label="開始日" v-model="taskControlForm.start_date" disable>
              <template v-slot:append-outer>
                <date-picker v-model="taskControlForm.start_date" />
              </template>
            </v-text-field>
          </v-col>
          <!-- 終了日 -->
          <v-col cols="6" sm="6" md="6">
            <v-text-field label="終了日" v-model="taskControlForm.due_date" disable>
              <template v-slot:append-outer>
                <date-picker v-model="taskControlForm.due_date" />
              </template>
            </v-text-field>
          </v-col>
        </v-row>
        <!-- ポモドーロ数 -->
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-select
              label="ポモドーロ数"
              :items="pomodoroItems"
              v-model="taskControlForm.term"
            />
          </v-col>
        </v-row>
        <!-- 繰り返し -->
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-select
              label="繰り返し"
              :items="repeats.data"
              item-text="name"
              item-value="id"
              v-model="taskControlForm.repeat_id"
            />
          </v-col>
        </v-row>
        <!-- 優先度 -->
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-select
              label="優先度"
              :items="priorities.data"
              item-text="name"
              item-value="id"
              v-model="taskControlForm.priority_id"
            />
          </v-col>
        </v-row>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="orange" text @click="close">
        キャンセル
      </v-btn>
      <v-btn color="orange" dark @click="create">
        追加
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import DatePicker from "./DatePicker";

const maxPomodoro = 100;
const pomodoroRange = [...Array(maxPomodoro).keys()];

export default {
  components: {
    DatePicker
  },

  data() {
    return {
      pomodoroItems: pomodoroRange
    };
  },

  computed: {
    ...mapState({
      taskControlForm: state => state.task.taskControlForm,
      apiStatus: state => state.task.apiStatus,
      taskAddErrors: state => state.task.taskAddErrorMessages
    }),

    ...mapGetters({
      userId: "auth/user_id",
      contexts: "context/contexts",
      projects: "project/projects",
      repeats: "repeat/repeats",
      priorities: "priority/priorities",
      display: "task/display"
    }),

    isPersistedItem() {
      return !!this.taskControlForm.task_id;
    }
  },

  methods: {
    async create() {
      await this.$store.dispatch("task/create", [this.userId, this.taskControlForm]);
      if (this.apiStatus) {
        this.taskControlForm = {};
        this.close();
      }
    },

    close() {
      this.$store.dispatch("task/close");
    }
  },

  // watch: {
  //   storeTaskControlForm(values) {
  //     if (values) {
  //       this.taskControlForm = values;
  //     }
  //   }
  // }
};
</script>
