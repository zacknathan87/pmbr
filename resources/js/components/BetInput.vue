<template>
  <div class="frm-bet-input bet-input" v-if="!betDisabled">
    <el-form
      @submit.prevent="submit"
      :inline="true"
      label-position="top"
      :model="form"
      ref="form"
      class="demo-form-inline"
    >
      <el-form-item
        :label="( $v.form.amount.$error)? 'Minimun is '+this.minBet : $t('app.amount')"
        :class="{ 'is-error': $v.form.amount.$error }"
      >
        <el-autocomplete
          class="inline-input"
          v-model="form.amount"
          :fetch-suggestions="querySearch"
          :placeholder="'Min: '+this.minBet"
          @select="handleSelect"
        ></el-autocomplete>
      </el-form-item>
      <el-form-item :label="$t('app.bet')" :class="{ 'is-error': $v.form.betTypeId.$error }">
        <input type="hidden" :model="form.betTypeId" name="bet_type_id" />
        <el-button style="width:100%" @click="chooseBetDialogVisible = true">{{ this.pickBetName }}</el-button>
      </el-form-item>
      <el-form-item label>
        <el-button style="width:100%; text-transform: uppercase;" type="primary" @click="submit" :disabled="formSubmitting" >
          <i class="fas fa-spinner fa-spin loading-spinner" v-if="formSubmitting"></i> {{$t('app.bet')}}
        </el-button>
      </el-form-item>
    </el-form>

    <el-dialog
      :title="$t('app.pick_bet')"
      :append-to-body="true"
      :visible.sync="chooseBetDialogVisible"
      width="90%"
      class="frm-bet-input"
      :center="true"
      :before-close="handleClose"
    >
      <div class="ratio-title">{{ $t('app.ratio') }} 1 : {{ this.gameData.game_room.win_ratio }}</div>
      <div class="bet-radio-case" v-if="betType">
        <el-radio
          class="bet-radio"
          v-model="pickedBet"
          v-for="(v, i) in betType"
          :key="i"
          :label="v['id']"
          name="bet_type_id"
          @change="handleBetChange(v)"
          border
        >{{ $t('app.'+v['name_code']) }}</el-radio>
        <!-- <div class="bet-radio"@click="handleBetSelect" :item="v"><span></span></div> -->
      </div>
      <br />
      <h5>{{$t('app.single_number')}}</h5>
      <div class="bet-radio-case" v-if="betTypeNumber">
        <el-radio
          class="bet-radio number"
          v-model="pickedBet"
          v-for="(v, i) in betTypeNumber"
          :key="i"
          :label="v['id']"
          name="bet_type_id"
          @change="handleBetChange(v)"
          border
        >{{ $t('app.'+v['name_code']) }}</el-radio>
        <!-- <div class="bet-radio"@click="handleBetSelect" :item="v"><span></span></div> -->
      </div>

      <span slot="footer" class="dialog-footer">
        <el-button @click="chooseBetDialogVisible = false">{{$t('app.cancel')}}</el-button>
        <el-button type="primary" @click="chooseBetDialogVisible = false">{{ $t('app.confirm' )}}</el-button>
      </span>
    </el-dialog>
  </div>
  <div class="frm-bet-input bet-closed" v-else>
    <div class>{{ $t('app.bet_closed') }}</div>
  </div>
</template>

<script>
import { required, minValue } from "vuelidate/lib/validators";

export default {
  props: {
    gameId: {
      required: true,
    },
    betDisabled: Boolean,
    gameData: {
      required: true,
    },
  },
  data() {
    return {
      minBet: this.gameData.game_room.min_bet,
      formSubmitting: false,
      pickedBet: "",
      pickBetName: this.$t("app.pick_bet"),
      betType: [],
      betTypeNumber: [],
      selectAmounts: [
        { value: "100" },
        { value: "200" },
        { value: "500" },
        { value: "1000" },
      ],
      chooseBetDialogVisible: false,
      formInline: {
        amount: "",
        betTypeId: "",
      },
      form: {
        amount: "",
        betTypeId: "",
      },
    };
  },
  validations() {
    return {
      form: {
        amount: { required, minValue: minValue(this.minBet) },
        betTypeId: { required },
      },
    };
  },
  methods: {
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
    handleClose(done) {
      done();
    },
    handleSelect(item) {},
    handleBetChange(item) {
      this.form.betTypeId = item.id;
      this.pickBetName = this.$t("app." + item["name_code"]);
    },
    getBetType(type = "range") {
      axios.get("/misc/betType/" + type).then((response) => {
        if (type === "range") {
          this.betType = response.data.data;
        } else {
          this.betTypeNumber = response.data.data;
        }
      });
    },
    submit() {
      this.formSubmitting = true;
      this.$v.form.$touch();
      // if its still pending or an error is returned do not submit
      if (this.$v.form.$error) {
        this.formSubmitting = false;
        return;
      }

      let formData = new FormData();
      formData.append("amount", this.form.amount);
      formData.append("bet_type_id", this.form.betTypeId);
      formData.append("game_id", this.gameId);

      axios.post("/game/placeBet", formData).then((response) => {
        this.form.amount = "";
        this.form.betTypeId = "";
        this.pickedBet = "";
        (this.pickBetName = this.$t("app.pick_bet")), this.$v.form.$reset();
        this.formSubmitting = false;

        if (response.data.status == 1) {
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
            this.$alert(response.data.message, this.$t('app.error'), {
              confirmButtonText: "OK",
              type: "error",
              center: true,
            });
          }
        }
      });

      return true;
    },
  },
  mounted() {
    this.$nextTick(function () {
      this.getBetType();
      this.getBetType("number");
    });

    let betOptionsData = this.gameData.game_room.bet_options.split(",");
    if (betOptionsData) {
      let betOptions = betOptionsData.map((v, i) => {
        return { value: v };
      });
      this.selectAmounts = betOptions;
    }
  },

  watch: {
    betDisabled: function (newVal, oldVal) {
      // watch it
    },
    gameId: function (newVal, oldVal) {
      // watch it
    },
  },

  computed: {
    getMinBet() {
      return this.minBet ? this.minBet : 0;
    },
  },
};
</script>

<style scoped>
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
  margin: -15px;
  height: 90px;
  display: flex;
  justify-content: center;
  align-items: center;
}


</style>

<style>
.demo-form-inline .el-form-item__label {
  color: #aaa !important;
}
</style>