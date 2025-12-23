<template>
  <div class="page-content">
    <div
      class="loader"
      v-if="loading"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div class="bets-header">
      <div class="bets-hero">
        <div class="hero-content">
          <h1 class="hero-title">Transaction Reports</h1>
          <p class="hero-subtitle">Comprehensive investment transaction history and performance analytics</p>
          <div class="hero-stats">
            <div class="stat-item">
              <div class="stat-number">{{ pagination.total || 0 }}</div>
              <div class="stat-label">Total Transactions</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">{{ winCount }}</div>
              <div class="stat-label">Successful Trades</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">{{ this.$auth.user().country.currency }}{{ totalProfit.toFixed(2) }}</div>
              <div class="stat-label">Net Performance</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!loading" class="bets-content">
      <div class="bets-navigation">
        <router-link to="/account" class="back-button">
          <i class="fas fa-arrow-left"></i>
          Back to Dashboard
        </router-link>
      </div>

      <div v-if="fetching" class="loading-state">
        <div class="loading-spinner"></div>
        <p>Loading trading history...</p>
      </div>

      <div v-else-if="history.length === 0" class="empty-state">
        <div class="empty-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <h3>No Trading History</h3>
        <p>You haven't placed any trades yet. Start trading to see your performance here.</p>
        <router-link to="/trades" class="start-trading-btn">
          <i class="fas fa-play"></i>
          Start Trading
        </router-link>
      </div>

      <div v-else class="bets-list">
        <div v-for="(item, key) in history" :key="key" class="bet-card">
          <div class="bet-header">
            <div class="bet-info">
              <div class="market-info">
                <span class="market-name">{{ $t("app." + item.game.game_type.name_code) }}</span>
                <span class="market-divider">/</span>
                <span class="channel-name">{{ $t("app." + item.game.game_channel.name_code) }}</span>
              </div>
              <div class="game-id">Trade ID: #{{ item.game_id }}</div>
              <div class="game-time">{{ formatDate(item.game.start_at) }}</div>
            </div>
            <div class="bet-status">
              <div
                v-if="item.is_win === 1"
                class="status-badge win"
              >
                <i class="fas fa-check-circle"></i>
                Profit
              </div>
              <div
                v-else-if="item.is_win === 0 && item.game.status_id === 4"
                class="status-badge loss"
              >
                <i class="fas fa-times-circle"></i>
                Loss
              </div>
              <div
                v-else
                class="status-badge pending"
              >
                <i class="fas fa-clock"></i>
                Pending
              </div>
            </div>
          </div>

          <div class="bet-details">
            <div class="bet-amount">
              <div class="amount-label">Investment Amount</div>
              <div class="amount-value">{{ formatCurrency(item.amount) }}</div>
            </div>

            <div class="bet-selection">
              <div class="selection-label">Trading Position</div>
              <div class="selection-value">
                <span
                  v-if="[2, 3, 4].includes(item.game_type_id) && item.bet_ref.split('_')[0] === 'num'"
                  :class="'mini-ball ball-' + item.bet_ref.split('_')[1]"
                ></span>

                <span v-if="item.bet_ref != 'jackpot'">
                  {{ $t("app." + item.bet_type.name_code) }}
                </span>

                <div v-else class="jackpot-numbers">
                  <div class="number-grid">
                    <div
                      v-for="(num, index) in item.bet_no.split(',')"
                      :key="index"
                      class="number-ball"
                      :class="'ball-' + (index + 1)"
                    >
                      {{ num }}
                    </div>
                    <div class="plus-sign">+</div>
                    <div class="number-ball power-ball">
                      {{ item.bet_no.split(',')[6] }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="pagination-wrapper">
          <el-pagination
            background
            layout="prev, pager, next"
            :page-size="pageSize"
            :current-page="currentPage"
            :total="pagination.total"
            @current-change="changePage"
            class="custom-pagination"
          >
          </el-pagination>
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
      fetching: true,

      currentPage: 1,
      pageSize: 10,
      history: [],
      pagination: {},
    };
  },
  computed: {
    winCount() {
      return this.history.filter(item => item.is_win === 1).length;
    },
    totalProfit() {
      return this.history.reduce((total, item) => {
        if (item.is_win === 1) {
          // Assuming profit is amount * (odds - 1), but since we don't have odds here,
          // we'll just count wins vs losses for now
          return total + parseFloat(item.amount);
        }
        return total - parseFloat(item.amount);
      }, 0);
    }
  },
  created() {},
  methods: {
    changePage(v) {
      this.currentPage = v;
      this.getResult(v);
    },
    getResult(page = 1) {
      this.fetching = true;
      return axios
        .get("/my-trades", {
          params: {
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
    formatDate(date) {
      return moment(date).format('MMM DD, YYYY HH:mm');
    },
    formatCurrency(amount) {
      return 'RM ' + parseFloat(amount).toLocaleString('en-MY', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
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
    this.getResult();

    this.loading = false;
  },
};
</script>

<style scoped>
/* Page Layout */
.page-content {
  max-width: 800px;
  margin: 0 auto;
  padding: 0 1rem;
}

/* Header Section */
.bets-header {
  margin-bottom: 3rem;
  padding: 2rem 0;
}

.bets-hero {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 20px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.hero-content {
  padding: 3rem;
  text-align: center;
}

.hero-title {
  font-size: 2.5rem;
  font-weight: 800;
  color: #333333;
  margin-bottom: 0.5rem;
  line-height: 1.1;
}

.hero-subtitle {
  color: #666666;
  font-size: 1.1rem;
  margin-bottom: 2rem;
  line-height: 1.5;
}

.hero-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
  margin-top: 2rem;
}

.stat-item {
  padding: 2rem;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 20px;
  text-align: center;
  transition: all 0.3s ease;
}

.stat-item:hover {
  transform: translateY(-5px);
  border-color: rgba(1, 168, 158, 0.3);
  box-shadow: 0 10px 30px rgba(1, 168, 158, 0.2);
}

.stat-number {
  font-size: 2rem;
  font-weight: 800;
  color: #01A89E;
  margin-bottom: 0.5rem;
  display: block;
}

.stat-label {
  color: #666666;
  font-size: 1rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Content Section */
.bets-content {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.bets-navigation {
  margin-bottom: 2rem;
}

.back-button {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 1.5rem;
  background: rgba(1, 168, 158, 0.1);
  border: 1px solid rgba(1, 168, 158, 0.3);
  border-radius: 25px;
  color: #01A89E;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
}

.back-button:hover {
  background: rgba(1, 168, 158, 0.2);
  color: #017f7a;
  transform: translateX(-2px);
}

/* Loading and Empty States */
.loading-state,
.empty-state {
  text-align: center;
  padding: 4rem 2rem;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 3px solid rgba(0, 212, 255, 0.3);
  border-top: 3px solid #00d4ff;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 1rem;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.empty-icon {
  font-size: 4rem;
  color: #01A89E;
  margin-bottom: 1rem;
  opacity: 0.5;
}

.empty-state h3 {
  color: #333333;
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.empty-state p {
  color: #666666;
  margin-bottom: 2rem;
}

.start-trading-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem 2rem;
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  border: none;
  border-radius: 25px;
  color: #ffffff;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.start-trading-btn:hover {
  background: linear-gradient(135deg, #017f7a 0%, #01A89E 100%);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(1, 168, 158, 0.4);
}

/* Transaction Table */
.bets-list {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.bet-card {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(0, 0, 0, 0.05);
  border-radius: 8px;
  padding: 1.5rem;
  transition: all 0.3s ease;
}

.bet-card:hover {
  transform: translateY(-1px);
  border-color: rgba(1, 168, 158, 0.2);
  box-shadow: 0 2px 8px rgba(1, 168, 158, 0.1);
}

.bet-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1.5rem;
}

.bet-info {
  flex: 1;
}

.market-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
  color: #01A89E;
  font-weight: 600;
}

.market-name {
  background: rgba(1, 168, 158, 0.1);
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  border: 1px solid rgba(1, 168, 158, 0.2);
}

.market-divider {
  color: #666666;
}

.channel-name {
  background: rgba(40, 167, 69, 0.1);
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  border: 1px solid rgba(40, 167, 69, 0.2);
  color: #28a745;
}

.game-id {
  color: #333333;
  font-size: 0.9rem;
  margin-bottom: 0.25rem;
}

.game-time {
  color: #666666;
  font-size: 0.85rem;
}

.bet-status {
  margin-left: 1rem;
}

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.status-badge.win {
  background: rgba(0, 255, 136, 0.1);
  border: 1px solid rgba(0, 255, 136, 0.3);
  color: #00ff88;
}

.status-badge.loss {
  background: rgba(255, 68, 68, 0.1);
  border: 1px solid rgba(255, 68, 68, 0.3);
  color: #ff4444;
}

.status-badge.pending {
  background: rgba(255, 193, 7, 0.1);
  border: 1px solid rgba(255, 193, 7, 0.3);
  color: #ffc107;
}

.bet-details {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
}

.bet-amount,
.bet-selection {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.amount-label,
.selection-label {
  color: #666666;
  font-size: 0.9rem;
  font-weight: 500;
}

.amount-value {
  color: #333333;
  font-size: 1.25rem;
  font-weight: 700;
}

.selection-value {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: #333333;
  font-weight: 500;
}

/* Mini balls for regular games */
.mini-ball {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: bold;
  color: #ffffff;
  margin-right: 0.5rem;
}

.mini-ball.ball-0 { background: linear-gradient(135deg, #00d4ff, #0099cc); }
.mini-ball.ball-1 { background: linear-gradient(135deg, #ff6b6b, #cc3333); }
.mini-ball.ball-2 { background: linear-gradient(135deg, #4ecdc4, #26a69a); }
.mini-ball.ball-3 { background: linear-gradient(135deg, #45b7d1, #2980b9); }
.mini-ball.ball-4 { background: linear-gradient(135deg, #96ceb4, #4ecdc4); }
.mini-ball.ball-5 { background: linear-gradient(135deg, #feca57, #ff9ff3); }
.mini-ball.ball-6 { background: linear-gradient(135deg, #ff9ff3, #f368e0); }
.mini-ball.ball-7 { background: linear-gradient(135deg, #54a0ff, #2e86de); }
.mini-ball.ball-8 { background: linear-gradient(135deg, #5f27cd, #341f97); }
.mini-ball.ball-9 { background: linear-gradient(135deg, #00d2d3, #54a0ff); }

/* Jackpot numbers */
.jackpot-numbers {
  width: 100%;
}

.number-grid {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.number-ball {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
  font-weight: bold;
  color: #ffffff;
}

.number-ball.ball-1 { background: linear-gradient(135deg, #ff6b6b, #cc3333); }
.number-ball.ball-2 { background: linear-gradient(135deg, #4ecdc4, #26a69a); }
.number-ball.ball-3 { background: linear-gradient(135deg, #45b7d1, #2980b9); }
.number-ball.ball-4 { background: linear-gradient(135deg, #96ceb4, #4ecdc4); }
.number-ball.ball-5 { background: linear-gradient(135deg, #feca57, #ff9ff3); }
.number-ball.ball-6 { background: linear-gradient(135deg, #ff9ff3, #f368e0); }
.number-ball.ball-7 { background: linear-gradient(135deg, #54a0ff, #2e86de); }

.power-ball {
  background: linear-gradient(135deg, #ff6b6b, #cc3333) !important;
  width: 36px !important;
  height: 36px !important;
  font-size: 0.9rem !important;
}

.plus-sign {
  color: #b0b0b0;
  font-size: 1.25rem;
  font-weight: bold;
}

/* Pagination */
.pagination-wrapper {
  margin-top: 2rem;
  display: flex;
  justify-content: center;
}

.custom-pagination {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 12px;
  padding: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .page-content {
    padding: 0 0.5rem;
  }

  .hero-content {
    padding: 2rem;
  }

  .hero-title {
    font-size: 2rem;
  }

  .hero-stats {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }

  .bets-hero {
    margin: 0 -1rem;
  }

  .bets-content {
    margin: 0 -1rem;
    border-radius: 0;
    border-left: none;
    border-right: none;
  }

  .bet-header {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
  }

  .bet-status {
    margin-left: 0;
    align-self: flex-end;
  }

  .bet-details {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .number-grid {
    justify-content: center;
  }
}
</style>
