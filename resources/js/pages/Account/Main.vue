<template>
  <div class="page-content">
    <div
      class="loader"
      v-if="loading"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div v-if="!loading" style="position: relative; height: 100%">
      <!-- Welcome Header -->
      <div class="account-header">
        <div class="welcome-card">
          <div class="welcome-content">
            <h1 class="welcome-title">Welcome back, {{ this.$auth.user().name }}</h1>
            <p class="welcome-subtitle">Manage your investment portfolio and track your performance</p>
            <div class="user-status">
              <div class="status-indicator">
                <div class="status-dot"></div>
                <span>Account Active</span>
              </div>
            </div>
          </div>
          <div class="welcome-avatar">
            <div class="avatar-circle">
              <i class="fas fa-user"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Account Overview -->
      <div class="account-overview">
        <div class="overview-card">
          <div class="card-icon">
            <i class="fas fa-wallet"></i>
          </div>
          <div class="card-content">
            <h3>Portfolio Balance</h3>
            <div class="balance-amount">
              {{ this.$auth.user().country.currency }}{{ this.$auth.user().wallet.balance }}
            </div>
            <p class="card-description">Available for investment</p>
          </div>
        </div>

        <div class="overview-card">
          <div class="card-icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="card-content">
            <h3>Total Investments</h3>
            <div class="balance-amount">
              {{ this.$auth.user().country.currency }}{{ this.$auth.user().total_bets }}
            </div>
            <p class="card-description">Lifetime investment amount</p>
          </div>
        </div>

        <div class="overview-card">
          <div class="card-icon">
            <i class="fas fa-user"></i>
          </div>
          <div class="card-content">
            <h3>Account Details</h3>
            <div class="account-info">
              <div class="info-item">
                <span class="info-label">Username:</span>
                <span class="info-value">{{ this.$auth.user().username }}</span>
              </div>
              <div class="info-item">
                <span class="info-label">Member ID:</span>
                <span class="info-value">#{{ this.$auth.user().id }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- <div class="referral-box">
        <div class="referral-link">{{ referralLink }}</div>
        <div class="referral-copy" @click="copyLink">
          <i class="lni lni-link"></i> {{ $t("app.copy") }}
        </div>
      </div> -->

      <!-- Account Actions -->
      <div class="account-actions">
        <div class="actions-grid">
          <router-link class="action-card" to="/my-trades">
            <div class="action-icon">
              <i class="fas fa-history"></i>
            </div>
            <div class="action-content">
              <h4>Investment History</h4>
              <p>View all your investment records</p>
            </div>
          </router-link>

          <router-link class="action-card" to="/result">
            <div class="action-icon">
              <i class="fas fa-chart-bar"></i>
            </div>
            <div class="action-content">
              <h4>Performance Results</h4>
              <p>Check your investment outcomes</p>
            </div>
          </router-link>

          <router-link class="action-card" to="/my-downline">
            <div class="action-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="action-content">
              <h4>Network</h4>
              <p>Manage your referral network</p>
            </div>
          </router-link>

          <router-link class="action-card" to="/account/rank_bonus">
            <div class="action-icon">
              <i class="fas fa-trophy"></i>
            </div>
            <div class="action-content">
              <h4>Rank Bonuses</h4>
              <p>View your achievement rewards</p>
            </div>
          </router-link>

          <router-link class="action-card" to="/account/edit_profile">
            <div class="action-icon">
              <i class="fas fa-user-edit"></i>
            </div>
            <div class="action-content">
              <h4>Edit Profile</h4>
              <p>Update your account information</p>
            </div>
          </router-link>

          <router-link class="action-card" to="/account/change_password">
            <div class="action-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <div class="action-content">
              <h4>Security</h4>
              <p>Change password and security settings</p>
            </div>
          </router-link>
        </div>
      </div>

      <div class="logout-btn" @click="openLogout()">
        <i class="lni lni-exit"></i>
        {{ $t("app.logout") }}
      </div>
    </div>
  </div>
</template>


<script>
import Avatar from "vue-avatar";
export default {
  components: {
    Avatar,
  },
  data() {
    return {
      user: {},
      referralLink: "",
      version: process.env.MIX_APP_VERSION || "v1",

      loading: true,
    };
  },
  created() {},
  methods: {
    openLogout() {
      this.$confirm(this.$t("app.confirm_logout"), this.$t("app.info"), {
        confirmButtonText: "OK",
        cancelButtonText: this.$t("app.cancel"),
        type: "warning",
      })
        .then(() => {
          this.logout();
        })
        .catch(() => {});
    },
    logout() {
      this.$auth.logout();
    },
    async getUser() {
      this.user = await this.$auth.fetch();
      return true;
    },
    onRefresh(done) {
      this.getUser().then(done());
    },
    addToHome() {
      installPromptEvent.prompt();
    },
    copyLink() {
      this.$copyText(this.referralLink).then(
        this.$message({
          type: "success",
          message: "Copied link",
        })
      );
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
    // this.open();
    this.checkUser();
    this.getUser();

    this.referralLink =
      process.env.MIX_APP_URL + "/register/" + this.$auth.user().username;
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

/* Account Header */
.account-header {
  margin-bottom: 3rem;
  padding: 2rem 0;
}

.welcome-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 3rem;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 20px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.welcome-content {
  flex: 1;
}

.welcome-title {
  font-size: 2.5rem;
  font-weight: 800;
  color: #333333;
  margin-bottom: 0.5rem;
  line-height: 1.1;
}

.welcome-subtitle {
  color: #666666;
  font-size: 1.1rem;
  margin-bottom: 1.5rem;
  line-height: 1.5;
}

.user-status {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.status-indicator {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  background: rgba(40, 167, 69, 0.1);
  border: 1px solid rgba(40, 167, 69, 0.3);
  border-radius: 20px;
  font-size: 0.9rem;
  color: #28a745;
  font-weight: 500;
}

.status-dot {
  width: 8px;
  height: 8px;
  background: #28a745;
  border-radius: 50%;
  box-shadow: 0 0 10px #28a745;
}

.welcome-avatar {
  flex-shrink: 0;
  margin-left: 2rem;
}

.avatar-circle {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  color: #ffffff;
  box-shadow: 0 0 30px rgba(1, 168, 158, 0.3);
}

/* Account Overview */
.account-overview {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  margin-bottom: 3rem;
}

.overview-card {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding: 2rem;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 20px;
  transition: all 0.3s ease;
}

.overview-card:hover {
  transform: translateY(-5px);
  border-color: rgba(1, 168, 158, 0.3);
  box-shadow: 0 10px 30px rgba(1, 168, 158, 0.2);
}

.card-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  box-shadow: 0 0 20px rgba(1, 168, 158, 0.3);
  flex-shrink: 0;
}

.card-content h3 {
  color: #333333;
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.card-content p {
  color: #666666;
  font-size: 0.95rem;
  line-height: 1.5;
  margin: 0;
}

.balance-amount {
  font-size: 1.5rem;
  font-weight: 800;
  color: #28a745;
  margin-bottom: 0.25rem;
}

.account-info {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.info-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.info-label {
  color: #666666;
  font-size: 0.9rem;
}

.info-value {
  color: #333333;
  font-weight: 500;
}

/* Account Actions */
.account-actions {
  margin-bottom: 3rem;
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.action-card {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding: 2rem;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 20px;
  text-decoration: none;
  color: inherit;
  transition: all 0.3s ease;
}

.action-card:hover {
  transform: translateY(-5px);
  border-color: rgba(1, 168, 158, 0.3);
  box-shadow: 0 10px 30px rgba(1, 168, 158, 0.2);
}

.action-icon {
  width: 50px;
  height: 50px;
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  box-shadow: 0 0 20px rgba(1, 168, 158, 0.3);
  flex-shrink: 0;
}

.action-content h4 {
  color: #333333;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.action-content p {
  color: #666666;
  font-size: 0.9rem;
  margin: 0;
}

/* Logout Button */
.logout-btn {
  width: 100%;
  padding: 1rem 2rem;
  background: rgba(220, 53, 69, 0.1);
  border: 1px solid rgba(220, 53, 69, 0.3);
  border-radius: 20px;
  color: #dc3545;
  font-weight: 600;
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  margin-bottom: 3rem;
}

.logout-btn:hover {
  background: rgba(220, 53, 69, 0.2);
  color: #c82333;
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
}

.logout-btn i {
  font-size: 1.1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .page-content {
    padding: 0 0.5rem;
  }

  .welcome-card {
    flex-direction: column;
    text-align: center;
    gap: 2rem;
    padding: 2rem;
  }

  .welcome-title {
    font-size: 2rem;
  }

  .welcome-avatar {
    margin-left: 0;
  }

  .avatar-circle {
    width: 70px;
    height: 70px;
    font-size: 1.75rem;
  }

  .account-overview {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }

  .actions-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }

  .overview-card,
  .action-card {
    padding: 1.5rem;
  }

  .card-icon,
  .action-icon {
    width: 50px;
    height: 50px;
    font-size: 1.25rem;
  }
}
</style>