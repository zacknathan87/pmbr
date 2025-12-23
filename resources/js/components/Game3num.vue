<template>
  <div class="page-content" style="display: flex">
    <div v-if="!loading && hasGame" class="play-content">
      <div class="play-top">
        <div class="play-top-left">
          <div
            class="result-box"
            v-if="pastGame"
            style="height: 100%"
            :class="{ 'tada animated': resultBoxAnimated }"
          >
            <div class="result-content">
              <div>{{ $t("app.past_result") }}: ID #{{ this.pastGame.id }}</div>
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
                <span>=</span>
                <div class="final-no">{{ this.pastGame.result_no }}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="play-top-right">
          <div class="result-countdown">
            <div class="countdown-box">
              <countdown
                :time="timerNextGame"
                :transform="transform"
                @end="onTimerNextGameEnd"
              >
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
            <div class="countdown-box">
              <div class="betting betting-time-box">
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
          </div>
        </div>
      </div>

      <div class="gameplay-box">
        <vue-custom-scrollbar class="gameplay-content">
          <div v-if="this.gameData.bet_type_group">
            <!-- <div class="bet-title">{{ $t("app.choose_bets") }}</div> -->
            <div class="result-body" style="margin: -10px 0 25px">
              <div class="ball ball-1">
                {{ this.runningNo }}
              </div>
              <div class="ball ball-2">
                {{ this.runningNo }}
              </div>
              <div class="ball ball-3">
                {{ this.runningNo }}
              </div>
            </div>

            <el-checkbox-group class="bet-radio-case" v-model="form.pickedBet">
              <el-checkbox
                class="bet-radio"
                v-for="(v2, i) in this.gameData.bet_type_group[0].bet_type"
                :key="i"
                :label="v2['id']"
                name="bet_type_ids"
                @change="handleBetChange(v2)"
                border
                >{{ $t("app." + v2["name_code"]) }}<br /><small class="odd">{{
                  v2["odd"]
                }}</small></el-checkbox
              >
            </el-checkbox-group>
          </div>
        </vue-custom-scrollbar>
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
                  <template slot="prepend">$</template>
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
import vueCustomScrollbar from "vue-custom-scrollbar";
import "vue-custom-scrollbar/dist/vueScrollbar.css";

export default {
  props: {
    gameData: {
      required: true,
    },
    betsData: {
      required: true,
    },
  },
  components: {
    vueCustomScrollbar,
  },
  data() {
    return {
      runningNo: 0,
      currentBall: 1,
      animateBall1: true,
      animateBall2: false,
      animateBall3: false,
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
    chatItemProps(data) {
      return data.type && data.type === "system" ? { game: this.gameData } : {};
    },
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
      this.timerNextGame = moment.duration(endTime.diff(startTime)).valueOf() + 3000;
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
    },
    changeRunningNo() {
      this.runningNo = Math.floor(Math.random() * 9) + 1;
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
      this.initGame(false);
    },
  },
};
</script>



<style scoped>
.app-container {
  min-height: 100%;
  height: 100%;
}

.result-body {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  padding: 1rem 0;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.result-body span {
  font-size: 1.25rem;
  font-weight: 600;
  color: #00A3E0;
}

.final-no {
  padding: 0.75rem;
  border-radius: 8px;
  background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
  font-weight: 700;
  color: #ffffff;
  width: 50px;
  height: 50px;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
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

ul {
  padding: 0;
  list-style: none;
}

.nogame {
  display: flex;
  height: 100%;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  color: #666666;
  font-size: 18px;
  text-align: center;
  padding: 2rem;
}

.nogame-body {
  margin-top: 2rem;
  background: #ffffff;
  padding: 2rem;
  max-width: 400px;
  border-radius: 12px;
  border: 1px solid #e9ecef;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.nogame-title {
  text-align: center;
  font-size: 2.5rem;
  color: #00A3E0;
  margin-bottom: 1rem;
}

.nogame-title i {
  font-size: 3rem;
  color: #00A3E0;
  margin-bottom: 1rem;
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
  color: #01A89E;
  margin-top: -15px;
}

.bet-info {
  border-bottom: 1px solid #e9ecef;
  padding: 1rem;
  margin-bottom: 1rem;
  background: #f8f9fa;
  border-radius: 8px 8px 0 0;
  color: #333333;
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