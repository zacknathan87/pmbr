<template>
  <div class="page-content">
    <div
      class="loader"
      v-if="loading"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div class="results-header">
      <div class="results-hero">
        <div class="hero-content">
          <h1 class="hero-title">Market Results</h1>
          <p class="hero-subtitle">View historical market results and performance data</p>
          <div class="hero-stats">
            <div class="stat-item">
              <div class="stat-number">{{ gameType.length }}</div>
              <div class="stat-label">Markets</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">24/7</div>
              <div class="stat-label">Results Available</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">Real-time</div>
              <div class="stat-label">Updates</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="results-content">
      <div class="results-navigation">
        <router-link to="/account" class="back-button">
          <i class="fas fa-arrow-left"></i>
          Back to Dashboard
        </router-link>
      </div>

      <div class="results-selector">
        <div class="selector-card">
          <h3 class="selector-title">Select Market</h3>
          <el-select
            @change="onChangeGameType"
            v-model="gameTypeId"
            placeholder="Choose a market to view results"
            class="market-select"
          >
            <el-option
              v-for="item in gameType"
              :key="item.name_code"
              :label="$t('app.' + item.name_code)"
              :value="item.id"
            />
          </el-select>
        </div>
      </div>

      <div v-if="gameTypeId" class="results-display">
        <component
          :is="currentComponent"
          :game-type-id="gameTypeId"
          class="result-component"
        />
      </div>
    </div>
  </div>
</template>


<script>
import moment from "moment";
import GameDiceResult from "./GameDiceResult.vue";
import Game5NumberResult from "./Game5NumberResult.vue";
import Game10NumberResult from "./Game10NumberResult.vue";
import GameJackpotResult from "./GameJackpotResult.vue";

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

      currentComponent: "game_dice",

      gameType: [],
      gameTypeId: null,

      date: new Date(),
    };
  },
  components: {
    game_dice: GameDiceResult,
    game_5_number: Game5NumberResult,
    game_10_number: Game10NumberResult,
    game_jackpot: GameJackpotResult,
  },
  created() {},
  methods: {
    getGameType() {
      axios.get("/misc/gameType").then((response) => {
        this.gameType = response.data.data;
        this.gameTypeId = this.gameType[0].id;

        this.loading = false;
      });
    },

    onChangeGameType(v) {
      if (v == 1) {
        this.currentComponent = "game_dice";
      }
      if (v == 2) {
        this.currentComponent = "game_5_number";
      }
      if (v == 3) {
        this.currentComponent = "game_10_number";
      }
      if (v == 4) {
        this.currentComponent = "game_jackpot";
      }
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
.results-header {
  margin-bottom: 3rem;
  padding: 2rem 0;
}

.results-hero {
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
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
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
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
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
.results-content {
  background: rgba(1, 168, 158, 0.08);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
}

.results-navigation {
  margin-bottom: 2rem;
}

.back-button {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 1.5rem;
  background: rgba(0, 212, 255, 0.1);
  border: 1px solid rgba(0, 212, 255, 0.3);
  border-radius: 25px;
  color: #00d4ff;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
}

.back-button:hover {
  background: rgba(0, 212, 255, 0.2);
  color: #00ff88;
  transform: translateX(-2px);
}

/* Market Selector */
.results-selector {
  margin-bottom: 2rem;
}

.selector-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 2rem;
  transition: all 0.3s ease;
}

.selector-card:hover {
  transform: translateY(-2px);
  border-color: rgba(0, 212, 255, 0.3);
  box-shadow: 0 4px 20px rgba(0, 212, 255, 0.2);
}

.selector-title {
  color: #ffffff;
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
  text-align: center;
}

.market-select {
  width: 100%;
}

.market-select >>> .el-input__inner {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  color: #ffffff;
  padding: 0.75rem 1rem;
  font-size: 1rem;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
}

.market-select >>> .el-input__inner:focus {
  border-color: #00d4ff;
  box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
  background: rgba(255, 255, 255, 0.08);
}

.market-select >>> .el-input__inner::placeholder {
  color: #808080;
}

.market-select >>> .el-select-dropdown {
  background: rgba(26, 26, 46, 0.95);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
}

.market-select >>> .el-select-dropdown__item {
  color: #ffffff;
  padding: 0.75rem 1rem;
}

.market-select >>> .el-select-dropdown__item.hover,
.market-select >>> .el-select-dropdown__item:hover {
  background: rgba(0, 212, 255, 0.1);
  color: #00ff88;
}

.market-select >>> .el-select-dropdown__item.selected {
  background: rgba(0, 212, 255, 0.2);
  color: #00ff88;
}

/* Results Display */
.results-display {
  margin-top: 2rem;
}

.result-component {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 2rem;
  transition: all 0.3s ease;
}

.result-component:hover {
  transform: translateY(-2px);
  border-color: rgba(0, 212, 255, 0.3);
  box-shadow: 0 4px 20px rgba(0, 212, 255, 0.2);
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

  .results-hero {
    margin: 0 -1rem;
  }

  .results-content {
    margin: 0 -1rem;
    border-radius: 0;
    border-left: none;
    border-right: none;
  }

  .selector-card,
  .result-component {
    padding: 1.5rem;
  }

  .selector-title {
    font-size: 1.1rem;
  }
}

/* Legacy styles for component compatibility */
.el-date-editor.el-input,
.el-date-editor.el-input__inner {
  width: auto;
}

.el-select {
  width: 100%;
}
</style>

<style>
.result-title {
  font-size: 18px;
  color: #fff;
}
</style>