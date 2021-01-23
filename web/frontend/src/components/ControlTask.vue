<template>
  <v-card>
    <v-card-text>
      <v-container>
        <!-- タスク名 -->
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-text-field label="タスク名" required color="orange" />
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
            />
          </v-col>
        </v-row>
        <v-row>
          <!-- 開始日 -->
          <v-col cols="6" sm="6" md="6">
            <v-text-field label="開始日" v-model="value" disable>
              <template v-slot:append-outer>
                <date-picker v-model="value" />
              </template>
            </v-text-field>
          </v-col>
          <!-- 終了日 -->
          <v-col cols="6" sm="6" md="6">
            <v-text-field label="終了日" v-model="value" disable>
              <template v-slot:append-outer>
                <date-picker v-model="value" />
              </template>
            </v-text-field>
          </v-col>
        </v-row>
        <!-- ポモドーロ数 -->
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-select label="ポモドーロ数" :items="pomodoro_items" />
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
            />
          </v-col>
        </v-row>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="orange" text>キャンセル</v-btn>
      <v-btn type="submit" color="orange" dark>
        追加
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";
import DatePicker from "./DatePicker";

const maxPomodoro = 1000;
const pomodoroRange = [...Array(maxPomodoro).keys()];

export default {
  components: {
    DatePicker
  },

  data() {
    return {
      pomodoro_items: pomodoroRange,
      value: null
    };
  },

  computed: {
    ...mapGetters({
      contexts: "context/contexts",
      projects: "project/projects",
      repeats: "repeat/repeats",
      priorities: "priority/priorities"
    })
  }
};
</script>
