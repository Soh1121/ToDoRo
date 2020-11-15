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
      <CardList />
    </div>
  </div>
</template>

<script>
import CardList from "./Setting_cardList";

export default {
  components: {
    CardList
  },
  data() {
    return {

    };
  }
}
</script>
