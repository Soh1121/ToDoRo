<template>
  <div class="u-margin__padding--10px0">
    <div class="u-size__width--94per u-align__block--center">
      <template>
        <v-btn
          depressed
          color="primary"
          class="u-margin__margin--10px0"
          v-bind="attrs"
          @click="add"
        >
          追加
        </v-btn>
      </template>

      <v-data-table
        :headers="headers"
        :items="projects.data"
        sort-by="project_id"
        disable-pagination="true"
        hide-default-footer="true"
      >
        <template v-slot:top>
          <v-dialog v-model="dialog" max-width="600px">
            <v-card>
              <v-card-text>
                <v-container>
                  <!-- エラーメッセージ表示部分 -->
                  <v-row
                    v-if="projectNameErrors"
                    class="font-weight-bold red--text text--darken-3"
                  >
                    <ul v-if="projectNameErrors.name">
                      <li v-for="msg in projectNameErrors.name" :key="msg">
                        {{ msg }}
                      </li>
                    </ul>
                  </v-row>
                  <!-- フォーム表示部分 -->
                  <v-row>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field
                        label="プロジェクト名"
                        hint="30文字以内"
                        required
                        color="orange"
                        v-model="projectSettingForm.name"
                      />
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn color="orange" text @click="close">
                  キャンセル
                </v-btn>
                <v-btn
                  v-if="isPersistedItem"
                  color="orange"
                  dark
                  @click="update"
                >
                  変更
                </v-btn>
                <v-btn v-else color="orange" dark @click="create">
                  追加
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </template>

        <template v-slot:item.actions="{ item }">
          <div v-if="item.name !== '未設定'">
            <v-icon @click="edit(item)">
              mdi-pencil
            </v-icon>
            <v-icon @click="remove(item)">
              mdi-delete
            </v-icon>
          </div>
        </template>
      </v-data-table>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";

export default {
  data() {
    return {
      dialog: false,
      // 設定データ表示用のヘッダー
      headers: [
        {
          text: "プロジェクト名",
          value: "name"
        },
        {
          text: "操作",
          value: "actions",
          align: "center",
          width: "100px"
        }
      ],
      // 設定用のダイアログのフォームデータ
      projectSettingForm: {}
    };
  },

  computed: {
    ...mapState({
      apiStatus: state => state.project.apiStatus,
      projectNameErrors: state => state.project.projectNameErrorMessages
    }),

    ...mapGetters({
      userId: "auth/user_id",
      projects: "project/projects"
    }),

    isPersistedItem() {
      return !!this.projectSettingForm.id;
    }
  },

  methods: {
    add() {
      this.projectSettingForm = {};
      this.clearError();
      this.dialog = true;
    },

    async create() {
      await this.$store.dispatch("project/create", [
        this.userId,
        this.projectSettingForm
      ]);
      if (this.apiStatus) {
        this.close();
      }
    },

    edit(item) {
      this.projectSettingForm = item;
      this.clearError();
      this.dialog = true;
    },

    async update() {
      await this.$store.dispatch("project/update", [
        this.userId,
        this.projectSettingForm
      ]);
      if (this.apiStatus) {
        this.close();
      }
    },

    async remove(item) {
      this.projectSettingForm = item;
      await this.$store.dispatch("project/remove", [
        this.userId,
        { data: this.projectSettingForm }
      ]);
    },

    close() {
      this.dialog = false;
    },

    clearError() {
      this.$store.commit("project/setProjectNameErrorMessages", null);
    }
  }
};
</script>
