<template>
  <div class="page-content" style="display: flex">
    <div v-if="!loading && hasGame" class="play-content">
      <el-row :gutter="0">
        <el-col :span="16" style="height: 100%">
          <div
            class="result-box"
            v-if="pastGame"
            style="height: 100%"
            :class="{ 'tada animated': resultBoxAnimated }"
          >
            <div class="result-content">
              <div>
                {{ $t("app.past_result") }}: {{ $t("app.game_id") }} #{{
                  this.pastGame.id
                }}
              </div>
              <div>{{ this.pastGameDateTime }}</div>
              <div class="result-body" v-if="this.pastGame.no">
                <div class="ball ball-1">
                  {{ this.pastGame.no.split(",")[0] }}
                </div>
                <div class="ball ball-2">
                  {{ this.pastGame.no.split(",")[1] }}
                </div>
                <div class="ball ball-3">
                  {{ this.pastGame.no.split(",")[2] }}
                </div>
                <div class="ball ball-4">
                  {{ this.pastGame.no.split(",")[3] }}
                </div>
                <div class="ball ball-5">
                  {{ this.pastGame.no.split(",")[4] }}
                </div>
                <div class="ball ball-6">
                  {{ this.pastGame.no.split(",")[5] }}
                </div>
                <span class="plus">+</span>
                <div class="ball ball-7">
                  {{ this.pastGame.no.split(",")[6] }}
                </div>
              </div>
            </div>
          </div>
        </el-col>
        <el-col :span="8" style="height: 100%">
          <div class="result-countdown">
            <div class="countdown-box">
              <countdown :time="timerNextGame" :transform="transform" 
                @end="onTimerNextGameEnd">
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
              <countdown
                :time="timerBetTime"
                :transform="transform"
                @end="onTimerBetEnd"
              >
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

      <div class="gameplay-box">
        <div class="gameplay-content">
          <div v-if="this.gameData.bet_type_group">
            <div class="bet-title">{{ $t("app.choose_bets") }}</div>
            <div class="result-body" style="margin: -10px 0 25px">
              <div
                class="ball ball-1"
                :class="{ 'animated bounce infinite': animateBall1 }"
              >
                {{ this.runningNo }}
              </div>
              <div
                class="ball ball-2"
                :class="{ 'animated bounce infinite': animateBall2 }"
              >
                {{ this.runningNo }}
              </div>
              <div
                class="ball ball-3"
                :class="{ 'animated bounce infinite': animateBall3 }"
              >
                {{ this.runningNo }}
              </div>
              <div
                class="ball ball-4"
                :class="{ 'animated bounce infinite': animateBall4 }"
              >
                {{ this.runningNo }}
              </div>
              <div
                class="ball ball-5"
                :class="{ 'animated bounce infinite': animateBall5 }"
              >
                {{ this.runningNo }}
              </div>
              <div
                class="ball ball-6"
                :class="{ 'animated bounce infinite': animateBall6 }"
              >
                {{ this.runningNo }}
              </div>
              <span class="plus">+</span>
              <div
                class="ball ball-7"
                :class="{ 'animated bounce infinite': animateBall7 }"
              >
                ?
              </div>
            </div>
            <el-tabs
              v-model="activeTab"
              tab-position="left"
              @tab-click="tabChanged"
            >
              <el-tab-pane
                v-for="(v, i) in this.gameData.bet_type_group"
                :key="i"
                :label="$t('app.' + v.name_code)"
              >
                <el-checkbox-group
                  class="bet-radio-case"
                  v-model="form.pickedBet"
                  :max="limitJackpot"
                >
                  <el-checkbox
                    class="bet-radio"
                    v-for="(v2, i) in v.bet_type"
                    :key="i"
                    :label="activeTab == 7 ? v2['name_code'] : v2['id']"
                    name="bet_type_ids"
                    @change="handleBetChange(v)"
                    border
                    >{{ $t("app." + v2["name_code"]) }}<br /><small
                      class="odd"
                      >{{ v2["odd"] }}</small
                    ></el-checkbox
                  >
                </el-checkbox-group>
              </el-tab-pane>
            </el-tabs>
          </div>
        </div>
        <div class="gameplay-input-box">
          <div class="frm-bet-input bet-input" v-if="!betDisabled">
            <div class="bet-info">
              <el-row :gutter="0">
                <el-col :span="16">
                  <div v-if="activeTab != 7">
                    {{ $t("app.total_selected") }} :
                    {{ this.form.pickedBet.length }}
                  </div>
                  <div v-else>
                    {{ $t("app.jackpot") }} :
                    <span
                      v-for="(list, index) in this.form.pickedBet"
                      :key="index"
                    >
                      <span>{{ list }}</span
                      ><span v-if="index + 1 < form.pickedBet.length">, </span>
                    </span>
                  </div>
                </el-col>
                <el-col :span="8" style="text-align: right"
                  ><el-button
                    size="mini"
                    :disabled="this.form.pickedBet.length == 0"
                    @click="clearBets"
                    >{{ $t("app.clear") }}</el-button
                  ></el-col
                >
              </el-row>
            </div>
            <el-form
              @submit.prevent="submit"
              :inline="true"
              label-position="top"
              :model="form"
              ref="form"
              class="demo-form-inline"
            >
              <el-form-item :class="{ 'is-error': $v.form.amount.$error }">
                <el-autocomplete
                  class="inline-input"
                  v-model="form.amount"
                  :fetch-suggestions="querySearch"
                  size="medium"
                  :validate-event="true"
                  @select="handleSelect"
                  @input="handleAmountIpt"
                  :placeholder="$t('app.amount')"
                ></el-autocomplete>
              </el-form-item>
              <el-form-item>
                <el-input
                  :placeholder="$t('app.total')"
                  v-model="totalAmount"
                  size="medium"
                  :disabled="true"
                >
                  <template slot="prepend">{{ this.$auth.user().country.currency }}</template>
                </el-input>
              </el-form-item>
              <el-form-item label>
                <el-button
                  style="width: 100%; text-transform: uppercase"
                  type="primary"
                  @click="submit"
                  size="medium"
                  :disabled="betBtnDisabled"
                >
                  <i
                    class="fas fa-spinner fa-spin loading-spinner"
                    v-if="formSubmitting"
                  ></i>
                  {{ $t("app.bet") }}
                </el-button>
              </el-form-item>
            </el-form>
          </div>
          <div class="frm-bet-input bet-closed" v-else>
            <div class>{{ $t("app.bet_closed") }}</div>
          </div>
          <!-- <bet-input
              :game-data="this.gameData"
              :game-id="currentGameId"
              :bet-disabled="betDisabled"
            ></bet-input> -->
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
</template>


<script>
import moment from "moment";
import { required, numeric, minValue } from "vuelidate/lib/validators";

export default {
  props: {
    gameData: {
      required: true,
    },
  },
  data() {
    return {
      runningNo: 0,
      currentBall: 1,
      newGame: false,
      animateBall1: true,
      animateBall2: false,
      animateBall3: false,
      animateBall4: false,
      animateBall5: false,
      animateBall6: false,
      animateBall7: false,
      loading: true,
      hasGame: false,
      pickedBall: 1,
      errorCode: 0,
      currentGameId: 0,
      betDisabled: false,
      gameChannel: "",
      gameType: "",
      pastGame: {},
      pastGameDateTime: "",
      bets: [],
      timerBetTime: 0,
      timerNextGame: 0,
      totalAmount: null,
      resultBoxAnimated: false,
      selectAmounts: [
        { value: "100" },
        { value: "200" },
        { value: "500" },
        { value: "1000" },
      ],

      formSubmitting: false,
      betBtnDisabled: false,
      formInline: {
        amount: "",
        betTypeId: "",
      },
      form: {
        pickedBet: [],
        amount: "",
        betTypeId: "",
      },

      activeTab: 0,
      limitJackpot: 100,
    };
  },
  validations() {
    return {
      form: {
        amount: { required, numeric },
        pickedBet: { required },
      },
    };
  },
  created() {},
  methods: {
    tabChanged(tab, event) {
      this.form.pickedBet = [];
      this.totalAmount = null;

      if (this.activeTab == 7) {
        this.limitJackpot = 7;
        this.betBtnDisabled = true;
      } else {
        this.betBtnDisabled = false;
        this.limitJackpot = 100;
      }
    },
    clearBets() {
      this.form.pickedBet = [];
      this.totalAmount = null;
    },
    submit() {
      this.formSubmitting = true;
      this.betBtnDisabled = true;
      this.$v.form.$touch();
      // if its still pending or an error is returned do not submit
      if (this.$v.form.$error) {
        this.formSubmitting = false;
        this.betBtnDisabled = false;
        return;
      }

      let formData = new FormData();
      formData.append("amount", this.form.amount);
      formData.append("ball_num", this.pickedBall);
      formData.append("bet_type_ids", this.form.pickedBet);
      formData.append("game_id", this.gameData.id);
      formData.append("jackpot", this.activeTab == 7 ? 1 : 0);

      axios.post("/game/placeBetNum", formData).then((response) => {
        this.form.amount = "";
        this.form.betTypeId = "";
        this.form.pickedBet = [];
        (this.pickBetName = this.$t("app.pick_bet")), this.$v.form.$reset();
        this.formSubmitting = false;
        this.betBtnDisabled = false;

        if (response.data.status == 1) {
          this.$alert("Bet Placed!", "Success", {
            confirmButtonText: "OK",
            center: true,
          });

          this.$store.dispatch("auth/fetch");
        } else {
          if (response.data.code == 500) {
            this.$alert("Account Suspended!", "Warning", {
              confirmButtonText: "OK",
              callback: (action) => {
                this.$auth.logout({
                  makeRequest: true,
                  redirect: "login",
                });
              },
            });
          } else {
            this.$alert(response.data.message, this.$t("app.error"), {
              confirmButtonText: "OK",
              type: "error",
              center: true,
            });
          }
        }
      });

      return true;
    },
    handleSelect(item) {
      if (this.activeTab == 7) {
        if (this.form.pickedBet.length > 0) {
          this.totalAmount = this.form.amount;
        }
      } else {
        if (this.form.pickedBet.length > 0) {
          this.totalAmount = this.form.amount * this.form.pickedBet.length;
        }
      }
    },
    querySearch(queryString, cb) {
      var selectAmounts = this.selectAmounts;
      var results = queryString
        ? selectAmounts.filter(this.createFilter(queryString))
        : selectAmounts;
      // call callback function to return suggestions
      cb(results);
    },
    createFilter(queryString) {
      return (selectAmounts) => {
        return (
          selectAmounts.value
            .toLowerCase()
            .indexOf(queryString.toLowerCase()) === 0
        );
      };
    },
    handleBetChange(item) {
      if (this.activeTab == 7) {
        if(this.form.pickedBet.length == 7) {
          this.betBtnDisabled = false;
        } else {
          this.betBtnDisabled = true;
        }
        if (this.form.amount > 0) {
          this.totalAmount = this.form.amount;
        }
      } else {
        if (this.form.amount > 0) {
          this.totalAmount = this.form.amount * this.form.pickedBet.length;
        }
      }
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
    handleAmountIpt(value) {
      if (this.activeTab == 7) {
        if (!isNaN(value) && this.form.pickedBet.length > 0) {
          this.totalAmount = this.form.amount;
        }
      } else {
        if (!isNaN(value) && this.form.pickedBet.length > 0) {
          this.totalAmount = this.form.amount * this.form.pickedBet.length;
        }
      }
    },

    initGame(firstLoad = true) {
      const startTime = moment();
      const endTime = moment(this.gameData.end_at);

      if (this.gameData.status_id === 2) {
        this.betDisabled = false;

        // status change new game
        if (!firstLoad) {
          this.animateResultBox();
          this.newGame = false;
        }
      }

      // get next game
      this.timerNextGame = moment.duration(endTime.diff(startTime)).valueOf();
      if (this.timerNextGame < 0) {
        this.timerNextGame = 0;
      }

      if (this.gameData.status_id === 3) {
        this.betDisabled = true;
      } else {
        // get bet timer
        this.timerBetTime =
          this.timerNextGame - this.gameData.game_channel.gracetime * 1000;

        if (this.timerBetTime < 0) {
          this.betDisabled = true;
          this.timerBetTime = 0;
        }
      }

      this.loading = false;
      this.hasGame = true;

      this.currentGameId = this.gameData.id;
      this.pastGame = this.gameData.past_game;
      this.bets = this.gameData.bets;
    },

    onTimerBetEnd() {
      this.betDisabled = true;
    },
    changeAnimateBall() {
      this.currentBall++;
      if (this.currentBall == 8) {
        this.currentBall = 1;
      }

      this.animateBall1 = this.currentBall == 1 ? true : false;
      this.animateBall2 = this.currentBall == 2 ? true : false;
      this.animateBall3 = this.currentBall == 3 ? true : false;
      this.animateBall4 = this.currentBall == 4 ? true : false;
      this.animateBall5 = this.currentBall == 5 ? true : false;
      this.animateBall6 = this.currentBall == 6 ? true : false;
      this.animateBall7 = this.currentBall == 7 ? true : false;
    },
    changeRunningNo() {
      this.runningNo = Math.floor(Math.random() * 54) + 1;
    },

    onTimerNextGameEnd() {
      if (!this.newGame) {
        this.$alert("Please refresh this page.", "Something when wrong!", {
          confirmButtonText: "OK",
          center: true,
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
      if (this.gameData) {
        this.initGame(true);
      }

      window.setInterval(() => {
        this.changeAnimateBall();
      }, 1000);

      window.setInterval(() => {
        this.changeRunningNo();
      }, 100);
    });
  },
  watch: {
    pastGame: function () {
      this.pastGameDateTime = moment(this.pastGame.start_at).format(
        "DD-MM-YYYY hh:mm A"
      );
    },
    gameData: function (newVal, oldVal) {
      // watch it
      this.initGame(false);
      this.newGame = true;
    },
  },
};
</script>



<style scoped>
.app-container {
  min-height: 100%;
  height: 100%;
  background: #fff;
}
.result-box {      background: #fff;  /* fallback for old browsers */
    background: -webkit-linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4));  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4)); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    
    
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
  height: 100%;
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

.countdown-box > span {
  display: flex;
  flex: 1;
  height: 100%;
  flex-direction: column;
  justify-content: center;
  align-items: center;
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
  flex-wrap: wrap;
}

.result-body span {
  margin: 0 7px;
}

.final-no {
  padding: 6px;
  border-radius: 6px;
  background: #359f4a;
  font-weight: bold;
  color: #fff;
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
  width: 100%;
}

.gameplay-box {
  /* background: rgba(255, 255, 255, 0.2); */
  flex-grow: 1;
  display: flex;
  flex-direction: column;      background: #fff;  /* fallback for old browsers */
    background: -webkit-linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4));  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4)); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    
    
}

.gameplay-content {
  box-shadow: 0 -2px 3px 0 rgba(0, 0, 0, 0.1);
  flex: 1 1 auto;
  overflow-x: auto;
  height: 0px;
  padding: 15px 15px 0;
  margin-bottom: 15px;
}

.gameplay-input-box {
  background: rgba(0, 0, 0, 0.7);
  height: 100px;
  padding: 0 15px;
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
  padding: 30px;
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

.bet-title {
  text-align: center;
  font-size: 18px;
  margin-bottom: 10px;
}

.el-form-item {
  margin-bottom: 0;
}

.ratio-title {
  text-align: center;
  font-size: 18px;
  padding: 0 0 10px 0;
  color: #ff375e;
  margin-top: -15px;
}

.bet-closed {
  background: #919399;
  color: #fff;
  font-size: 18px;
  height: 100%;
  margin: 0 -15px;
  height: 100px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.bet-info {
  border-bottom: 1px solid #999;
  padding: 5px 10px;
  margin-bottom: 10px;
  color: #fff;
}
</style>

<style>
.el-radio__input {
  display: none !important;
}
.el-radio {
  margin-right: 0;
}
.el-radio.is-bordered.is-checked {
  background: #185a9d;
}
.el-radio__input.is-checked + .el-radio__label {
  color: #fff;
}
</style>