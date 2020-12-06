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
        :items="projects"
        sort-by="project_id"
        disable-pagination="true"
        hide-default-footer="true"
      >
        <template v-slot:top>
          <v-dialog v-model="dialog" max-width="600px">
            <v-card>
              <v-card-text>
                <v-container>
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
                <v-btn color="orange" dark @click="create">
                  追加
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </template>

        <template v-slot:item.actions="{ item }">
          <div v-if="item.name !== '未設定'">
            <v-icon>
              mdi-pencil
            </v-icon>
            <v-icon>
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
      // 設定画面に表示するプロジェクトデータ
      projects: [
        {
          project_id: 0,
          name: ""
        }
      ],
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
      apiStatus: state => state.project.apiStatus
    }),

    ...mapGetters({
      userId: "auth/user_id",
      storeProjects: "project/projects"
    })
  },

  methods: {
    async fetch() {
      const route = "/api/projects/" + this.userId;
      const response = await window.axios.get(route);

      let datas = [];
      response.data.data.forEach(function(item) {
        datas.push({
          project_id: item.id,
          name: item.name
        });
      });

      this.projects = datas;
    },

    add() {
      this.projectSettingForm = {};
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

    close() {
      this.dialog = false;
    }
  },

  watch: {
    $route: {
      async handler() {
        const functions = [this.fetch()];
        await Promise.all(functions);
      },
      immediate: true
    }
  }
};
</script>
