<template>
  <div class="u-margin__padding--10px0">
    <div class="u-size__width--94per u-align__block--center">
      <v-btn
        depressed
        color="primary"
        class="u-margin__margin--10px0"
      >
        追加
      </v-btn>
      <CardList
        v-for="context in contexts"
        v-bind:key="context.id"
        v-bind:id="context.id"
        v-bind:title="context.title"
      />
    </div>
  </div>
</template>

<script>
import { OK } from "../util";
import CardList from "./Setting_cardList";
import { mapGetters } from "vuex";

export default {
  components: {
    CardList
  },
  data() {
    return {
      contexts: [
        {
          id: 0,
          title: ""
        },
      ]
    };
  },
  computed: {
    ...mapGetters({
      userId: "auth/user_id"
    })
  },
  methods: {
    async fetch() {
      const route = "/api/contexts/" + this.userId;
      const response = await window.axios.get(route);

      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }

      let datas = [];
      response.data.data.forEach(function(item) {
        datas.push({
          id: item.id,
          title: item.name,
        });
      });

      this.contexts = datas;
    }
  },
  watch: {
    $route: {
      async handler() {
        const functions = this.fetch();
        await Promise.all(functions)
      },
      immediate: true
    }
  }
}
</script>
