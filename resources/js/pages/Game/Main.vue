<template>
  <div class="page-content">
    <div
      class="loader"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div class="games-header">
      <div class="games-hero">
        <div class="hero-content">
          <h1 class="hero-title">Trading Markets</h1>
          <p class="hero-subtitle">Choose your preferred trading instrument and start building your portfolio</p>
          <div class="hero-stats">
            <div class="stat-item">
              <div class="stat-number">{{ gameType.length }}</div>
              <div class="stat-label">Available Markets</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">24/7</div>
              <div class="stat-label">Trading Hours</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">Fast</div>
              <div class="stat-label">Execution</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="games-grid">
      <div class="games-section">
        <div class="section-header">
          <h2 class="section-title">Select Trading Instrument</h2>
          <p class="section-subtitle">Choose from our diverse range of trading instruments</p>
        </div>

        <div class="games-grid-container">
          <router-link
            v-for="g in gameType"
            :key="g['id']"
            :to="'/trades/' + g['uuid']"
            class="game-card-link"
          >
            <div class="game-card">
              <div class="game-thumbnail-case">
                <img
                  class="game-thumbnail"
                  :src="'/uploads/games/' + g['thumbnail']"
                  :alt="g['name_code']"
                />
                <div class="game-overlay">
                  <div class="game-icon">
                    <i class="fas fa-chart-line"></i>
                  </div>
                </div>
              </div>
              <div class="game-content">
                <h3 class="game-title">{{ $t("app." + g["name_code"]) }}</h3>
                <p class="game-description">Trade this instrument with competitive odds and fast execution</p>
                <div class="game-action">
                  <span class="action-text">Start Trading</span>
                  <i class="fas fa-arrow-right"></i>
                </div>
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import Banner from "../../components/Banner.vue";
export default {
  components: {
    Banner,
  },
  data() {
    return {
      loading: true,

      gameType: [],
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
    this.$nextTick(function () {
      this.getGameType();
    });
  },
};
</script>

<style lang="scss" scoped>
@import "../../../sass/_variables";
@import "../../../sass/_utilities";




.box-card {
  margin-bottom: 20px;
  text-align: center;
  border-radius: 10px;
  border: 0px solid #000;
  color: #ff3131;
}
.box-card:hover {
  background: rgba(0, 0, 0, 0.2);
}

.box-link:hover {
  text-decoration: none;
}

.game-thumbnail-case {
  overflow: hidden;
  border-radius: 15px;
  padding: 15px 15px 0;
}

.game-thumbnail {
  max-width: 170px;
  width: 100%;
  border-radius: 20px;
}

/* Game page styling */
.games-header {
  margin: 2rem 0;
}

.games-hero {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 20px;
  box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
  background: linear-gradient(135deg, rgba(1, 168, 158, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
  border-radius: 20px;
  padding: 3rem 2rem;
  text-align: center;
  position: relative;
  overflow: hidden;

  &::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="gameGrid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(1,168,158,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23gameGrid)"/></svg>');
    opacity: 0.3;
  }

  .hero-content {
    position: relative;
    z-index: 2;
  }

  .hero-title {
    font-size: 3rem;
    font-weight: 800;
    color: #01A89E;
    margin-bottom: 1rem;
    text-shadow: 0 0 20px rgba(1, 168, 158, 0.3);
    animation: fadeInUp 1s ease-out;
  }

  .hero-subtitle {
    font-size: 1.25rem;
    color: #666666;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    animation: fadeInUp 1s ease-out 0.2s both;
  }

  .hero-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
    animation: fadeInUp 1s ease-out 0.4s both;

    .stat-item {
      text-align: center;

      .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #01A89E;
        margin-bottom: 0.5rem;
        text-shadow: 0 0 10px rgba(1, 168, 158, 0.2);
      }

      .stat-label {
        font-size: 0.9rem;
        color: #666666;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }
    }
  }
}

.games-grid {
  margin-top: 3rem;
}

.games-section {
  .section-header {
    text-align: center;
    margin-bottom: 2rem;

    .section-title {
      font-size: 2rem;
      font-weight: 700;
      color: #01A89E;
      margin-bottom: 0.5rem;
    }

    .section-subtitle {
      color: #666666;
      font-size: 1rem;
    }
  }

  .games-grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;

    .game-card-link {
      text-decoration: none;
      transition: transform 0.3s ease;

      &:hover {
        transform: translateY(-5px);
      }

      .game-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 16px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        border-radius: 16px;
        overflow: hidden;

        .game-thumbnail-case {
          position: relative;
          height: 200px;
          display: flex;
          align-items: center;
          justify-content: center;
          background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
          border-radius: 16px 16px 0 0;

          .game-thumbnail {
            max-width: 150px;
            max-height: 150px;
            width: auto;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
          }

          .game-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;

            .game-icon {
              width: 60px;
              height: 60px;
              background: rgba(255, 255, 255, 0.2);
              border-radius: 50%;
              display: flex;
              align-items: center;
              justify-content: center;

              i {
                font-size: 1.5rem;
                color: #ffffff;
              }
            }
          }
        }

        &:hover .game-overlay {
          opacity: 1;
        }

        .game-content {
          padding: 1.5rem;
          background: rgba(255, 255, 255, 0.9);
          backdrop-filter: blur(10px);

          .game-title {
            color: #01A89E;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
          }

          .game-description {
            color: #666666;
            margin-bottom: 1rem;
            line-height: 1.5;
          }

          .game-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #01A89E;
            font-weight: 500;

            .action-text {
              font-size: 0.9rem;
              text-transform: uppercase;
              letter-spacing: 0.5px;
            }

            i {
              transition: transform 0.3s ease;
            }
          }
        }

        &:hover .game-action i {
          transform: translateX(5px);
        }
      }
    }
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive design */
@media (max-width: 768px) {
  .games-hero {
    padding: 2rem 1rem;

    .hero-title {
      font-size: 2rem;
    }

    .hero-subtitle {
      font-size: 1rem;
    }

    .hero-stats {
      flex-direction: column;
      gap: 1rem;

      .stat-item {
        .stat-number {
          font-size: 2rem;
        }
      }
    }
  }

  .games-grid-container {
    grid-template-columns: 1fr;
  }
}
</style>