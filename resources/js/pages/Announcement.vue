<template>
  <div class="page-content">
    <div
      class="loader"
      v-if="loading"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div v-if="!loading">
      <div class="announcements-header">
        <div class="announcements-hero">
          <div class="hero-content">
            <h1 class="hero-title">Announcements</h1>
            <p class="hero-subtitle">Stay updated with the latest news and updates</p>
            <div class="hero-stats">
              <div class="stat-item">
                <div class="stat-number">{{ announcement.length }}</div>
                <div class="stat-label">Total Announcements</div>
              </div>
              <div class="stat-item">
                <div class="stat-number">Latest</div>
                <div class="stat-label">Information</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="announcements-content">
        <div class="announcements-section">
          <div class="section-header">
            <h2 class="section-title">Recent Announcements</h2>
            <p class="section-subtitle">Important updates and news from our team</p>
          </div>

          <div class="announcements-list" v-if="announcement">
            <div class="announcement-card" v-for="g in announcement" :key="g.id">
              <div class="announcement-header">
                <div class="announcement-meta">
                  <div class="announcement-title">{{ g.title }}</div>
                  <div class="announcement-info">
                    <span class="announcement-author">
                      <i class="fas fa-user"></i> {{ g.author }}
                    </span>
                    <span class="announcement-date">
                      <i class="fas fa-calendar"></i> {{ g.created_at }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="announcement-content" v-html="g.content"></div>
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

      banner: [],
      gameType: [],
      announcement: [],
    };
  },
  methods: {
    open() {
      this.$alert("This is a message", "Title", {
        confirmButtonText: "OK",
        callback: (action) => {},
      });
    },
    getAnnouncement() {
      axios.get("/misc/announcement").then((response) => {
        var data = response.data.data;

        $.each(
          data,
          function (key, value) {
            data[key].content = this.decoder(value.content);
            data[key].created_at = moment(data[key].created_at).format(
              "DD-MM-YYYY hh:mm A"
            );
          }.bind(this)
        );

        this.announcement = data;
      });
        this.loading = false

    },
    decoder(str) {
      var textArea = document.createElement("textarea");
      textArea.innerHTML = str;
      return textArea.value;
    },
  },
  mounted() {
    // this.open();
    this.getAnnouncement();
  },
};
</script>

<style lang="scss" scoped>
@import "../../sass/_variables";
@import "../../sass/_utilities";

// Announcements page styling
.announcements-header {
  margin: 2rem 0;
}

.announcements-hero {
  background: linear-gradient(135deg, #00A3E0 0%, #0077b6 100%);
  border-radius: 12px;
  padding: 3rem 2rem;
  text-align: center;
  color: #ffffff;
  margin-bottom: 3rem;

  .hero-content {
    max-width: 800px;
    margin: 0 auto;
  }

  .hero-title {
    font-size: 3rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 1rem;
  }

  .hero-subtitle {
    font-size: 1.25rem;
    color: #ffffff;
    margin-bottom: 2rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }

  .hero-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;

    .stat-item {
      text-align: center;

      .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.5rem;
      }

      .stat-label {
        font-size: 0.9rem;
        color: #ffffff;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.8;
      }
    }
  }
}

.announcements-content {
  margin-top: 3rem;
}

.announcements-section {
  .section-header {
    text-align: center;
    margin-bottom: 3rem;

    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: #00A3E0;
      margin-bottom: 0.5rem;
    }

    .section-subtitle {
      color: #666666;
      font-size: 1.1rem;
      max-width: 600px;
      margin: 0 auto;
    }
  }

  .announcements-list {
    display: grid;
    gap: 2rem;

    .announcement-card {
      background: #ffffff;
      border: 1px solid #e9ecef;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;

      &:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 163, 224, 0.15);
        border-color: #00A3E0;
      }

      .announcement-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;

        .announcement-meta {
          .announcement-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #00A3E0;
            margin-bottom: 0.75rem;
            line-height: 1.3;
          }

          .announcement-info {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;

            .announcement-author,
            .announcement-date {
              display: flex;
              align-items: center;
              gap: 0.5rem;
              font-size: 0.9rem;
              color: #666666;

              i {
                font-size: 0.8rem;
                color: #00A3E0;
              }
            }
          }
        }
      }

      .announcement-content {
        color: #333333;
        line-height: 1.6;

        ::v-deep p {
          margin-bottom: 1rem;

          &:last-child {
            margin-bottom: 0;
          }
        }

        ::v-deep ul, ::v-deep ol {
          margin-left: 1.5rem;
          margin-bottom: 1rem;
        }

        ::v-deep strong {
          color: #00A3E0;
          font-weight: 600;
        }

        ::v-deep a {
          color: #00A3E0;
          text-decoration: none;

          &:hover {
            text-decoration: underline;
          }
        }
      }
    }
  }
}

// Responsive design
@media (max-width: 768px) {
  .announcements-hero {
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

  .section-title {
    font-size: 2rem;
  }

  .announcements-list {
    grid-template-columns: 1fr;
    gap: 1.5rem;

    .announcement-card {
      padding: 1.5rem;

      .announcement-header {
        .announcement-meta {
          .announcement-title {
            font-size: 1.25rem;
          }

          .announcement-info {
            flex-direction: column;
            gap: 0.5rem;
          }
        }
      }
    }
  }
}
</style>