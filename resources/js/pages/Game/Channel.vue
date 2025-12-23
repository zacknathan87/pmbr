<template>
  <div class="page-content">
    <div
      v-if="loading"
      class="loader"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
      style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999"
    ></div>

    <div v-if="!loading" style="position: relative; height: 100%">
      <!-- Header Section -->
      <div class="channel-header">
        <div class="header-card">
          <div class="header-content">
            <h1 class="header-title">
              <i class="fas fa-chart-line"></i>
              Digital Trading
              <span class="header-divider">/</span>
              <span class="game-type">{{ this.gameTypeTitle }}</span>
            </h1>
            <p class="header-subtitle">Choose your preferred game channel to start playing</p>
          </div>
        </div>
      </div>

      <!-- Banner Component -->
     <!-- <banner /> -->

      <!-- Error State -->
      <div v-if="this.error" class="error-state">
        <div class="error-card">
          <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
          <h2 class="error-title">{{ $t("app.error") }}</h2>
          <p class="error-message">Invalid Game</p>
          <router-link to="/home" class="home-link">
            <i class="fas fa-home"></i>
            Return Home
          </router-link>
        </div>
      </div>

      <!-- Game Channels Grid -->
      <div v-else class="channels-container">
        <div class="channels-grid">
          <div v-for="g in gameChannel" :key="g['id']" class="channel-card">
            <router-link :to="'/trades/' + gameType + '/' + g['uuid']" class="channel-link">
              <div class="channel-content">
                <div class="channel-icon">
                  <i class="fas fa-chart-line"></i>
                </div>
                <div class="channel-info">
                  <h3 class="channel-name">{{ $t("app." + g["name_code"]) }}</h3>
                  <p class="channel-description">Click to play this game channel</p>
                </div>
                <div class="channel-arrow">
                  <i class="fas fa-chevron-right"></i>
                </div>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import Banner from '../../components/Banner.vue';
export default {
  components: {
    Banner
  },
  data() {
    return {

      loading: true,
      error: false,
      gameType: "",
      gameTypeTitle: "",

      gameChannel: [],
    };
  },
  created() {},
  methods: {
    getGameChannel() {
      axios.get("/misc/gameChannel/" + this.gameType).then((response) => {
        if (response.data.data) {
          this.gameChannel = response.data.data;

          this.gameTypeTitle = this.$t('app.'+this.gameChannel[0].game_type.name_code);
        } else {
          this.error = true;
        }

        this.loading = false;
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
    // this.open();
    this.gameType = this.$route.params.gameType;

    this.$nextTick(function () {
      this.getGameChannel(this.$route.params);
    });
  },
};
</script>

<style scoped>
/* Page Background */
.page-content {
  min-height: 100vh;
  background: #ffffff;
  padding: 20px;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Header Section */
.channel-header {
  margin-bottom: 24px;
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
}

.header-card {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  padding: 32px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  text-align: center;
}

.header-content {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.header-title {
  font-size: 2.5rem;
  font-weight: 700;
  background: linear-gradient(135deg, #01a89e 0%, #017f7a 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin: 0 0 8px 0;
  display: flex;
  align-items: center;
  gap: 12px;
}

.header-divider {
  color: #01a89e;
  opacity: 0.6;
}

.game-type {
  color: #01a89e;
}

.header-subtitle {
  font-size: 1.1rem;
  color: #6b7280;
  margin: 0;
  opacity: 0.9;
}

/* Error State */
.error-state {
  max-width: 800px;
  margin: 40px auto;
}

.error-card {
  background: #ffffff;
  border: 1px solid #fee2e2;
  border-radius: 16px;
  padding: 40px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.error-icon {
  background: linear-gradient(135deg, #ff4444 0%, #ff6666 100%);
  border-radius: 50%;
  width: 80px;
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  color: #ffffff;
  margin: 0 auto 20px;
  box-shadow: 0 0 30px rgba(255, 68, 68, 0.3);
}

.error-title {
  font-size: 2rem;
  font-weight: 700;
  color: #ff6666;
  margin: 0 0 8px 0;
}

.error-message {
  font-size: 1.1rem;
  color: #b8c5d1;
  margin: 0 0 24px 0;
}

.home-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  background: linear-gradient(135deg, #ff4444 0%, #ff6666 100%);
  border: none;
  border-radius: 12px;
  color: #ffffff;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 1rem;
}

.home-link:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(255, 68, 68, 0.4);
}

/* Channels Grid */
.channels-container {
  max-width: 1200px;
  margin: 0 auto;
}

.channels-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 24px;
  margin-top: 32px;
}

.channel-card {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(20px);
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  transition: all 0.3s ease;
  overflow: hidden;
}

.channel-card:hover {
  transform: translateY(-5px);
  border-color: rgba(0, 212, 255, 0.3);
  box-shadow: 0 15px 40px rgba(0, 212, 255, 0.2);
}

.channel-link {
  display: block;
  text-decoration: none;
  color: inherit;
}

.channel-content {
  display: flex;
  align-items: center;
  padding: 24px;
  gap: 16px;
}

.channel-icon {
  background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
  border-radius: 12px;
  padding: 16px;
  color: #ffffff;
  font-size: 1.5rem;
  flex-shrink: 0;
  box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
}

.channel-info {
  flex: 1;
}

.channel-name {
  font-size: 1.25rem;
  font-weight: 600;
  color: #00d4ff;
  margin: 0 0 4px 0;
}

.channel-description {
  font-size: 0.9rem;
  color: #b8c5d1;
  margin: 0;
  opacity: 0.8;
}

.channel-arrow {
  color: #00ff88;
  font-size: 1.2rem;
  opacity: 0.7;
  transition: all 0.3s ease;
}

.channel-card:hover .channel-arrow {
  opacity: 1;
  transform: translateX(4px);
}

/* Responsive Design */
@media (max-width: 1024px) {
  .channels-grid {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
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
    flex-direction: column;
    gap: 8px;
  }

  .header-divider {
    display: none;
  }

  .channels-grid {
    grid-template-columns: 1fr;
    gap: 16px;
    margin-top: 24px;
  }

  .channel-content {
    padding: 20px;
    gap: 12px;
  }

  .channel-name {
    font-size: 1.1rem;
  }

  .error-card {
    padding: 24px;
  }

  .error-icon {
    width: 60px;
    height: 60px;
    font-size: 1.5rem;
  }

  .error-title {
    font-size: 1.5rem;
  }
}

@media (max-width: 480px) {
  .header-title {
    font-size: 1.8rem;
  }

  .channel-content {
    flex-direction: column;
    text-align: center;
    gap: 12px;
  }

  .channel-icon {
    align-self: center;
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