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
            </div>

            <el-tabs tab-position="left">
              <el-tab-pane
                v-for="(v, i) in this.gameData.bet_type_group"
                :key="i"
                :label="$t('app.' + v.name_code)"
              >
                <el-checkbox-group
                  class="bet-radio-case"
                  v-model="form.pickedBet"
                >
                  <el-checkbox
                    class="bet-radio"
                    v-for="(v2, i) in v.bet_type"
                    :key="i"
                    :label="v2['id']"
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
                <el-col :span="12"
                  >{{ $t("app.total_selected") }} :
                  {{ this.form.pickedBet.length }}</el-col
                >
                <el-col :span="12" style="text-align: right"
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
                 <template slot="prepend" >{{ this.$auth.user().country.currency }}</template>
                </el-input>
              </el-form-item>
              <el-form-item label>
                <el-button
                  style="width: 100%; text-transform: uppercase"
                  type="primary"
                  @click="submit"
                  size="medium"
                  :disabled="formSubmitting"
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
      formInline: {
        amount: "",
        betTypeId: "",
      },
      form: {
        pickedBet: [],
        amount: "",
        betTypeId: "",
      },
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
    clearBets() {
      this.form.pickedBet = [];
      this.totalAmount = null;
    },
    submit() {
      this.formSubmitting = false;
      this.$v.form.$touch();
      // if its still pending or an error is returned do not submit
      if (this.$v.form.$error) {
        this.formSubmitting = false;
        return;
      }

      let formData = new FormData();
      formData.append("amount", this.form.amount);
      formData.append("ball_num", this.pickedBall);
      formData.append("bet_type_ids", this.form.pickedBet);
      formData.append("game_id", this.gameData.id);

      axios.post("/game/placeBetNum", formData).then((response) => {
        this.form.amount = "";
        this.form.betTypeId = "";
        this.form.pickedBet = [];
        (this.pickBetName = this.$t("app.pick_bet")), this.$v.form.$reset();
        this.formSubmitting = false;

        if (response.data.status == 1) {
          this.$alert("Trade Placed!", "Success", {
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
      if (this.form.pickedBet.length > 0) {
        this.totalAmount = this.form.amount * this.form.pickedBet.length;
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
      if (this.form.amount > 0) {
        this.totalAmount = this.form.amount * this.form.pickedBet.length;
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
      if (!isNaN(value) && this.form.pickedBet.length > 0) {
        this.totalAmount = this.form.amount * this.form.pickedBet.length;
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
      if (this.currentBall == 6) {
        this.currentBall = 1;
      }

      this.animateBall1 = this.currentBall == 1 ? true : false;
      this.animateBall2 = this.currentBall == 2 ? true : false;
      this.animateBall3 = this.currentBall == 3 ? true : false;
      this.animateBall4 = this.currentBall == 4 ? true : false;
      this.animateBall5 = this.currentBall == 5 ? true : false;
    },
    changeRunningNo() {
      this.runningNo = Math.floor(Math.random() * 9) + 1  
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
      }, 200);
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
      this.newGame = true;
      this.initGame(false);
    },
  },
};
</script>



<style scoped>
.app-container {
  min-height: 100%;
  height: 100%;
  background: #ffffff;
}

.result-box {
  background: #ffffff;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: row;
  color: #333333;
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
  padding: 10px;
  flex-direction: column;
  align-self: stretch;
  justify-content: center;
  color: #333333;
}

.countdown-box {
  flex: 1;
  width: 100%;
  background: #00A3E0;
  color: #ffffff;
  padding: 15px 10px;
  border-radius: 8px;
  margin-bottom: 10px;
  box-shadow: 0 2px 4px rgba(0, 163, 224, 0.2);
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
  background: #FFC107;
  color: #333333;
  box-shadow: 0 2px 4px rgba(255, 193, 7, 0.2);
}

.countdown-label {
  padding: 5px 0 5px 0;
  font-size: 12px;
  line-height: 1.2;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  opacity: 0.9;
}

.countdown-value {
  font-size: 24px;
  line-height: 1.2;
  font-weight: 700;
}

.result-body {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  padding: 15px 0 0;
  flex-wrap: wrap;
  gap: 10px;
}

.result-body span {
  margin: 0;
}

.final-no {
  padding: 8px;
  border-radius: 8px;
  background: #28a745;
  font-weight: bold;
  color: #fff;
  width: 40px;
  height: 40px;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);
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
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  background: #f8f9fa;
  border-radius: 8px;
  margin: 10px 0;
}

.gameplay-content {
  box-shadow: 0 -2px 3px 0 rgba(0, 0, 0, 0.1);
  flex: 1 1 auto;
  overflow-x: auto;
  height: 0px;
  padding: 20px;
  margin-bottom: 15px;
  background: #ffffff;
  border-radius: 8px;
}

.gameplay-input-box {
  background: rgba(255, 255, 255, 0.95);
  color: #333333;
  height: 100px;
  padding: 0 20px;
  border-radius: 8px;
  box-shadow: 0px -3px 15px 0px rgba(0, 0, 0, 0.1);
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
  color: #6c757d;
  font-size: 18px;
  text-align: center;
  padding: 30px;
}

.nogame-body {
  margin-top: 30px;
  background: #ffffff;
  border: 1px solid #dee2e6;
  padding: 25px;
  max-width: 300px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.nogame-title {
  text-align: center;
  font-size: 40px;
  color: #dc3545;
}

.nogame-title i {
  font-size: 60px;
}

.bet-title {
  text-align: center;
  font-size: 20px;
  margin-bottom: 15px;
  color: #00A3E0;
  font-weight: 600;
}

.el-form-item {
  margin-bottom: 0;
}

.ratio-title {
  text-align: center;
  font-size: 18px;
  padding: 0 0 10px 0;
  color: #00A3E0;
  margin-top: -15px;
  font-weight: 600;
}

.bet-closed {
  background: rgba(108, 117, 125, 0.9);
  color: #333333;
  font-size: 18px;
  height: 100%;
  margin: 0 -15px;
  height: 100px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 8px;
}

.bet-info {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  padding: 10px 15px;
  margin-bottom: 15px;
  color: #333333;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 6px;
}
</style>

<style>
.el-radio__input {
  display: none !important;
}
.el-radio {
  margin-right: 0;
  border-radius: 8px;
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
}
.el-radio:hover {
  border-color: #00A3E0;
}
.el-radio.is-bordered.is-checked {
  background: linear-gradient(135deg, #00A3E0 0%, #0077b6 100%);
  border-color: #00A3E0;
}
.el-radio__input.is-checked + .el-radio__label {
  color: #ffffff;
}
</style>