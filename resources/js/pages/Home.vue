<template>
  <div class="pmbr-homepage">
    <div
      class="loader"
      v-if="loading"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div v-if="!loading">
      <!-- Hero Slider Section -->
      <div class="pmbr-hero-slider">
        <div class="pmbr-slider-track" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
          <div class="pmbr-slide" v-for="(slide, index) in slides" :key="index">
            <div class="pmbr-slide-bg" :style="{ backgroundImage: `url(${slide.image})` }"></div>
            <div class="pmbr-slide-overlay"></div>
            <div class="pmbr-slide-content">
              <p class="pmbr-slide-tag">{{ slide.tag }}</p>
              <h1 class="pmbr-slide-title">{{ slide.title }}</h1>
              <p class="pmbr-slide-subtitle">{{ slide.subtitle }}</p>
              <a href="#" class="pmbr-slide-cta">
                <span>{{ slide.cta }}</span>
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Slider Navigation -->
        <div class="pmbr-slider-nav">
          <button class="pmbr-slider-prev" @click="prevSlide" :disabled="currentSlide === 0">
            <i class="fas fa-chevron-left"></i>
          </button>
          <div class="pmbr-slider-dots">
            <button
              v-for="(slide, index) in slides"
              :key="index"
              class="pmbr-slider-dot"
              :class="{ active: currentSlide === index }"
              @click="goToSlide(index)"
            ></button>
          </div>
          <button class="pmbr-slider-next" @click="nextSlide" :disabled="currentSlide === slides.length - 1">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>

      <!-- Stats Section -->
      <div class="pmbr-stats-section">
        <div class="container">
          <div class="pmbr-stats-grid">
            <div class="pmbr-stat-card">
              <div class="pmbr-stat-icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <div class="pmbr-stat-content">
                <h3>Active Bids</h3>
                <p class="pmbr-stat-value">2,847</p>
                <span class="pmbr-stat-change">+12.5%</span>
              </div>
            </div>

            <div class="pmbr-stat-card">
              <div class="pmbr-stat-icon">
                <i class="fas fa-users"></i>
              </div>
              <div class="pmbr-stat-content">
                <h3>Registered Users</h3>
                <p class="pmbr-stat-value">15,432</p>
                <span class="pmbr-stat-change">+8.2%</span>
              </div>
            </div>

            <div class="pmbr-stat-card">
              <div class="pmbr-stat-icon">
                <i class="fas fa-globe"></i>
              </div>
              <div class="pmbr-stat-content">
                <h3>Countries</h3>
                <p class="pmbr-stat-value">12</p>
                <span class="pmbr-stat-change">+3</span>
              </div>
            </div>

            <div class="pmbr-stat-card">
              <div class="pmbr-stat-icon">
                <i class="fas fa-trophy"></i>
              </div>
              <div class="pmbr-stat-content">
                <h3>Total Revenue</h3>
                <p class="pmbr-stat-value">RM 45.2M</p>
                <span class="pmbr-stat-change">+18.7%</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- About Section -->
      <div class="pmbr-about-section">
        <div class="container">
          <div class="pmbr-section-header">
            <h2 class="pmbr-section-title">About Petro Malaysia Bid Round</h2>
            <p class="pmbr-section-subtitle">Your trusted partner in petroleum investment opportunities</p>
          </div>

          <div class="pmbr-about-grid">
            <div class="pmbr-about-card">
              <div class="pmbr-about-icon">
                <i class="fas fa-oil-well"></i>
              </div>
              <div class="pmbr-about-content">
                <h3>Transparent Bidding</h3>
                <p>Our platform ensures fair and transparent bidding processes for all participants, providing equal opportunities for qualified investors.</p>
              </div>
            </div>

            <div class="pmbr-about-card">
              <div class="pmbr-about-icon">
                <i class="fas fa-shield-alt"></i>
              </div>
              <div class="pmbr-about-content">
                <h3>Secure Transactions</h3>
                <p>Advanced encryption and security measures protect your investments and personal information at all times.</p>
              </div>
            </div>

            <div class="pmbr-about-card">
              <div class="pmbr-about-icon">
                <i class="fas fa-headset"></i>
              </div>
              <div class="pmbr-about-content">
                <h3>Expert Support</h3>
                <p>Our dedicated team of professionals is available 24/7 to assist you with any questions or concerns.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="pmbr-cta-section">
        <div class="container">
          <div class="pmbr-cta-content">
            <h2 class="pmbr-cta-title">Ready to Start Bidding?</h2>
            <p class="pmbr-cta-subtitle">Join thousands of investors participating in Malaysia's premier petroleum bidding platform</p>
            <div class="pmbr-cta-buttons">
              <router-link v-if="!this.$auth.check()" to="/register" class="pmbr-cta-btn pmbr-cta-primary">
                <i class="fas fa-user-plus"></i>
                <span>Create Account</span>
              </router-link>
              <router-link v-if="!this.$auth.check()" to="/login" class="pmbr-cta-btn pmbr-cta-secondary">
                <i class="fas fa-sign-in-alt"></i>
                <span>Sign In</span>
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Slider Section -->
      <div class="pmbr-footer-slider">
        <div class="container">
          <div class="pmbr-footer-slider-inner">
            <div class="pmbr-slider-container">
              <div class="pmbr-slider-track" :style="{ transform: `translateX(-${footerCurrentSlide * 100}%)` }">
                <div class="pmbr-footer-slide" v-for="(slide, index) in footerSlides" :key="index">
                  <div class="pmbr-footer-slide-bg" :style="{ backgroundImage: `url(${slide.image})` }"></div>
                  <div class="pmbr-footer-slide-overlay"></div>
                  <div class="pmbr-footer-slide-content">
                    <h2>{{ slide.title }}</h2>
                    <a href="#" class="pmbr-footer-slide-link">
                      <span>{{ slide.cta }}</span>
                      <i class="fas fa-arrow-right"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="pmbr-footer-slider-nav">
                <button class="pmbr-slider-prev" @click="prevFooterSlide" :disabled="footerCurrentSlide === 0">
                  <i class="fas fa-chevron-left"></i>
                </button>
                <button class="pmbr-slider-next" @click="nextFooterSlide" :disabled="footerCurrentSlide === footerSlides.length - 1">
                  <i class="fas fa-chevron-right"></i>
                </button>
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
      loading: false,
      appName: process.env.MIX_APP_NAME,
      currentSlide: 0,
      footerCurrentSlide: 0,
      slides: [
        {
          image: '/images/pmbr/hero-slide-1.jpg',
          tag: 'Investment Opportunities',
          title: 'Malaysia Bid Round 2025',
          subtitle: 'Discover exclusive petroleum investment opportunities',
          cta: 'Explore Now'
        },
        {
          image: '/images/pmbr/hero-slide-2.jpg',
          tag: 'Strategic Partnerships',
          title: 'Global Energy Solutions',
          subtitle: 'Connect with leading petroleum companies worldwide',
          cta: 'Learn More'
        },
        {
          image: '/images/pmbr/hero-slide-3.jpg',
          tag: 'Sustainable Future',
          title: 'Energy Innovation Hub',
          subtitle: 'Pioneering the future of petroleum investment',
          cta: 'Discover More'
        }
      ],
      footerSlides: [
        {
          image: '/images/pmbr/hero-slide-1.jpg',
          title: 'Media & Publications',
          cta: 'View All'
        },
        {
          image: '/images/pmbr/hero-slide-2.jpg',
          title: 'Investment Opportunities',
          cta: 'Explore'
        },
        {
          image: '/images/pmbr/hero-slide-3.jpg',
          title: 'Participation Criteria',
          cta: 'Learn More'
        }
      ],
      sliderInterval: null,
      footerSliderInterval: null
    };
  },
  mounted() {
    this.loading = false;
    this.startAutoSlide();
    this.startFooterAutoSlide();
  },
  beforeDestroy() {
    this.stopAutoSlide();
    this.stopFooterAutoSlide();
  },
  methods: {
    nextSlide() {
      this.currentSlide = (this.currentSlide + 1) % this.slides.length;
      this.resetAutoSlide();
    },
    prevSlide() {
      this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
      this.resetAutoSlide();
    },
    goToSlide(index) {
      this.currentSlide = index;
      this.resetAutoSlide();
    },
    nextFooterSlide() {
      this.footerCurrentSlide = (this.footerCurrentSlide + 1) % this.footerSlides.length;
      this.resetFooterAutoSlide();
    },
    prevFooterSlide() {
      this.footerCurrentSlide = (this.footerCurrentSlide - 1 + this.footerSlides.length) % this.footerSlides.length;
      this.resetFooterAutoSlide();
    },
    startAutoSlide() {
      this.sliderInterval = setInterval(() => {
        this.nextSlide();
      }, 5000);
    },
    stopAutoSlide() {
      if (this.sliderInterval) {
        clearInterval(this.sliderInterval);
      }
    },
    resetAutoSlide() {
      this.stopAutoSlide();
      this.startAutoSlide();
    },
    startFooterAutoSlide() {
      this.footerSliderInterval = setInterval(() => {
        this.nextFooterSlide();
      }, 4000);
    },
    stopFooterAutoSlide() {
      if (this.footerSliderInterval) {
        clearInterval(this.footerSliderInterval);
      }
    },
    resetFooterAutoSlide() {
      this.stopFooterAutoSlide();
      this.startFooterAutoSlide();
    }
  },
};
</script>

<style scoped>
/* PMBR Homepage - Modern Redesign */
.pmbr-homepage {
  min-height: 100vh;
  background: #f8f9fa;
  width: 100%;
}

/* Hero Slider */
.pmbr-hero-slider {
  position: relative;
  width: 100%;
  height: 70vh;
  min-height: 500px;
  overflow: hidden;
}

.pmbr-slider-track {
  display: flex;
  width: 100%;
  height: 100%;
  transition: transform 0.6s ease-in-out;
}

.pmbr-slide {
  min-width: 100%;
  height: 100%;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.pmbr-slide-bg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.pmbr-slide-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
}

.pmbr-slide-content {
  position: relative;
  z-index: 2;
  text-align: center;
  color: #ffffff;
  max-width: 700px;
  padding: 0 2rem;
}

.pmbr-slide-tag {
  font-size: 0.9rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 1rem;
  opacity: 0.9;
}

.pmbr-slide-title {
  font-size: 3rem;
  font-weight: 800;
  margin: 0 0 1rem 0;
  line-height: 1.2;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.pmbr-slide-subtitle {
  font-size: 1.2rem;
  margin: 0 0 2rem 0;
  line-height: 1.5;
  opacity: 0.95;
}

.pmbr-slide-cta {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  background: #01a89e;
  color: #ffffff;
  padding: 1rem 2rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s ease;
  box-shadow: 0 8px 20px rgba(1, 168, 158, 0.4);
}

.pmbr-slide-cta:hover {
  background: #016f68;
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(1, 168, 158, 0.5);
}

/* Slider Navigation */
.pmbr-slider-nav {
  position: absolute;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  align-items: center;
  gap: 2rem;
  z-index: 10;
}

.pmbr-slider-prev,
.pmbr-slider-next {
  width: 50px;
  height: 50px;
  background: rgba(255, 255, 255, 0.9);
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #01a89e;
  font-size: 1.25rem;
  cursor: pointer;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
}

.pmbr-slider-prev:hover,
.pmbr-slider-next:hover {
  background: #ffffff;
  transform: scale(1.1);
}

.pmbr-slider-prev:disabled,
.pmbr-slider-next:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

.pmbr-slider-dots {
  display: flex;
  gap: 0.75rem;
}

.pmbr-slider-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.5);
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
}

.pmbr-slider-dot:hover {
  background: rgba(255, 255, 255, 0.8);
}

.pmbr-slider-dot.active {
  background: #01a89e;
  width: 36px;
}

/* Stats Section */
.pmbr-stats-section {
  padding: 4rem 0;
  background: #ffffff;
}

.pmbr-stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
}

.pmbr-stat-card {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding: 2rem;
  background: #f8f9fa;
  border-radius: 16px;
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
  min-height: 100px;
}

.pmbr-stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(1, 168, 158, 0.15);
  border-color: rgba(1, 168, 158, 0.3);
}

.pmbr-stat-icon {
  width: 60px;
  height: 60px;
  background: rgba(1, 168, 158, 0.15);
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #01a89e;
  font-size: 1.5rem;
  flex-shrink: 0;
}

.pmbr-stat-content {
  display: flex;
  flex-direction: column;
  justify-content: center;
  flex: 1;
  min-width: 0;
}

.pmbr-stat-content h3 {
  font-size: 1rem;
  font-weight: 600;
  color: #333;
  margin: 0 0 0.5rem 0;
  white-space: nowrap;
}

.pmbr-stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: #01a89e;
  margin: 0 0 0.25rem 0;
  white-space: nowrap;
}

.pmbr-stat-change {
  font-size: 0.85rem;
  color: #28a745;
  font-weight: 600;
  white-space: nowrap;
}

/* About Section */
.pmbr-about-section {
  padding: 5rem 0;
  background: #f8f9fa;
}

.pmbr-section-header {
  text-align: center;
  margin-bottom: 3rem;
}

.pmbr-section-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #01a89e;
  margin-bottom: 1rem;
}

.pmbr-section-subtitle {
  font-size: 1.1rem;
  color: #666;
  margin: 0;
}

.pmbr-about-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

.pmbr-about-card {
  display: flex;
  gap: 1.5rem;
  padding: 2rem;
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
}

.pmbr-about-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(1, 168, 158, 0.15);
  border-color: rgba(1, 168, 158, 0.3);
}

.pmbr-about-icon {
  width: 50px;
  height: 50px;
  background: rgba(1, 168, 158, 0.15);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #01a89e;
  font-size: 1.25rem;
  flex-shrink: 0;
}

.pmbr-about-content h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #333;
  margin: 0 0 0.75rem 0;
}

.pmbr-about-content p {
  font-size: 0.95rem;
  color: #666;
  line-height: 1.6;
  margin: 0;
}

/* CTA Section */
.pmbr-cta-section {
  padding: 5rem 0;
  background: linear-gradient(135deg, #01a89e 0%, #016f68 100%);
  color: #ffffff;
}

.pmbr-cta-content {
  text-align: center;
  max-width: 800px;
  margin: 0 auto;
}

.pmbr-cta-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.pmbr-cta-subtitle {
  font-size: 1.1rem;
  margin-bottom: 2rem;
  opacity: 0.9;
}

.pmbr-cta-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.pmbr-cta-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem 2rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s ease;
  min-width: 180px;
  justify-content: center;
}

.pmbr-cta-primary {
  background: #ffffff;
  color: #01a89e;
}

.pmbr-cta-primary:hover {
  background: #f8f9fa;
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(255, 255, 255, 0.3);
}

.pmbr-cta-secondary {
  background: rgba(255, 255, 255, 0.2);
  color: #ffffff;
  border: 2px solid rgba(255, 255, 255, 0.4);
}

.pmbr-cta-secondary:hover {
  background: rgba(255, 255, 255, 0.3);
  border-color: rgba(255, 255, 255, 0.6);
  transform: translateY(-3px);
}

/* Footer Slider */
.pmbr-footer-slider {
  padding: 4rem 0;
  background: #f8f9fa;
}

.pmbr-footer-slider-inner {
  max-width: 1200px;
  margin: 0 auto;
}

.pmbr-slider-container {
  position: relative;
  overflow: hidden;
}

.pmbr-footer-slide {
  min-width: 100%;
  height: 400px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.pmbr-footer-slide-bg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.pmbr-footer-slide-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
}

.pmbr-footer-slide-content {
  position: relative;
  z-index: 2;
  text-align: center;
  color: #ffffff;
  max-width: 500px;
  padding: 0 2rem;
}

.pmbr-footer-slide-content h2 {
  font-size: 2rem;
  font-weight: 700;
  margin: 0 0 1.5rem 0;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.pmbr-footer-slide-link {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  background: rgba(255, 255, 255, 0.9);
  color: #01a89e;
  padding: 0.875rem 1.75rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.95rem;
  transition: all 0.3s ease;
}

.pmbr-footer-slide-link:hover {
  background: #ffffff;
  transform: translateY(-3px);
}

.pmbr-footer-slider-nav {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  padding: 0 2rem;
  pointer-events: none;
}

.pmbr-footer-slider-nav button {
  pointer-events: auto;
  background: rgba(255, 255, 255, 0.9);
  border: none;
  width: 45px;
  height: 45px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #01a89e;
  font-size: 1.1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
}

.pmbr-footer-slider-nav button:hover {
  background: #ffffff;
  transform: scale(1.1);
}

.pmbr-footer-slider-nav button:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

/* Container */
.container {
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}

@media (min-width: 576px) {
  .container {
    max-width: 540px;
  }
}

@media (min-width: 768px) {
  .container {
    max-width: 720px;
  }
}

@media (min-width: 992px) {
  .container {
    max-width: 960px;
  }
}

@media (min-width: 1200px) {
  .container {
    max-width: 1140px;
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .pmbr-hero-slider {
    height: 50vh;
    min-height: 350px;
  }

  .pmbr-slide-title {
    font-size: 2rem;
  }

  .pmbr-slide-subtitle {
    font-size: 1rem;
  }

  .pmbr-slide-cta {
    padding: 0.75rem 1.5rem;
    font-size: 0.9rem;
  }

  .pmbr-stats-grid {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
  }

  .pmbr-stat-card {
    padding: 1.5rem;
    min-height: auto;
  }

  .pmbr-stat-content h3 {
    white-space: normal;
  }

  .pmbr-stat-value {
    font-size: 1.5rem;
    white-space: normal;
  }

  .pmbr-stat-change {
    white-space: normal;
  }

  .pmbr-about-grid {
    grid-template-columns: 1fr;
  }

  .pmbr-cta-title {
    font-size: 2rem;
  }

  .pmbr-cta-buttons {
    flex-direction: column;
  }

  .pmbr-cta-btn {
    width: 100%;
  }

  .pmbr-footer-slide {
    height: 300px;
  }

  .pmbr-footer-slide-content h2 {
    font-size: 1.5rem;
  }
}

@media (max-width: 480px) {
  .pmbr-slide-title {
    font-size: 1.5rem;
  }

  .pmbr-section-title {
    font-size: 2rem;
  }

  .pmbr-cta-title {
    font-size: 1.75rem;
  }

  .pmbr-slider-nav {
    bottom: 1rem;
  }

  .pmbr-slider-prev,
  .pmbr-slider-next {
    width: 40px;
    height: 40px;
  }
}
</style>
