<template>
  <div class="page-content">
    <div
      class="loader"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>


    <div class="page-title">{{ $t("app.game") }} / <span>{{ this.gameTypeTitle }}</span>  / <span>{{ this.gameChannelTitle }}</span></div>

    <div v-if="this.error" class="nogame">
      <div class="nogame-body">
        <div class="nogame-title">
          <i class="fas fa-exclamation-circle"></i>
          <br />
          {{ $t("app.error") }}
        </div>
        <div>Invalid Game</div>
        <div style="font-size: 14px">
          <router-link :to="'/home'">Return Home</router-link>
        </div>
      </div>
    </div>

    <el-row :gutter="20">
      <el-col :span="12" v-for="(g, index) in gameHall" :key="g['id']">
        <router-link :to="'/trades/'+ gameType+'/' + gameChannel + '/' + g['uuid']">
          <el-card :body-style="{ padding: '0px' }" class="box-card">
            <div class="box-img-cover" :style="{ backgroundImage: 'url(/images/pmbr/' + getGameImage(index) + ')' }"></div>
            <div style="padding: 14px;background:#fff;">
              <span>{{ $t("app." + g["name_code"]) }}</span>
            </div>
          </el-card>
        </router-link>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: true,
      error: false,
      gameTypeTitle: "",
      gameChannelTitle: "",
      gameType: "",
      gameChannel: "",

      gameHall: [],
    };
  },
  created() {},
  methods: {
    getGameImage(index) {
      const images = ['game-3number.png', 'game-5number.png', 'game-10number.png', 'game-dice.png'];
      return images[index % 4];
    },
    getGameHall() {
      axios.get("/misc/gameHall/" + this.gameChannel).then((response) => {
        if (response.data.data) {
          this.gameHall = response.data.data;
 
          this.gameTypeTitle = this.$t('app.'+this.gameHall[0].game_type.name_code);
          this.gameChannelTitle = this.$t('app.'+this.gameHall[0].game_channel.name_code);
        } else {
          this.error = true;
        }
 
        this.loading = false;
      });
    },
    async checkUser() {
      await this.$auth.fetch();
      if (this.$auth.user().is_active == 0) {
        this.$alert("Account Suspended!", "Warning", {
          confirmButtonText: "OK",
          callback: (action) => {
            this.$auth.logout({
              makeRequest: true,
              redirect: "login",
            });
          },
        });
      }
    },
  },
  mounted() {
    this.checkUser();
    // this.open();
    this.gameType = this.$route.params.gameType;
    this.gameChannel = this.$route.params.gameChannel;

    this.$nextTick(function () {
      this.getGameHall(this.$route.params);
    });
  },
};
</script>

<style scoped>
/* Game Card Image Cover */
.box-img-cover {
  width: 100%;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 16px 16px 0 0;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>

<style>
.box-card {
  margin-bottom: 20px;
}
</style>