<template>
  <div class="app-container">
    <div
      class="play-loader"
      v-if="loading"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div
      style="width: 100%; height: auto; min-height: 100%; display: flex"
      v-if="!loading && hasGame"
    >
      <div
        class="game-container"
        v-if="!loading && hasGame && game.game_type.name_code == 'game_dice'"
      >
        <game-dice :game-data="game" />
      </div>
      <div
        class="game-container"
        v-if="
          !loading && hasGame && game.game_type.name_code == 'game_5_number'
        "
      >
        <game-5num :game-data="game" />
      </div>
      <div
        class="game-container"
        v-if="
          !loading && hasGame && game.game_type.name_code == 'game_10_number'
        "
      >
        <game-10num :game-data="game" />
      </div>
      <div
        class="game-container"
        v-if="!loading && hasGame && game.game_type.name_code == 'game_jackpot'"
      >
        <game-jackpot :game-data="game" />
      </div>
    </div>
    <div
      v-if="!loading && !hasGame"
      class="play-content"
      style="width: 100%; height: auto; min-height: 100%"
    >
      <div class="nogame" v-if="errorCode == 3">
        <div class="nogame-body">
          <div class="nogame-title">
            <i class="lni lni-ban"></i>
            <br />
            {{ $t("app.not_allowed") }}
          </div>
          <div>{{ $t("app.insufficient_wallet_balance") }}</div>
        </div>
      </div>
      <div class="nogame" v-else>
        <div class="nogame-body">
          <div class="nogame-title">
            <i class="lni lni-construction"></i>
            <br />
            {{ $t("app.sorry") }}
          </div>
          <div>{{ $t("app.system_maintenance") }}</div>
          <div style="font-size: 14px">
            {{ $t("app.contact_customer_service") }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";

import Game10num from "../../components/Game10num.vue";
import Game5num from "../../components/Game5num.vue";
import GameDice from "../../components/GameDice.vue";
import GameJackpot from "../../components/GameJackpot.vue";

export default {
  components: { GameDice, GameJackpot, Game5num, Game10num },
  data() {
    return {
      loading: true,
      hasGame: false,
      errorCode: 0,
      game: {},
    };
  },
  methods: {
    getCurrentGame() {
      axios
        .get("/game/getGame/" + this.gameType + "/" + this.gameChannel)
        .then((response) => {
          console.log(response);
          if (response.data.status == 1) {
            this.game = response.data.data;

            var title =
              this.$t("app." + this.game.game_type.name_code) +
              " / " +
              this.$t("app." + this.game.game_channel.name_code);
            this.$emit("updateGameTitle", title);
            this.$emit("updateGameData", this.game);

            this.loading = false;
            this.hasGame = true;

            this.connectChannel();
          } else {
            this.errorCode = response.data.code;
            this.loading = false;
            // no game - redirect
          }
        });
    },

    connectChannel() {
      Echo.connector.pusher.config.auth.headers["Authorization"] =
        "Bearer " + this.$auth.token();

      Echo.private(
        "game." + this.game.game_type_id + "." + this.game.game_channel_id
      ).listen("GameStatusChanged", (e) => {
        this.game = e.game;
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
      this.getCurrentGame(this.$route.params);
    });
  },
};
</script>

<style>
.game-container {
  align-items: stretch;
  width: 100%;
}

.play-content {
  width: 100%;
}
</style>