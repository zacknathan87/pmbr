<template>
  <div class="page-content">
    <div v-if="!loading && hasGame" class="play-content">
      <el-row :gutter="0">
        <el-col :span="16" :xs="24">
          <div
            class="result-box"
            v-if="pastGame"
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
        </el-col>
        <el-col :span="8" :xs="24">
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
          <div v-if="betTypes.length">
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
                class="bet-radio modern-checkbox"
                v-for="(v2, i) in betTypes"
                :key="i"
                :label="v2['id']"
                name="bet_type_ids"
                @change="handleBetChange(v2)"
                border
              >
                <div class="bet-option">
                  <span class="bet-name">{{ $t("app." + v2["name_code"]) }}</span>
                  <span class="bet-odd">{{ v2["odd"] }}</span>
                </div>
              </el-checkbox>
            </el-checkbox-group>
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
                  <template slot="prepend">{{ this.$auth.user().country.currency }}</template>
                </el-input>
              </el-form-item>
              <el-form-item label>
                <el-button
                  style="width: 100%; text-transform: uppercase"
                  class="modern-bet-button"
                  @click="submit"
                  size="medium"
                  :disabled="formSubmitting"
                >
                  <i
                    class="fas fa-spinner fa-spin loading-spinner"
                    v-if="formSubmitting"
                  ></i>
                  <i class="fas fa-chart-line" v-else></i>
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
      newGame: false,
      isFetchingNextGame: false,
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
  computed: {
    betTypes() {
      try {
        return (this.gameData &&
          this.gameData.bet_type_group &&
          this.gameData.bet_type_group[0] &&
          this.gameData.bet_type_group[0].bet_type)
          ? this.gameData.bet_type_group[0].bet_type
          : [];
      } catch (e) {
        return [];
      }
    }
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
          this.newGame = false;
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
      // If a new game already arrived via parent/Echo (prop update), consume the flag and do nothing.
      if (this.newGame) {
        this.newGame = false;
        return;
      }

      // Otherwise, poll once to sync to the next game (fallback when Echo is late)
      if (this.isFetchingNextGame) return;
      this.isFetchingNextGame = true;
      this.getCurrentGame()
        .finally(() => {
          this.isFetchingNextGame = false;
        });
    },

    getCurrentGame() {
      return axios
        .get("/game/getGame/" + this.gameType + "/" + this.gameChannel)
        .then((response) => {
          if (response.data.status == 1) {
            this.$emit('updateGameData', response.data.data);
          }
        })
        .catch(error => {
          console.error('Error fetching game data:', error);
          // Only show error if we can't fetch new game data
          this.$alert("Please refresh this page.", "Something went wrong!", {
            confirmButtonText: "OK",
            center: true,
          });
        });
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
      this.newGame = true;
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

.page-content {
  min-height: 100vh;
  background: #ffffff;
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 1rem;
}

.result-box {
  background: #ffffff;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 1.5rem;
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
}

.result-content {
  flex: 2;
  display: flex;
  padding: 1rem;
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
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 0.75rem;
  box-shadow: 0 2px 4px rgba(0, 163, 224, 0.2);
}

.countdown-box.betting {
  background: #FFC107;
  color: #333333;
  box-shadow: 0 2px 4px rgba(255, 193, 7, 0.2);
}

.countdown-label {
  padding: 0.25rem 0 0.5rem 0;
  font-size: 0.875rem;
  line-height: 1.2;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  opacity: 0.9;
}

.countdown-value {
  font-size: 1.75rem;
  line-height: 1.2;
  font-weight: 700;
  text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
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

.ball {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 50%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 0.75rem;
  color: #333333;
  width: 50px;
  height: 50px;
  text-align: center;
  font-size: 1.25rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
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
  margin-top: 5px;
}

/* Ensure gameplay list is always visible */
.gameplay-box {
  display: flex;
  flex-direction: column;
}

.gameplay-content {
  flex: 1 1 auto;
  min-height: 220px;
  overflow: visible;
}

/* Layout for bet options */
.bet-radio-case {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
}

.bet-radio {
  margin: 4px !important;
}

/* Modern bet button (Element UI checkbox/radio) - White theme */
.el-checkbox.modern-checkbox.is-bordered,
.el-radio.modern-checkbox.is-bordered {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 8px;
  padding: 0;
  min-width: 108px;
  min-height: 56px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #333333;
  transition: all 0.2s ease;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.el-checkbox.modern-checkbox.is-bordered:hover,
.el-radio.modern-checkbox.is-bordered:hover {
  transform: translateY(-1px);
  border-color: #00A3E0;
  box-shadow: 0 4px 8px rgba(0, 163, 224, 0.15);
}

.el-checkbox.modern-checkbox.is-bordered.is-checked,
.el-radio.modern-checkbox.is-bordered.is-checked {
  background: linear-gradient(135deg, #00A3E0 0%, #0077b6 100%);
  border-color: #00A3E0;
  color: #ffffff;
}

.el-checkbox.modern-checkbox .el-checkbox__label,
.el-radio.modern-checkbox .el-radio__label {
  padding: 10px 12px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Keep odds readable on selected buttons */
.el-checkbox.modern-checkbox.is-bordered.is-checked .bet-odd,
.el-radio.modern-checkbox.is-bordered.is-checked .bet-odd {
  color: #ffffff;
}

@media (max-width: 600px) {
  .el-checkbox.modern-checkbox.is-bordered,
  .el-radio.modern-checkbox.is-bordered {
    min-width: 44%;
    min-height: 48px;
  }
}

/* Stacked label for bet option */
.bet-option {
  display: flex;
  flex-direction: column;
  align-items: center;
  line-height: 1.1;
}
.bet-name {
  font-weight: 700;
}
.bet-odd {
  color: #00A3E0;
  font-size: 12px;
  margin-top: 2px;
}

/* Mobile layout: stack columns and compact top section */
@media only screen and (max-width: 600px) {
  .result-box {
    padding: 0.75rem;
  }

  .result-content {
    padding: 0.25rem;
    text-align: center;
  }

  .result-content div:first-child {
    font-size: 12px;
    margin-bottom: 2px;
  }

  .result-content div:nth-child(2) {
    font-size: 11px;
    margin-bottom: 4px;
  }

  .result-body {
    padding: 0rem 0;
    gap: 0.35rem;
  }

  .ball {
    width: 32px;
    height: 32px;
    font-size: 14px;
    padding: 0.25rem;
  }

  .final-no {
    width: 36px;
    height: 36px;
    font-size: 14px;
    padding: 0.25rem;
  }

  .result-countdown {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 6px;
    margin-top: 6px;
    width: 100%;
    margin-bottom: 6px;
  }

  .countdown-box {
    margin-bottom: 0;
    padding: 0.5rem;
  }

  .countdown-label {
    font-size: 10px;
    padding: 2px 0 0 0;
    line-height: 1;
  }

  .countdown-value {
    font-size: 18px;
    line-height: 1.1;
  }
}

.gameplay-box {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  background: #ffffff;
}

.gameplay-content {
  box-shadow: 0 -2px 3px 0 rgba(0, 0, 0, 0.1);
  flex: 1 1 auto;
  overflow-x: visible;
  overflow-y: auto;
  min-height: 220px;
  height: auto;
  padding: 15px 15px 0;
  margin-bottom: 15px;
}

.gameplay-input-box {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid #e9ecef;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  padding: 1.5rem;
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
  font-size: 16px;
  margin-bottom: 5px;
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
  background: #6c757d;
  color: #fff;
  font-size: 18px;
  min-height: 90px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 8px;
}

.bet-info {
  border-bottom: 1px solid #dee2e6;
  padding: 5px 10px;
  margin-bottom: 10px;
  color: #333333;
  background: #f8f9fa;
  border-radius: 6px;
}
</style>
/* Modern-checkbox cleanup (hide native checkbox indicator for pill buttons) */
<style lang="scss" scoped>
.el-checkbox.modern-checkbox .el-checkbox__input,
.el-checkbox.modern-checkbox .el-checkbox__inner {
  display: none !important;
}
</style>
