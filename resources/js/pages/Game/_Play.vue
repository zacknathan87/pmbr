<template>
  <div class="page-content">
    <div class="app-container">
      <div
        class="play-loader"
        v-if="loading"
        v-loading="loading"
        element-loading-background="rgba(0, 0, 0, 0.7)"
      ></div>

      <div v-if="!loading && hasGame" class="play-content">
        <el-row :gutter="0">
          <el-col :span="16">
            <div
              class="result-box"
              v-if="pastGame"
              :class="{ 'tada animated': resultBoxAnimated }"
            >
              <div class="result-content">
                <div>
                  {{ $t("app.past_result") }}: {{ $t("app.game_id") }} #{{
                    this.pastGame.id
                  }}
                </div>
                <div>{{ this.pastGameDateTime }}</div>
                <div class="result-body">
                  <div class="dice">{{ this.pastGame.no.split(",")[0] }}</div>
                  <span>+</span>
                  <div class="dice">{{ this.pastGame.no.split(",")[1] }}</div>
                  <span>+</span>
                  <div class="dice">{{ this.pastGame.no.split(",")[2] }}</div>
                  <span>=</span>
                  <div class="final-no">{{ this.pastGame.result_no }}</div>
                </div>
              </div>
            </div>
          </el-col>
          <el-col :span="8">
            <div class="result-countdown">
              <div class="countdown-box">
                <countdown :time="timerNextGame" :transform="transform">
                  <template slot-scope="props">
                    <div class="countdown-label">
                      {{ $t("app.next_game_time") }}
                    </div>
                    <div class="countdown-value">
                      {{ props.minutes }}:{{ props.seconds }}
                    </div>
                  </template>
                </countdown>
              </div>

              <div class="countdown-box betting">
                <countdown :time="timerBetTime" :transform="transform">
                  <template slot-scope="props">
                    <div class="countdown-label">
                      {{ $t("app.betting_time") }}
                    </div>
                    <div class="countdown-value">
                      {{ props.minutes }}:{{ props.seconds }}
                    </div>
                  </template>
                </countdown>
              </div>
            </div>
          </el-col>
        </el-row>

        <div class="chat-box">
          <div
            class="chat-content"
            v-chat-scroll="{ always: false, smooth: true }"
          >
            <!-- <chat-item type="system" :past-game="this.pastGame"></chat-item> -->
            <chat-item
              v-for="(b, i) in bets"
              :bet="b"
              :key="i"
              :type="b.type ? b.type : 'player'"
              v-bind="chatItemProps(b)"
            ></chat-item>
          </div>
          <div class="chat-input-box">
            <bet-input
              :game-data="game"
              :game-id="currentGameId"
              :bet-disabled="betDisabled"
            ></bet-input>
          </div>
        </div>
      </div>

      <div v-if="!loading && !hasGame" class="play-content">
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
  </div>
</template>


<script>
import moment from "moment";

export default {
  data() {
    return {
      loading: true,
      hasGame: false,
      errorCode: 0,
      currentGameId: 0,
      betDisabled: false,
      gameChannel: "",
      gameHall: "",
      gameType: "",
      pastGame: {},
      pastGameDateTime: "",
      game: {},
      bets: [],
      timerBetTime: 0,
      timerNextGame: 0,
      resultBoxAnimated: false,
    };
  },
  created() {},
  methods: {
    getCurrentGame() {
      axios
        .get(
          "/game/getGame/" +
            this.gameType +
            "/" +
            this.gameChannel +
            "/" +
            this.gameHall
        )
        .then((response) => {
          if (response.data.status == 1) {
            this.hasGame = true;
            this.game = response.data.data;

            var title =
              this.$t("app." + this.game.game_type.name_code) +
              " / " +
              this.$t("app." + this.game.game_channel.name_code);
            this.$emit("updateGameTitle", title);

            this.currentGameId = this.game.id;
            this.betDisabled = false;
            this.pastGame = this.game.past_game;
            this.bets = this.game.bets;

            this.bets.map((b) => {
              return (b.type = "player");
            });

            this.bets.unshift({
              type: "system",
              pastGame: this.pastGame,
            });

            const startTime = moment();
            const endTime = moment(this.game.end_at);

            // get next game
            this.timerNextGame = moment
              .duration(endTime.diff(startTime))
              .valueOf();

            if (this.game.status_id === 3) {
              this.betDisabled = true;
            } else {
              // get bet timer
              this.timerBetTime = this.timerNextGame - 30000;
            }

            this.connectChannel();
            this.connectBetChannel();

            this.loading = false;
          } else {
            this.errorCode = response.data.code;
            this.loading = false;
            // no game - redirect
          }
        });
    },
    connectChannel() {
      // Initialize auth object if it doesn't exist
      if (!Echo.connector.pusher.config.auth) {
        Echo.connector.pusher.config.auth = { headers: {} };
      }
      Echo.connector.pusher.config.auth.headers["Authorization"] =
        "Bearer " + this.$auth.token();

      Echo.private(
        "game." +
          this.game.game_type_id +
          "." +
          this.game.game_channel_id
      ).listen("GameStatusChanged", (e) => {
        if (e.game.status_id === 3) {
          this.betDisabled = true;
          this.timerBetTime = 0;

          const startTime = moment();
          const endTime = moment(e.game.end_at);

          // get next game
          this.timerNextGame = moment
            .duration(endTime.diff(startTime))
            .valueOf();
        }
        // new game
        if (e.game.status_id == 2) {
          this.$store.dispatch("auth/fetch");
          this.game = e.game;

          this.currentGameId = this.game.id;
          this.betDisabled = false;
          this.pastGame = this.game.past_game;

          this.animateResultBox();

          this.bets.push({
            type: "system",
            pastGame: this.pastGame,
          });

          const startTime = moment();
          const endTime = moment(this.game.end_at);

          // get next game
          this.timerNextGame = moment
            .duration(endTime.diff(startTime))
            .valueOf();
          // get bet timer
          this.timerBetTime = this.timerNextGame - 30000;

          Echo.leaveChannel("game.bet." + this.pastGame.id);

          this.connectBetChannel();
        }

        // console.log(e);
      });
    },
    connectBetChannel() {
      // Initialize auth object if it doesn't exist
      if (!Echo.connector.pusher.config.auth) {
        Echo.connector.pusher.config.auth = { headers: {} };
      }
      Echo.connector.pusher.config.auth.headers["Authorization"] =
        "Bearer " + this.$auth.token();

      Echo.private("game.bet." + this.currentGameId).listen("BetAdded", (e) => {
        var bet = e.bet;
        if (bet.game_id === this.currentGameId) {
          this.bets.push(bet);
        }
      });
    },
    transform(props) {
      Object.entries(props).forEach(([key, value]) => {
        // Adds leading zero
        const digits = value < 10 ? `0${value}` : value;

        props[key] = `${digits}`;
      });

      return props;
    },
    animateResultBox() {
      var self = this;
      self.resultBoxAnimated = true;
      setTimeout(function () {
        self.resultBoxAnimated = false;
      }, 1000);
    },
    chatItemProps(data) {
      return data.type && data.type === "system" ? { game: this.game } : {};
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
    this.gameHall = this.$route.params.gameHall;

    this.$nextTick(function () {
      this.getCurrentGame(this.$route.params);
    });
  },
  watch: {
    pastGame: function () {
      this.pastGameDateTime = moment(this.pastGame.start_at).format(
        "DD-MM-YYYY hh:mm A"
      );
    },
    timerBetTime: function () {
      if (this.timerBetTime <= 0) {
        this.betDisabled = true;
      }
    },
  },
};
</script>



<style scoped>
.page-content {
  background: #f1f1f1;
}
.app-container {
  min-height: 100%;
  height: 100%;
  background: #fff;
}
.result-box {
  background: #fefefe;
  padding: 5px 5px 10px;
  text-align: center;
  box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: row;
}

.result-countdown {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.result-content {
  flex: 2;
  display: flex;
  padding: 5px;
  flex-direction: column;
  align-self: stretch;
  justify-content: center;
}

.countdown-box {
  flex: 1;
  width: 100%;
  background: #bae637;
  padding: 8px 5px;
}

.countdown-box.betting {
  background: #ffc53d;
}

.countdown-label {
  padding: 3px 0 0 0;
  font-size: 12px;
  line-height: 1;
}

.countdown-value {
  font-size: 22px;
  line-height: 1.2;
}

.result-body {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  padding: 8px 0 0;
}

.result-body span {
  margin: 0 7px;
}

.dice {
  padding: 4px;
  border-radius: 6px;
  background: #111;
  color: #fff;
  width: 30px;
  height: 30px;
  text-align: center;
}

.final-no {
  padding: 6px;
  border-radius: 6px;
  background: #faad14;
  font-weight: bold;
  color: #000;
  width: 35px;
  height: 35px;
  text-align: center;
}

.page-content {
  padding: 0 15px;
}

.play-content {
  display: flex;
  flex-direction: column;
  padding-bottom: 0;
  height: 100%;
}

.chat-box {
  background: rgba(255, 255, 255, 0.2);
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.chat-content {
  box-shadow: 0 -2px 3px 0 rgba(0, 0, 0, 0.1);
  flex: 1 1 auto;
  overflow-x: auto;
  height: 0px;
  padding: 15px 15px 0;
  margin-bottom: 15px;
}

.chat-input-box {
  background: rgba(0, 0, 0, 0.7);
  height: 90px;
  padding: 15px;
  box-shadow: 0px -3px 15px 0px rgba(0, 0, 0, 0.3);
}

ul {
  padding: 0;
  list-style: none;
}

.nogame {
  display: flex;
  height: 100%;
  justify-content: flex-start;
  align-items: center;
  flex-direction: column;
  color: #ccc;
  font-size: 18px;
  text-align: center;
}

.nogame-body {
  margin-top: 30px;
  background: rgba(0, 0, 0, 0.6);
  padding: 25px;
  max-width: 300px;
  border-radius: 10px;
}

.nogame-title {
  text-align: center;
  font-size: 40px;
  color: #ddd;
}

.nogame-title i {
  font-size: 60px;
}
</style>