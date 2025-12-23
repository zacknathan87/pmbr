<template>
  <el-footer>
    <!-- Main Footer -->
    <div class="footer-main">
      <div class="app-container">
        <!-- Footer Content -->
        <div class="footer-content">
          <!-- Brand Section -->
          <div class="footer-brand">
            <div class="footer-logo">
              <img src="/images/pmbr/logo-new.png" alt="PMBR Logo" class="footer-logo-img">
              <div class="footer-logo-text">
                <span class="footer-logo-main">PMBR</span>
                <span class="footer-logo-sub">Petro Malaysia Bid Round</span>
              </div>
            </div>
            <p class="footer-tagline">Your trusted partner in petroleum investment opportunities</p>
          </div>

          <!-- Navigation Links -->
          <div class="footer-nav">
            <div class="nav-section">
              <h4 class="nav-title">Platform</h4>
              <ul class="nav-links">
                <li><router-link to="/trades">{{ $t("app.game") }}</router-link></li>
                <li><router-link to="/result">{{ $t("app.result") }}</router-link></li>
                <li><router-link to="/my-trades">{{ $t("app.my_trades") }}</router-link></li>
              </ul>
            </div>

            <div class="nav-section">
              <h4 class="nav-title">Account</h4>
              <ul class="nav-links">
                <li><router-link to="/account">Account</router-link></li>
                <li v-if="!this.$auth.check()"><router-link to="/login">Login</router-link></li>
                <li v-if="!this.$auth.check()"><router-link to="/register">Register</router-link></li>
              </ul>
            </div>

            <div class="nav-section">
              <h4 class="nav-title">Support</h4>
              <ul class="nav-links">
                <li><a href="javascript:void(Tawk_API.toggle())">Support</a></li>
                <li><router-link to="/announcement">Announcements</router-link></li>
                <li><a href="/faq">FAQ</a></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
          <div class="footer-legal">
            <p>&copy; 2025 PMBR. All rights reserved.</p>
            <div class="legal-links">
              <a href="/privacy">Privacy Policy</a>
              <a href="/terms">Terms of Service</a>
            </div>
          </div>

          <!-- Social Links -->
          <div class="footer-social">
            <a href="#" class="social-link" aria-label="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-link" aria-label="Twitter">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-link" aria-label="LinkedIn">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="social-link" aria-label="Instagram">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="mobile-nav">
      <div class="mobile-nav-container">
        <router-link to="/home" class="mobile-nav-item">
          <div class="mobile-nav-icon">
            <i class="fas fa-home"></i>
          </div>
          <span>{{ $t("app.home") }}</span>
        </router-link>

        <router-link to="/trades" class="mobile-nav-item">
          <div class="mobile-nav-icon">
            <i class="fas fa-gamepad"></i>
          </div>
          <span>{{ $t("app.game") }}</span>
        </router-link>

        <router-link v-if="!this.$auth.check()" to="/login" class="mobile-nav-item">
          <div class="mobile-nav-icon">
            <i class="fas fa-lock"></i>
          </div>
          <span>{{ $t("app.login") }}</span>
        </router-link>

        <div class="mobile-nav-item" @click="openSupport">
          <div class="mobile-nav-icon">
            <i class="fas fa-headset"></i>
          </div>
          <span>Support</span>
        </div>

        <router-link to="/account" class="mobile-nav-item">
          <div class="mobile-nav-icon">
            <i class="fas fa-user"></i>
          </div>
          <span>{{ $t("app.account") }}</span>
        </router-link>
      </div>
    </div>
  </el-footer>
</template>

<script>
export default {
  data() {
    return {
      appName: process.env.MIX_APP_NAME,
    };
  },
  methods: {
    openSupport() {
      if (typeof Tawk_API !== 'undefined') {
        Tawk_API.toggle();
      }
    },
  },
};
</script>

<style scoped>
/* App Footer - Modern Redesign */
.el-footer {
  position: relative;
  background: transparent;
  width: 100%;
  margin: 0 auto;
  padding: 0;
}

/* Main Footer */
.footer-main {
  background: #f8f9fa;
  border-top: 1px solid #e9ecef;
  padding: 3rem 0 2rem;
  display: none;
}

.footer-content {
  display: grid;
  grid-template-columns: 2fr 3fr;
  gap: 3rem;
  max-width: 1400px;
  margin: 0 auto;
}

/* Footer Brand */
.footer-brand {
  color: #333;
}

.footer-logo {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.footer-logo-img {
  width: 50px;
  height: auto;
  object-fit: contain;
}

.footer-logo-text {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.footer-logo-main {
  font-size: 1.5rem;
  font-weight: 700;
  color: #01a89e;
  letter-spacing: 2px;
  line-height: 1;
}

.footer-logo-sub {
  font-size: 0.75rem;
  color: #666;
  font-weight: 500;
  letter-spacing: 0.5px;
  margin-top: 2px;
  text-transform: uppercase;
}

.footer-tagline {
  font-size: 0.9rem;
  color: #666;
  line-height: 1.5;
  margin: 0;
}

/* Footer Navigation */
.footer-nav {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
}

.nav-section h4 {
  color: #01a89e;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 1rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.nav-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.nav-links li {
  margin-bottom: 0.75rem;
}

.nav-links a {
  color: #666;
  text-decoration: none;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  display: block;
}

.nav-links a:hover {
  color: #01a89e;
  transform: translateX(5px);
}

/* Footer Bottom */
.footer-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 2rem;
  border-top: 1px solid #e9ecef;
}

.footer-legal {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.footer-legal p {
  color: #666;
  font-size: 0.85rem;
  margin: 0;
}

.legal-links {
  display: flex;
  gap: 1.5rem;
}

.legal-links a {
  color: #666;
  text-decoration: none;
  font-size: 0.85rem;
  transition: all 0.3s ease;
}

.legal-links a:hover {
  color: #01a89e;
  text-decoration: underline;
}

/* Social Links */
.footer-social {
  display: flex;
  gap: 1rem;
}

.social-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background: rgba(1, 168, 158, 0.1);
  border-radius: 10px;
  color: #01a89e;
  text-decoration: none;
  transition: all 0.3s ease;
  border: 1px solid rgba(1, 168, 158, 0.2);
}

.social-link:hover {
  background: rgba(1, 168, 158, 0.2);
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(1, 168, 158, 0.3);
}

.social-link i {
  font-size: 1rem;
}

/* Mobile Navigation */
.mobile-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: #ffffff;
  border-top: 1px solid #e9ecef;
  z-index: 1000;
  box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1);
}

.mobile-nav-container {
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 0.75rem 0;
}

.mobile-nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.25rem;
  padding: 0.5rem;
  border-radius: 8px;
  text-decoration: none;
  color: #666;
  transition: all 0.3s ease;
  min-width: 60px;
}

.mobile-nav-item:hover,
.mobile-nav-item.router-link-active {
  color: #01a89e;
  background: rgba(1, 168, 158, 0.08);
}

.mobile-nav-icon {
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #01a89e;
  font-size: 1.1rem;
}

.mobile-nav-item span {
  font-size: 0.7rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Responsive Design */
@media (min-width: 1024px) {
  .footer-main {
    display: block;
  }

  .mobile-nav {
    display: none;
  }
}

@media (max-width: 768px) {
  .footer-content {
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  .footer-nav {
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
  }

  .footer-bottom {
    flex-direction: column;
    gap: 1.5rem;
    text-align: center;
  }

  .footer-social {
    justify-content: center;
  }

  .mobile-nav-container {
    padding: 0.5rem 0;
  }
}

@media (max-width: 480px) {
  .footer-main {
    padding: 2rem 0 1rem;
  }

  .footer-content {
    gap: 1.5rem;
  }

  .footer-logo-img {
    width: 40px;
  }

  .footer-logo-main {
    font-size: 1.25rem;
  }

  .footer-logo-sub {
    display: none;
  }

  .footer-tagline {
    font-size: 0.8rem;
  }

  .nav-section h4 {
    font-size: 1rem;
  }

  .nav-links a {
    font-size: 0.85rem;
  }

  .legal-links {
    flex-direction: column;
    gap: 1rem;
    justify-content: center;
  }

  .mobile-nav-item {
    padding: 0.375rem;
    min-width: 50px;
  }

  .mobile-nav-icon {
    width: 20px;
    height: 20px;
    font-size: 1rem;
  }

  .mobile-nav-item span {
    font-size: 0.65rem;
  }
}
</style>
