<template>
  <div class="u-margin__padding--10px0">
    <div class="u-size__width--94per u-align__block--center">
      <template>
        <v-btn
          depressed
          color="primary"
          class="u-margin__margin--10px0"
          v-bind="attrs"
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
import { mapGetters } from "vuex";
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
      ]
    };
  },

  computed: {
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
