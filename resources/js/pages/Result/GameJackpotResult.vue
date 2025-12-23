<template>
  <div>
    <div class="result-title">{{ $t("app." + this.gameNameCode) }}</div>

    <div v-if="!loading" style="position: relative; height: 100%">
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
          <div v-else  class="result-box">
            <div style="padding: 15px; text-align: center">
              <el-pagination
                background
                layout="prev, pager, next"
                :page-size="this.pageSize"
                :current-page="this.currentPage"
                :total="this.pagination.total"
                @current-change="changePage"
              >
              </el-pagination>
            </div>
            <div v-for="(item, key) in history" :key="key" class="result-row">
              <el-row>
                <el-col :span="12" :xs="24">
                  <div>{{ $t("app.game_id") }}: #{{ item.id }}</div>
                  <div>{{ item.start_at }}</div>
                </el-col>
                <el-col :span="12" :xs="24">
                  <div class="result-body">
                    <div class="ball ball-1">
                      {{ item.no.split(",")[0] }}
                    </div>
                    <div class="ball ball-2">
                      {{ item.no.split(",")[1] }}
                    </div>
                    <div class="ball ball-3">
                      {{ item.no.split(",")[2] }}
                    </div>
                    <div class="ball ball-4">
                      {{ item.no.split(",")[3] }}
                    </div>
                    <div class="ball ball-5">
                      {{ item.no.split(",")[4] }}
                    </div>
                    <div class="ball ball-6">
                      {{ item.no.split(",")[5] }}
                    </div>
                    <span class="plus">+</span>
                    <div class="ball ball-7">
                      {{ item.no.split(",")[6] }}
                    </div>
                  </div>
                </el-col>
              </el-row>
            </div>
            <div style="padding: 15px; text-align: center">
              <el-pagination
                background
                layout="prev, pager, next"
                :page-size="this.pageSize"
                :current-page="this.currentPage"
                :total="this.pagination.total"
                @current-change="changePage"
              >
              </el-pagination>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    gameTypeId: {
      required: true,
    },
  },
  data() {
    return {
      loading: true,
      fetching: true,
      currentPage: 1,
      pageSize: 10,
      pagination: {},

      datePickerOptions: {
        disabledDate(date) {
          return date > new Date();
        },
      },

      gameNameCode: [],
      gameType: [],
      gameChannel: [],
      gameHall: [],
      gameChannelId: null,
      gameRoomId: null,
      page: 1,
      history: [],

      date: new Date(),
    };
  },
  created() {},
  methods: {
    changePage(v) {
      this.currentPage = v;
      this.getResult(v);
    },
    getGameChannel() {
      axios.get("/misc/gameChannel/" + this.gameTypeId).then((response) => {
        this.gameChannel = response.data.data;
        this.gameChannelId = this.gameChannel[0].id;
        this.gameNameCode = this.gameChannel[0].game_type.name_code;

        this.getResult();

        this.loading = false;
      });
    },
    getResult(page = 1) {
      this.fetching = true;
      return axios
        .get("/result", {
          params: {
            game_type_id: this.gameTypeId,
            game_channel_id: this.gameChannelId,
            date: this.date,
            page: page,
            limit: this.pageSize,
          },
        })
        .then((response) => {
          this.history = response.data.data.data;
          this.pagination = response.data.data;
          this.fetching = false;
          return response.data.data;
        });
    },
    async onRefresh(done) {
      await this.getResult().then(done());
    },
    onChange(v) {
      this.getResult();
    },
    onChangeDate(v) {
      this.getResult();
    },
    onChangeGameType(v) {},
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
    this.getGameChannel();
  },
};
</script>

<style>
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