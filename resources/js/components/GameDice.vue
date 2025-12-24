<template>
  <div class="page-content" style="display: flex">
    <div v-if="!loading && hasGame" class="play-content">
      <div class="result-section">
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
            <div class="result-body" v-if="this.pastGame.no">
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
      </div>

      <div class="gameplay-box">
        <div class="gameplay-content">
          <div class="bet-title">{{ $t("app.choose_bets") }}</div>
          <div class="result-body" style="margin-bottom: 25px">
            <div class="dice">{{ this.diceNo }}</div>
            <span>+</span>
            <div class="dice">{{ this.diceNo }}</div>
            <span>+</span>
            <div class="dice">{{ this.diceNo }}</div>
            <span>=</span>
            <div class="final-no headShake animated infinite">?</div>
          </div>

          <div v-if="this.gameData.bet_type_group[0]">
            <el-checkbox-group class="bet-radio-case" v-model="form.pickedBet">
              <el-checkbox
                class="bet-radio modern-checkbox"
                v-for="(v, i) in this.gameData.bet_type_group[0].bet_type"
                :key="i"
                :label="v['id']"
                name="bet_type_ids"
                @change="handleBetChange(v)"
                border
                >
                <div class="bet-option">
                  <span class="bet-name">{{ $t("app." + v["name_code"]) }}</span>
                  <span class="bet-odd">{{ v["odd"] }}</span>
                </div>
              </el-checkbox
              >
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

export default {
  props: {
    gameData: {
      required: true,
    },
  },
  data() {
    return {
      loading: true,
      hasGame: false,
      newGame: false,
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
      diceNo: 0,

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
      formData.append("bet_type_ids", this.form.pickedBet);
      formData.append("game_id", this.gameData.id);

      axios.post("/game/placeBetDice", formData).then((response) => {
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
    changeDiceNo() {
      if (this.diceNo == 9) {
        this.diceNo = 0;
      } else {
        this.diceNo++;
      }
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
    });

    window.setInterval(() => {
      this.changeDiceNo();
    }, 200);
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



<style lang="scss" scoped>
@import "../../sass/_variables";
@import "../../sass/_utilities";

.app-container {
  min-height: 100%;
  height: 100%;
  background: #ffffff;
  padding: 0;
}

.page-content {
  min-height: 100vh;
  background: #ffffff;
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 1rem;
}

.result-section {
  display: flex;
  flex-direction: row;
  gap: 10px;
  margin-bottom: 15px;
}

@media (max-width: 768px) {
  .result-section {
    flex-direction: column;
    gap: 10px;
  }
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
  flex: 2;
  min-width: 0;
}

.result-countdown {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  flex: 1;
  min-width: 120px;
}

@media (max-width: 768px) {
  .result-box {
    flex: auto;
    width: 100%;
  }
  
  .result-countdown {
    flex-direction: row;
    width: 100%;
    gap: 10px;
  }
  
  .countdown-box {
    flex: 1;
    margin-bottom: 0 !important;
  }
}

.result-content {
  flex: 2;
  display: flex;
  padding: 1rem;
  flex-direction: column;
  align-self: stretch;
  justify-content: center;
  color: #333333;
  min-width: 0;
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
  min-width: 0;
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
  gap: 0.5rem;
  flex-wrap: wrap;
}

@media (max-width: 480px) {
  .result-body {
    gap: 0.25rem;
    padding: 0.5rem 0;
  }
}

.result-body span {
  font-size: 1.25rem;
  font-weight: 600;
  color: #00d4ff;
  flex-shrink: 0;
}

@media (max-width: 480px) {
  .result-body span {
    font-size: 1rem;
  }
}

.dice {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 8px;
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
  flex-shrink: 0;
}

@media (max-width: 480px) {
  .dice {
    width: 40px;
    height: 40px;
    padding: 0.5rem;
    font-size: 1rem;
  }
}

.final-no {
  padding: 0.75rem;
  border-radius: 8px;
  background: #28a745;
  font-weight: 700;
  color: #fff;
  width: 50px;
  height: 50px;
  text-align: center;
  font-size: 1.25rem;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);
  flex-shrink: 0;
}

@media (max-width: 480px) {
  .final-no {
    width: 40px;
    height: 40px;
    padding: 0.5rem;
    font-size: 1rem;
  }
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
  flex-direction: column;
        background: #fff;  /* fallback for old browsers */
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
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
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
  background: #6c757d;
  color: #fff;
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
  border-bottom: 1px solid #495057;
  padding: 10px 15px;
  margin-bottom: 15px;
  color: #ffffff;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 6px;
}
</style>