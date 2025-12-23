<template>
  <div id="main">
    <play-header :game-title="gameTitle" :game-data="gameData"></play-header>
    <el-container class="main-content">
      <router-view @updateGameTitle="updateGameTitle" @updateGameData="updateGameData"></router-view>
    </el-container>
  </div>
</template>

<script>
import navigationMenu from "../components/Menu.vue";
import CryptoJS from 'crypto-js';

export default {
  data() {
    return {
      gameTitle: "",
      gameData: {},
      tawkApiKey: `${process.env.MIX_TAWK_API_KEY}`
    };
  },
  components: {
    navigationMenu
  },
  methods: {
    updateGameTitle(title) {
      this.gameTitle = title;
    },
    updateGameData(game) {
      this.gameData = game;
    },
    setTawk() {
      this.user = this.$auth.user();

       var hashed = CryptoJS.HmacSHA256(this.user.email, this.tawkApiKey)
      var hashInBase64 = CryptoJS.enc.Base64.stringify(hashed);

      let payload = {
        name: this.user.username,
        email: this.user.email,
        emailHmac: hashInBase64,
        username: this.user.username,
        userId: this.user.id,
      };
      this.$Tawk.$updateChatUser(payload)
    }
  },
  mounted() {
    this.setTawk();
    }
};
</script>


<style scoped>
#main {
  padding: 0;
  display: flex;
  flex-direction: column;
}
</style>