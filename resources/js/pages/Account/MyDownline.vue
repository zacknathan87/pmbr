<template>
  <div class="page-content">
    <div
      class="loader"
      v-if="loading"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div v-if="!loading">
      <!-- Header Section -->
      <div class="downline-header">
        <div class="header-card">
          <div class="header-content">
            <h1 class="header-title">My Network</h1>
            <p class="header-subtitle">Manage your referral network and downline members</p>
            <div class="header-actions">
              <router-link to="/account" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Referral Link Section -->
      <div class="referral-container">
        <div class="referral-card">
          <div class="referral-content">
            <div class="referral-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="referral-info">
              <h3 class="referral-title">Your Referral Link</h3>
              <p class="referral-text">{{ referralLink }}</p>
            </div>
            <div class="referral-action">
              <button class="copy-button" @click="copyLink">
                <i class="fas fa-copy"></i>
                Copy Link
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Downline List -->
      <div class="downline-container">
        <div class="downline-card">
          <div v-if="fetching" class="loading-state">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Please Wait...</p>
          </div>
          <div v-else-if="downline.length === 0" class="empty-state">
            <i class="fas fa-users"></i>
            <h3>No Network Members</h3>
            <p>Share your referral link to start building your network</p>
          </div>
          <div v-else class="downline-list">
            <div v-for="(item, key) in downline" :key="key" class="downline-item">
              <div class="downline-header">
                <div class="user-info">
                  <div class="user-avatar">
                    <i class="fas fa-user"></i>
                  </div>
                  <div class="user-details">
                    <h4 class="username">{{ item.username }}</h4>
                    <span class="join-date">{{ formatDate(item.created_at) }}</span>
                  </div>
                </div>
              </div>
              <div class="downline-stats">
                <div class="stat-group">
                  <div class="stat-item">
                    <span class="stat-label">{{ $t("app.today_bets") }}</span>
                    <span class="stat-value">{{ item.today_bet }}</span>
                  </div>
                  <div class="stat-item">
                    <span class="stat-label">{{ $t("app.today_win") }}</span>
                    <span class="stat-value">{{ item.today_win }}</span>
                  </div>
                </div>
                <div class="stat-group">
                  <div class="stat-item">
                    <span class="stat-label">{{ $t("app.total_bets") }}</span>
                    <span class="stat-value">{{ item.total_bet }}</span>
                  </div>
                  <div class="stat-item">
                    <span class="stat-label">{{ $t("app.total_win") }}</span>
                    <span class="stat-value">{{ item.total_winning }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
      referralLink: "",

      page: 1,
      downline: [],
    };
  },
  created() {},
  methods: {
    formatDate(d) {
      return moment(d).format("DD-MM-YYYY hh:mm A");
    },
    getDownline(loadMore = false) {
      this.fetching = true;
      if (!loadMore) {
        this.page = 1;
      }
      return axios
        .get("/account/downline", {
          params: {
            page: this.page,
          },
        })
        .then((response) => {
          console.log("here", response);
          if (!loadMore) {
            this.downline = response.data.data.data;
          } else {
            this.downline = this.downline.concat(response.data.data.data);
          }
          this.fetching = false;
          return response.data.data;
        });
    },
    async onRefresh(done) {
      await this.getDownline().then(done());
    },
    async onLoadMore(done) {
      this.page += 1;
      await this.getDownline(true).then((res) => {
        if (res.data.length > 0) {
          done(false);
        } else {
          done(true);
        }
      });
    },
     copyLink() {
      this.$copyText(this.referralLink).then(
        this.$message({
          type: "success",
          message: "Copied link",
        })
      );
    },
  },
  mounted() {
    this.getDownline();

    this.referralLink =
      process.env.MIX_APP_URL + "/register/" + this.$auth.user().username;
    this.loading = false;
  },
};
</script>

<style scoped>
/* Page Background */
.page-content {
  min-height: 100vh;
  background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
  padding: 20px;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Header Section */
.downline-header {
  margin-bottom: 24px;
  max-width: 1000px;
  margin-left: auto;
  margin-right: auto;
}

.header-card {
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(20px);
  border-radius: 16px;
  padding: 32px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.header-content {
  text-align: center;
}

.header-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #333333;
  margin: 0 0 8px 0;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header-subtitle {
  font-size: 1.1rem;
  color: #666666;
  margin: 0 0 20px 0;
  opacity: 0.9;
}

.header-actions {
  display: flex;
  justify-content: center;
}

.back-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  background: rgba(1, 168, 158, 0.1);
  border: 1px solid rgba(1, 168, 158, 0.3);
  border-radius: 12px;
  color: #01A89E;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
}

.back-button:hover {
  background: rgba(1, 168, 158, 0.2);
  border-color: #01A89E;
  transform: translateY(-2px);
}

/* Referral Section */
.referral-container {
  margin-bottom: 24px;
  max-width: 1000px;
  margin-left: auto;
  margin-right: auto;
}

.referral-card {
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(20px);
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.referral-content {
  display: flex;
  align-items: center;
  gap: 16px;
}

.referral-icon {
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  border-radius: 12px;
  padding: 16px;
  color: #ffffff;
  font-size: 1.5rem;
  flex-shrink: 0;
}

.referral-info {
  flex: 1;
}

.referral-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #01A89E;
  margin: 0 0 4px 0;
}

.referral-text {
  font-size: 0.9rem;
  color: #666666;
  margin: 0;
  word-break: break-all;
}

.referral-action {
  flex-shrink: 0;
}

.copy-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 20px;
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  border: none;
  border-radius: 12px;
  color: #ffffff;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 0.9rem;
}

.copy-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(1, 168, 158, 0.3);
}

.copy-button:active {
  transform: translateY(0);
}

/* Downline List */
.downline-container {
  max-width: 1000px;
  margin: 0 auto;
}

.downline-card {
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(20px);
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.loading-state,
.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #666666;
}

.loading-state i {
  font-size: 2rem;
  color: #01A89E;
  margin-bottom: 16px;
  animation: spin 1s linear infinite;
}

.empty-state i {
  font-size: 3rem;
  color: rgba(1, 168, 158, 0.3);
  margin-bottom: 16px;
}

.empty-state h3 {
  font-size: 1.5rem;
  margin: 0 0 8px 0;
  color: #333333;
}

.empty-state p {
  margin: 0;
  opacity: 0.8;
}

.downline-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.downline-item {
  background: rgba(255, 255, 255, 0.9);
  border: 1px solid rgba(0, 0, 0, 0.05);
  border-radius: 12px;
  padding: 20px;
  transition: all 0.3s ease;
}

.downline-item:hover {
  background: rgba(255, 255, 255, 0.95);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(1, 168, 158, 0.1);
}

.downline-item .downline-header {
  display: flex;
  align-items: center;
  margin-bottom: 16px;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-avatar {
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  border-radius: 50%;
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-size: 1.25rem;
  flex-shrink: 0;
}

.user-details {
  flex: 1;
}

.username {
  font-size: 1.1rem;
  font-weight: 600;
  color: #01A89E;
  margin: 0 0 4px 0;
}

.join-date {
  font-size: 0.85rem;
  color: #666666;
  opacity: 0.8;
}

.downline-stats {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.stat-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.stat-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.stat-label {
  font-size: 0.85rem;
  color: #666666;
  font-weight: 500;
}

.stat-value {
  font-size: 0.95rem;
  color: #333333;
  font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
  .page-content {
    padding: 16px;
  }

  .header-card {
    padding: 24px;
  }

  .header-title {
    font-size: 2rem;
  }

  .referral-content {
    flex-direction: column;
    text-align: center;
    gap: 12px;
  }

  .downline-stats {
    grid-template-columns: 1fr;
    gap: 12px;
  }

  .stat-group {
    flex-direction: row;
    justify-content: space-between;
  }

  .stat-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 4px;
  }
}

@media (max-width: 480px) {
  .header-title {
    font-size: 1.8rem;
  }

  .referral-card,
  .downline-card {
    padding: 16px;
  }

  .downline-item {
    padding: 16px;
  }

  .user-avatar {
    width: 40px;
    height: 40px;
    font-size: 1rem;
  }

  .username {
    font-size: 1rem;
  }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Loading State */
.loader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
}
</style>
