<template>
  <div class="page-content">
    <div
      class="loader"
      v-if="loading"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div class="page-title">{{ $t("app.result") }}</div>

    <el-select
      @change="onChangeGameType"
      v-model="gameTypeId"
      placeholder="Select Game"
    >
      <el-option
        v-for="item in gameType"
        :key="item.name_code"
        :label="$t('app.' + item.name_code)"
        :value="item.id"
      ></el-option>
    </el-select>

    <el-divider></el-divider>

    <div v-if="!loading" style="position: relative; height: 100%">
      <EasyRefresh
        :userSelect="false"
        :onRefresh="onRefresh"
        :loadMore="onLoadMore"
      >
        <div>
          <div class="result-header">
            <el-row :gutter="20" class="mb-3">
              <el-col :span="12">
                <el-select
                  @change="onChange"
                  v-model="gameChannelId"
                  placeholder="Select Channel"
                >
                  <el-option
                    v-for="item in gameChannel"
                    :key="item.name_code"
                    :label="$t('app.' + item.name_code)"
                    :value="item.id"
                  ></el-option>
                </el-select>
              </el-col>
              <el-col :span="12">
                <el-select
                  @change="onChange"
                  v-model="gameRoomId"
                  placeholder="Select Hall"
                >
                  <el-option
                    v-for="item in gameHall"
                    :key="item.name_code"
                    :label="$t('app.' + item.name_code)"
                    :value="item.id"
                  ></el-option>
                </el-select>
              </el-col>
            </el-row>
            <el-row :gutter="20">
              <el-col :span="12">
                <div>
                  <el-date-picker
                    @change="onChangeDate"
                    style="width: 100%"
                    :picker-options="datePickerOptions"
                    v-model="date"
                    type="date"
                    placeholder="Pick a day"
                    align="right"
                    format="dd-MM-yyyy"
                  ></el-date-picker>
                </div>
              </el-col>
            </el-row>
          </div>

          <div v-if="fetching" class="fetching">Please Wait...</div>
          <div v-if="!fetching">
            <div v-if="history.length === 0" class="fetching">No Data</div>
            <div v-for="(item, key) in history" :key="key" class="result-row">
              <el-row>
                <el-col :span="12">
                  <div>{{ $t("app.game_id") }}: #{{ item.id }}</div>
                  <div>{{ item.start_at }}</div>
                </el-col>
                <el-col :span="12">
                  <div class="result-body">
                    <div class="dice">{{ item.no.split(",")[0] }}</div>
                    <span>+</span>
                    <div class="dice">{{ item.no.split(",")[1] }}</div>
                    <span>+</span>
                    <div class="dice">{{ item.no.split(",")[2] }}</div>
                    <span>=</span>
                    <div class="final-no">{{ item.result_no }}</div>
                  </div>
                </el-col>
              </el-row>
            </div>
          </div>
        </div>
      </EasyRefresh>
    </div>
  </div>
</template>


<script>
import moment from "moment";

export default {
  data() {
    return {
      loading: true,
      fetching: true,

      datePickerOptions: {
        disabledDate(date) {
          return date > new Date();
        },
      },

      gameType: [],
      gameChannel: [],
      gameHall: [],
      gameChannelId: 1,
      gameRoomId: 1,
      gameTypeId: 1,
      page: 1,
      history: [],

      date: new Date(),
    };
  },
  created() {},
  methods: {
    getGameType() {
      axios.get("/misc/gameType").then((response) => {
        this.gameType = response.data.data;

        this.loading = false;
      });
    },
    getGameHall() {
      axios.get("/misc/gameHall").then((response) => {
        this.gameHall = response.data.data;

        this.loading = false;
      });
    },
    getGameChannel() {
      axios.get("/misc/gameChannel").then((response) => {
        this.gameChannel = response.data.data;

        this.loading = false;
      });
    },
    getResult(loadMore = false) {
      this.fetching = true;
      if (!loadMore) {
        this.page = 1;
      }
      return axios
        .get("/result", {
          params: {
            game_channel_id: this.gameChannelId,
            date: this.date,
            page: this.page,
          },
        })
        .then((response) => {
          if (!loadMore) {
            this.history = response.data.data.data;
          } else {
            this.history = this.history.concat(response.data.data.data);
          }

          console.log(this.history);
          this.fetching = false;
          return response.data.data;
        });
    },
    async onRefresh(done) {
      await this.getResult().then(done());
    },
    async onLoadMore(done) {
      this.page += 1;
      await this.getResult(true).then((res) => {
        if (res.data.length > 0) {
          done(false);
        } else {
          done(true);
        }
      });
    },
    onChange(v) {
      this.getResult();
    },
    onChangeDate(v) {
      this.getResult();
    },
    onChangeGameType(v) {

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
    this.getGameType();
    this.getGameChannel();
    this.getGameHall();

    this.getResult();
  },
};
</script>

<style scoped>
.page-content {
  min-height: 100%;
  height: 100%;
}
.result-header {
  background: #fff;
  padding: 15px;
  flex-wrap: wrap;
  margin-bottom: 15px;
}

/* .result-header > div {
  margin-right: 10px;
  flex: 1;
}

.result-header > div:last-child {
  margin-right: 0;
} */

.el-date-editor.el-input,
.el-date-editor.el-input__inner {
  width: auto;
}

.el-select {
  width: 100%;
}

.result-row {
  padding: 15px;
  border-bottom: 1px solid #eee;
  background: #fff;
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

.fetching {
  text-align: center;
  padding: 15px;
}
</style>
