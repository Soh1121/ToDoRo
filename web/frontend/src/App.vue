<template>
  <div id="app">
    <v-app>
      <header>
        <Navbar />
      </header>
      <v-main>
        <!-- <div class="container"> -->
        <RouterView />
        <!-- </div> -->
      </v-main>
      <footer>
        <Footer />
      </footer>
    </v-app>
  </div>
</template>

<script>
import Navbar from "./components/navbar/Navbar.vue";
import Footer from "./components/Footer.vue";
import { INTERNAL_SERVER_ERROR } from "./util";

export default {
  components: {
    Navbar,
    Footer
  },
  computed: {
    errorCode() {
      return this.$store.state.error.code;
    }
  },
  watch: {
    errorCode: {
      handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push("/500");
        }
      },
      immediate: true
    },
    $route() {
      this.$store.commit("error.setCode", null);
    }
  }
};
</script>
