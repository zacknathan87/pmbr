<template>
  <el-header class="top-bar">
    <div class="app-container">
      <div style="display: contents; align-items: center">
        <a class="back-link" @click="$router.go(-1)"
          ><i class="fas fa-chevron-left"></i
        ></a>

        <div class="game-title" v-if="this.gameTitle" style="flex-grow: 1">
          {{ this.gameTitle }}
        </div>

        <div class="balance">{{ this.$auth.user().country.currency }} {{ this.$auth.user().wallet.balance }}</div>
        <div class="my-bets" @click="showMyBets" v-if="this.gameData">
          <i class="fas fa-list"></i>
        </div>
      </div>

      <el-dialog
        :append-to-body="true"
        :title="$t('app.my_trades')"
        :visible.sync="dialogVisible"
        width="90%"
        style="max-width: 640px; margin: 0 auto"
      >
        <div v-if="!loading" style="position: relative; height: 100%">
      <div>
        <div v-if="fetching" class="fetching">Please Wait...</div>
        <div v-if="!fetching">
          <div v-if="history.length === 0" class="fetching">No Data</div>
          <div v-for="(item, key) in history" :key="key" class="result-row">
            <el-row type="flex" align="middle">
              <el-col :span="12">
                <small class="channel-label"
                  >{{ $t("app." + item.game.game_type.name_code) }} /
                  {{ $t("app." + item.game.game_channel.name_code) }}</small
                >
                <div>{{ $t("app.game_id") }}: #{{ item.game_id }}</div>
                <div>{{ item.game.start_at }}</div>
              </el-col>
              <el-col :span="4">
                <el-tag
                  v-if="item.is_win === 1"
                  size="small"
                  type="success"
                  effect="dark"
                  >{{ $t("app.win") }}</el-tag
                >
                  <el-tag
                  v-if="item.is_win === 0 && item.game.status_id === 4"
                  size="small"
                  type="warning"
                  effect="dark"
                  >{{ $t("app.loss") }}</el-tag
                >
              </el-col>
              <el-col :span="8">
                <div class="result-body">
                  <div>
                    <i class="fas fa-coins"></i>
                    {{ item.amount }}
                  </div>
                  <div>
                    <span v-if="[2,3,4].includes(item.game_type_id) && item.bet_ref.split('_')[0] === 'num'" :class="'mini-ball ball-'+item.bet_ref.split('_')[1]"></span>
                    <span v-if="item.bet_ref != 'jackpot'"
                      ><span style="font-size: 13px"
                        >{{ $t("app.bet_on") }}:</span
                      >
                      {{ $t("app." + item.bet_type.name_code) }}</span
                    >
                    <span v-else>
                       {{ item.bet_no }}
                    </span>
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

        <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="dialogVisible = false">{{
            $t("app.ok")
          }}</el-button>
        </span>
      </el-dialog>
    </div>
  </el-header>
</template>

<script>

export default {
  props: ["gameData", "gameTitle"],
  data() {
    return {
      dialogVisible: false,
      balance: "0",
      appName: process.env.MIX_APP_NAME,

   
      loading: false,
      fetching: true,
      currentPage: 1,
      pageSize: 10,
      history: [],
      pagination: {},
    };
  },
  mounted() {},
  methods: {
    showMyBets() {
      this.dialogVisible = true;

      this.getResult(1)
    },
    changePage(v) {
      this.currentPage = v
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
  }
};
</script>

<style scoped>
/* Page Header - Corporate Theme */
.top-bar {
  background: #ffffff;
  border-bottom: 1px solid #e9ecef;
  color: #333333;
  display: flex;
  align-items: center;
  height: 70px !important;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.app-container {
  width: 100%;
  padding: 0 20px;
}

/* Header Layout */
.top-bar > div {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

/* Back Link */
.back-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  color: #00A3E0;
  font-size: 1.2rem;
  transition: all 0.3s ease;
  cursor: pointer;
  margin-right: 10px;
}

.back-link:hover {
  background: #e9ecef;
  border-color: #00A3E0;
  transform: translateY(-2px);
}

/* Game Title */
.game-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #00A3E0;
  margin: 0 20px;
  flex: 1;
  text-align: center;
}

/* Balance Display */
.balance {
  background: linear-gradient(135deg, #00A3E0 0%, #0077b6 100%);
  color: #ffffff;
  font-size: 1.1rem;
  font-weight: 700;
  border-radius: 8px;
  padding: 12px 20px;
  box-shadow: 0 2px 8px rgba(0, 163, 224, 0.2);
  margin-right: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.balance::before {
  content: "\f3d1"; /* fa-wallet */
  font-family: "Font Awesome 5 Free";
  font-weight: 900;
}

/* My Bets Button */
.my-bets {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
  border: none;
  border-radius: 8px;
  color: #ffffff;
  font-size: 1.2rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
}

.my-bets:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(40, 167, 69, 0.3);
}

/* Dialog Styles - Clean Corporate */
.el-dialog {
  background: #ffffff !important;
  border: 1px solid #e9ecef !important;
  border-radius: 12px !important;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
  overflow: hidden !important;
}

.el-dialog__wrapper {
  background: rgba(0, 0, 0, 0.5) !important;
}

.el-dialog__header {
  background: #f8f9fa !important;
  border-bottom: 1px solid #e9ecef !important;
  padding: 24px 24px 16px !important;
}

.el-dialog__title {
  color: #00A3E0 !important;
  font-weight: 700 !important;
  font-size: 1.5rem !important;
}

.el-dialog__body {
  padding: 24px !important;
  color: #333333 !important;
  background: #ffffff !important;
}

.el-dialog__footer {
  border-top: 1px solid #e9ecef !important;
  padding: 16px 24px 24px !important;
  background: #f8f9fa !important;
}

/* Result Rows - Clean Corporate */
.result-row {
  background: #ffffff;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 16px;
  margin-bottom: 12px;
  transition: all 0.3s ease-in-out;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.result-row:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0, 163, 224, 0.1);
  border-color: #00A3E0;
}

.channel-label {
  color: #666666;
  font-size: 0.85rem;
  margin-bottom: 4px;
}

.result-row div {
  color: #333333;
  font-size: 0.9rem;
  margin-bottom: 2px;
}

/* Status Tags */
.el-tag--success {
  background: #28a745;
  border-color: #28a745;
  color: #ffffff;
  font-weight: 600;
}

.el-tag--warning {
  background: #ffc107;
  border-color: #ffc107;
  color: #212529;
  font-weight: 600;
}

/* Mini Balls */
.mini-ball {
  display: inline-block;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  text-align: center;
  color: white;
  font-weight: bold;
  font-size: 12px;
  line-height: 20px;
  margin-right: 4px;
}

.ball-1 { background: #ff6b6b; }
.ball-2 { background: #4ecdc4; }
.ball-3 { background: #45b7d1; }
.ball-4 { background: #f9ca24; }
.ball-5 { background: #f0932b; }

/* Pagination */
.el-pagination {
  background: transparent;
}

.el-pagination .el-pager li {
  background: #ffffff;
  border: 1px solid #e9ecef;
  color: #666666;
}

.el-pagination .el-pager li:hover {
  color: #00A3E0;
}

.el-pagination .el-pager li.active {
  background: linear-gradient(135deg, #00A3E0 0%, #0077b6 100%);
  border-color: #00A3E0;
  color: #ffffff;
}

.el-pagination .btn-prev,
.el-pagination .btn-next {
  background: #ffffff;
  border: 1px solid #e9ecef;
  color: #666666;
}

.el-pagination .btn-prev:hover,
.el-pagination .btn-next:hover {
  color: #00A3E0;
}

/* Dialog Footer Button - Clean Corporate */
.el-dialog__footer .el-button--primary {
  background: linear-gradient(135deg, #00A3E0 0%, #0077b6 100%);
  border: none;
  border-radius: 8px;
  padding: 12px 24px;
  font-weight: 600;
  color: #ffffff;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 163, 224, 0.2);
}

.el-dialog__footer .el-button--primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0, 163, 224, 0.3);
}

/* Loading State - Clean Corporate */
.fetching {
  text-align: center;
  padding: 40px 20px;
  color: #666666;
  position: relative;
}

.fetching::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 40px;
  height: 40px;
  border: 3px solid #e9ecef;
  border-top: 3px solid #00A3E0;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: translate(-50%, -50%) rotate(0deg); }
  100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
  .top-bar {
    height: 60px !important;
  }

  .app-container {
    padding: 0 16px;
  }

  .game-title {
    font-size: 1.1rem;
    margin: 0 12px;
  }

  .balance {
    font-size: 1rem;
    padding: 10px 16px;
    margin-right: 12px;
  }

  .back-link,
  .my-bets {
    width: 44px;
    height: 44px;
    font-size: 1.1rem;
  }
}

@media (max-width: 480px) {
  .game-title {
    font-size: 1rem;
  }

  .balance {
    font-size: 0.9rem;
    padding: 8px 12px;
  }
}
</style>