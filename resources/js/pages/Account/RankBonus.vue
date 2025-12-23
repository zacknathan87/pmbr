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
      <div class="rank-header">
        <div class="header-card">
          <div class="header-content">
            <h1 class="header-title">{{ $t('app.rank_bonus') }}</h1>
            <p class="header-subtitle">View your VIP rank progression and bonus rewards</p>
            <div class="header-actions">
              <router-link to="/account" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Rank Table -->
      <div class="rank-container">
        <div class="rank-card">
          <div v-if="ranks.length === 0" class="empty-state">
            <i class="fas fa-trophy"></i>
            <h3>No Rank Data Available</h3>
            <p>Please check back later</p>
          </div>
          <div v-else class="rank-table-container">
            <div class="rank-table">
              <div class="rank-table-header">
                <div class="rank-cell vip-cell">{{ $t('app.vip') }}</div>
                <div class="rank-cell name-cell">{{ $t('app.name') }}</div>
                <div class="rank-cell amount-cell">{{ $t('app.amount') }}</div>
                <div class="rank-cell bonus-cell">{{ $t('app.bonus') }}</div>
                <div class="rank-cell skip-cell">{{ $t('app.skip_level_bonus') }}</div>
              </div>
              <div class="rank-table-body">
                <div v-for="(rank, index) in ranks" :key="index" class="rank-row">
                  <div class="rank-cell vip-cell">
                    <div class="vip-badge">{{ rank.name }}</div>
                  </div>
                  <div class="rank-cell name-cell">
                    <span class="level-name">{{ rank.level_name }}</span>
                  </div>
                  <div class="rank-cell amount-cell">
                    <span class="amount-value">{{ rank.amount }}</span>
                  </div>
                  <div class="rank-cell bonus-cell">
                    <span class="bonus-value">{{ rank.bonus }}</span>
                  </div>
                  <div class="rank-cell skip-cell">
                    <span class="skip-value">{{ rank.skip_level_bonus }}</span>
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
export default {
  data() {
    return {
      loading: true,

      ranks: []
    };
  },
  created() {},
  methods: {
    getRanks() {
      axios.get("/misc/ranks").then(response => {
        this.ranks = response.data.data;

        this.loading = false;
      });
    }
  },
  mounted() {
    // this.open();
    this.$nextTick(function() {
      this.getRanks();
    });
  }
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
.rank-header {
  margin-bottom: 24px;
  max-width: 1200px;
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

/* Rank Table */
.rank-container {
  max-width: 1200px;
  margin: 0 auto;
}

.rank-card {
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(20px);
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #666666;
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

.rank-table-container {
  overflow-x: auto;
}

.rank-table {
  min-width: 800px;
}

.rank-table-header {
  display: grid;
  grid-template-columns: 80px 1fr 1fr 1fr 1fr;
  gap: 16px;
  padding: 16px 0;
  border-bottom: 2px solid rgba(1, 168, 158, 0.3);
  margin-bottom: 8px;
}

.rank-cell {
  padding: 12px 16px;
  font-weight: 600;
  color: #01A89E;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.rank-table-body {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.rank-row {
  display: grid;
  grid-template-columns: 80px 1fr 1fr 1fr 1fr;
  gap: 16px;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 12px;
  padding: 16px;
  transition: all 0.3s ease;
  align-items: center;
  border: 1px solid rgba(0, 0, 0, 0.05);
}

.rank-row:hover {
  background: rgba(255, 255, 255, 0.95);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(1, 168, 158, 0.1);
}

.rank-row .rank-cell {
  padding: 8px 0;
  color: #333333;
  font-weight: 500;
  font-size: 0.95rem;
  text-transform: none;
  letter-spacing: 0;
}

.vip-cell {
  display: flex;
  justify-content: center;
}

.vip-badge {
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  color: #ffffff;
  padding: 6px 12px;
  border-radius: 20px;
  font-weight: 700;
  font-size: 0.8rem;
  text-align: center;
  min-width: 40px;
}

.level-name {
  font-weight: 600;
  color: #01A89E;
}

.amount-value,
.bonus-value,
.skip-value {
  font-weight: 600;
  color: #28a745;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .rank-table-header,
  .rank-row {
    grid-template-columns: 60px 1fr 1fr 1fr 1fr;
  }

  .vip-cell {
    grid-column: 1;
  }

  .name-cell {
    grid-column: 2 / span 4;
  }

  .rank-row {
    grid-template-columns: 60px 1fr;
    gap: 12px;
  }

  .rank-row .rank-cell {
    display: flex;
    justify-content: space-between;
    padding: 4px 0;
  }

  .vip-cell {
    justify-content: flex-start;
  }

  .rank-row .vip-cell::after {
    content: "VIP";
    color: #01A89E;
    font-weight: 600;
    margin-left: 8px;
  }
}

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

  .rank-card {
    padding: 16px;
  }

  .rank-table {
    min-width: 100%;
  }

  .rank-table-header {
    display: none;
  }

  .rank-row {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 20px;
  }

  .rank-row .rank-cell {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  }

  .rank-row .rank-cell:last-child {
    border-bottom: none;
  }

  .vip-cell {
    order: -1;
    justify-content: center;
  }

  .vip-badge {
    padding: 8px 16px;
    font-size: 0.9rem;
  }
}

@media (max-width: 480px) {
  .header-title {
    font-size: 1.8rem;
  }

  .header-subtitle {
    font-size: 1rem;
  }

  .back-button {
    padding: 10px 20px;
    font-size: 0.9rem;
  }
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