<template>
  <div>
    <div class="result-title">{{ $t("app." + this.gameNameCode) }}</div>

    <div v-if="!loading" class="results-section">
      <div class="results-filters">
        <div class="filter-card">
          <div class="filter-row">
            <div class="filter-group">
              <label class="filter-label">Market Channel</label>
              <el-select
                @change="onChange"
                v-model="gameChannelId"
                placeholder="Select trading channel"
                class="filter-select"
              >
                <el-option
                  v-for="item in gameChannel"
                  :key="item.name_code"
                  :label="$t('app.' + item.name_code)"
                  :value="item.id"
                />
              </el-select>
            </div>
            <div class="filter-group">
              <label class="filter-label">Date</label>
              <el-date-picker
                @change="onChangeDate"
                class="filter-date"
                :picker-options="datePickerOptions"
                v-model="date"
                type="date"
                placeholder="Select date"
                align="right"
                format="dd-MM-yyyy"
              />
            </div>
          </div>
        </div>
      </div>

        <div v-if="fetching" class="loading-state">
          <div class="loading-spinner"></div>
          <p>Loading market results...</p>
        </div>

        <div v-else-if="history.length === 0" class="empty-state">
          <div class="empty-icon">
            <i class="fas fa-chart-bar"></i>
          </div>
          <h3>No Results Found</h3>
          <p>No trading results available for the selected date and market.</p>
        </div>

        <div v-else class="results-list">
          <div class="results-pagination">
            <el-pagination
              background
              layout="prev, pager, next"
              :page-size="pageSize"
              :current-page="currentPage"
              :total="pagination.total"
              @current-change="changePage"
              class="custom-pagination"
            />
          </div>

          <div v-for="(item, key) in history" :key="key" class="result-card">
            <div class="result-header">
              <div class="result-info">
                <div class="trade-id">Trade ID: #{{ item.id }}</div>
                <div class="trade-time">{{ formatDate(item.start_at) }}</div>
              </div>
              <div class="result-status">
                <div class="status-indicator completed">
                  <i class="fas fa-check-circle"></i>
                  Completed
                </div>
              </div>
            </div>

            <div class="result-content">
              <div class="dice-results">
                <div class="dice-sequence">
                  <div class="dice-item">{{ item.no.split(",")[0] }}</div>
                  <div class="operator">+</div>
                  <div class="dice-item">{{ item.no.split(",")[1] }}</div>
                  <div class="operator">+</div>
                  <div class="dice-item">{{ item.no.split(",")[2] }}</div>
                  <div class="operator">=</div>
                  <div class="total-result">{{ item.result_no }}</div>
                </div>
              </div>
            </div>
          </div>

          <div class="results-pagination">
            <el-pagination
              background
              layout="prev, pager, next"
              :page-size="pageSize"
              :current-page="currentPage"
              :total="pagination.total"
              @current-change="changePage"
              class="custom-pagination"
            />
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import moment from "moment";

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
    formatDate(date) {
      return moment(date).format('MMM DD, YYYY HH:mm');
    },
    changePage(v) {
      this.currentPage = v
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

<style scoped>
.results-section {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.results-filters {
  margin-bottom: 30px;
}

.filter-card {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.filter-row {
  display: flex;
  gap: 24px;
  flex-wrap: wrap;
  align-items: flex-end;
}

.filter-group {
  flex: 1;
  min-width: 200px;
}

.filter-label {
  display: block;
  color: #374151;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 8px;
  font-family: 'Inter', sans-serif;
}

.filter-select,
.filter-date {
  width: 100%;
}

.el-date-editor.el-input,
.el-date-editor.el-input__inner {
  width: 100% !important;
}

.el-select {
  width: 100%;
}

.loading-state,
.empty-state {
  text-align: center;
  padding: 60px 20px;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  margin: 20px 0;
}

.loading-spinner {
  width: 48px;
  height: 48px;
  border: 4px solid rgba(0, 212, 255, 0.3);
  border-top: 4px solid #00d4ff;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 16px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.empty-icon {
  font-size: 48px;
  color: #01a89e;
  margin-bottom: 16px;
}

.empty-state h3 {
  color: #111827;
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 8px;
  font-family: 'Inter', sans-serif;
}

.empty-state p {
  color: #6b7280;
  font-size: 16px;
  margin: 0;
  font-family: 'Inter', sans-serif;
}

.results-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.results-pagination {
  display: flex;
  justify-content: center;
  margin: 30px 0;
}

.custom-pagination {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 12px;
}

.result-card {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.result-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
}

.result-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 16px;
}

.result-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.trade-id {
  color: #01a89e;
  font-size: 16px;
  font-weight: 600;
  font-family: 'Inter', sans-serif;
}

.trade-time {
  color: #6b7280;
  font-size: 14px;
  font-family: 'Inter', sans-serif;
}

.result-status {
  display: flex;
  align-items: center;
}

.status-indicator.completed {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(0, 255, 136, 0.1);
  border: 1px solid #00ff88;
  color: #00ff88;
  padding: 8px 12px;
  border-radius: 20px;
  font-size: 14px;
  font-weight: 500;
  font-family: 'Inter', sans-serif;
}

.status-indicator.completed i {
  font-size: 12px;
}

.result-content {
  display: flex;
  justify-content: center;
  align-items: center;
}

.dice-results {
  text-align: center;
}

.dice-sequence {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 500;
}

.dice-item {
  background: linear-gradient(135deg, #00d4ff, #0099cc);
  color: #ffffff;
  width: 40px;
  height: 40px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(0, 212, 255, 0.3);
}

.operator {
  color: #374151;
  font-size: 20px;
  font-weight: 600;
}

.total-result {
  background: linear-gradient(135deg, #ffd700, #ffb347);
  color: #000000;
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 20px;
  box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
}
</style>