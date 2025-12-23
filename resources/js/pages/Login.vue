<template>
  <div class="pmbr-login">
    <div class="pmbr-login-bg" :style="{ backgroundImage: 'url(/images/pmbr/login-bg-new.jpg)' }"></div>
    <div class="pmbr-login-overlay"></div>
    
    <div class="pmbr-login-container">
      <!-- Login Card -->
      <div class="pmbr-login-card">
        <!-- Logo Section -->
        <div class="pmbr-logo-section">
          <div class="pmbr-logo-wrapper">
            <img src="/images/pmbr/logo-new.png" alt="PMBR Logo" class="pmbr-logo-img">
            <div class="pmbr-logo-text">
              <span class="pmbr-logo-main">PMBR</span>
              <span class="pmbr-logo-sub">Petro Malaysia Bid Round</span>
            </div>
          </div>
        </div>

        <div class="pmbr-card-header">
          <h1 class="pmbr-login-title">Welcome Back</h1>
          <p class="pmbr-login-subtitle">Sign in to access your account</p>
        </div>

        <el-alert
          v-if="error"
          :title="error"
          type="error"
          effect="dark"
          class="pmbr-alert-error"
        />

        <el-form
          class="pmbr-login-form"
          :model="form"
          :rules="rules"
          ref="form"
          @submit.native.prevent="login"
        >
          <el-form-item prop="username" class="pmbr-form-item">
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-user"></i>
              <el-input
                v-model="form.username"
                placeholder="Username"
                class="pmbr-input"
              />
            </div>
          </el-form-item>

          <el-form-item prop="password" class="pmbr-form-item">
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-lock"></i>
              <el-input
                v-model="form.password"
                placeholder="Password"
                type="password"
                class="pmbr-input"
              />
            </div>
          </el-form-item>

          <el-form-item class="pmbr-form-submit">
            <el-button
              :loading="loading"
              class="pmbr-btn-login"
              type="primary"
              native-type="submit"
              block
            >
              <span v-if="!loading">Sign In</span>
              <span v-else>Signing In...</span>
            </el-button>
          </el-form-item>
        </el-form>

        <div class="pmbr-login-footer">
          <p class="pmbr-footer-text">Don't have an account?</p>
          <router-link to="/register" class="pmbr-register-link">
            Create Account
          </router-link>
        </div>
      </div>

      <!-- Features Sidebar -->
      <div class="pmbr-features-sidebar">
        <div class="pmbr-feature-item">
          <div class="pmbr-feature-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <div class="pmbr-feature-content">
            <h3>Secure Platform</h3>
            <p>256-bit encryption for your data protection</p>
          </div>
        </div>

        <div class="pmbr-feature-item">
          <div class="pmbr-feature-icon">
            <i class="fas fa-bolt"></i>
          </div>
          <div class="pmbr-feature-content">
            <h3>Fast Transactions</h3>
            <p>Instant processing for all your bids</p>
          </div>
        </div>

        <div class="pmbr-feature-item">
          <div class="pmbr-feature-icon">
            <i class="fas fa-headset"></i>
          </div>
          <div class="pmbr-feature-content">
            <h3>24/7 Support</h3>
            <p>Expert assistance whenever you need it</p>
          </div>
        </div>

        <div class="pmbr-feature-item">
          <div class="pmbr-feature-icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="pmbr-feature-content">
            <h3>Real-time Analytics</h3>
            <p>Track your bids with live updates</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "login",
  data() {
    return {
      appName: process.env.MIX_APP_NAME,
      validCredentials: {
        username: "lightscope",
        password: "lightscope",
      },
      form: {
        username: "",
        password: "",
      },
      error: "",
      loading: false,
      rules: {
        username: [
          {
            required: true,
            message: "Username is required",
            trigger: "blur",
          },
        ],
        password: [
          { required: true, message: "Password is required", trigger: "blur" },
        ],
      },
    };
  },
  methods: {
    translateAuthErrorMessage(message) {
      // Backend sometimes returns a localized string (e.g. Chinese).
      // Always display error in the current UI language.
      const normalized = (message || "").toString().trim();

      const map = {
        // Custom backend message
        "用户名和密码不匹配": "app.did_not_match",
        // English variants we also normalize
        "Username and password did not match.": "app.did_not_match",
        // Laravel default
        "These credentials do not match our records.": "auth.failed",
      };

      const key = map[normalized];
      if (key && this.$te && this.$te(key)) return this.$t(key);
      if (key) return this.$t(key);

      return normalized;
    },
    login() {
      this.loading = true;
      this.$store
        .dispatch("auth/login", {
          data: this.form,
          remember: this.form.remember,
          fetchUser: this.form.fetchUser,
          staySignedIn: true,
        })
        .then(null, (res) => {
          this.loading = false;

          const responseData = res?.response?.data || {};
          const backendError = responseData.error || responseData.message;

          if (backendError) {
            this.error = this.translateAuthErrorMessage(backendError);
            return;
          }

          // fallback for legacy response shape
          if (responseData.status == 0 && responseData.error) {
            this.error = this.translateAuthErrorMessage(responseData.error);
          }
        });
    },
  },
};
</script>

<style scoped>
/* PMBR Login Page - Modern Redesign */
.pmbr-login {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.pmbr-login-bg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.pmbr-login-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(1, 168, 158, 0.92) 0%, rgba(1, 168, 158, 0.85) 100%);
  backdrop-filter: blur(8px);
}

.pmbr-login-container {
  display: flex;
  width: 100%;
  max-width: 1200px;
  min-height: 600px;
  position: relative;
  z-index: 10;
  padding: 2rem;
  gap: 3rem;
}

/* Login Card */
.pmbr-login-card {
  flex: 1;
  max-width: 480px;
  background: rgba(255, 255, 255, 0.98);
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Logo Section */
.pmbr-logo-section {
  text-align: center;
  margin-bottom: 1.5rem;
}

.pmbr-logo-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
}

.pmbr-logo-img {
  width: 120px;
  height: auto;
  object-fit: contain;
}

.pmbr-logo-text {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.pmbr-logo-main {
  font-size: 2rem;
  font-weight: 800;
  color: #01a89e;
  letter-spacing: 3px;
  line-height: 1;
}

.pmbr-logo-sub {
  font-size: 0.75rem;
  color: #666;
  font-weight: 500;
  letter-spacing: 1px;
  margin-top: 0.25rem;
  text-transform: uppercase;
}

/* Card Header */
.pmbr-card-header {
  text-align: center;
  margin-bottom: 2rem;
}

.pmbr-login-title {
  font-size: 2rem;
  font-weight: 700;
  color: #01a89e;
  margin-bottom: 0.5rem;
  line-height: 1.2;
}

.pmbr-login-subtitle {
  font-size: 0.95rem;
  color: #666;
  margin: 0;
  line-height: 1.5;
}

/* Form Styles */
.pmbr-login-form {
  margin-bottom: 2rem;
}

.pmbr-form-item {
  margin-bottom: 1.5rem;
}

.pmbr-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.pmbr-input-icon {
  position: absolute;
  left: 1rem;
  color: #01a89e;
  font-size: 1.1rem;
  z-index: 2;
}

.pmbr-input {
  width: 100%;
}

.pmbr-input >>> .el-input__inner {
  background: #f8f9fa;
  border: 2px solid #e9ecef;
  border-radius: 12px;
  color: #333;
  padding: 0.875rem 1rem 0.875rem 3rem;
  font-size: 1rem;
  font-weight: 500;
  transition: all 0.3s ease;
  height: 52px;
}

.pmbr-input >>> .el-input__inner:focus {
  border-color: #01a89e;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(1, 168, 158, 0.1);
}

.pmbr-input >>> .el-input__inner::placeholder {
  color: #999;
  font-weight: 400;
}

/* Alert Styles */
.pmbr-alert-error {
  background: rgba(220, 53, 69, 0.1);
  border: 1px solid rgba(220, 53, 69, 0.3);
  border-radius: 12px;
  color: #dc3545;
  margin-bottom: 1.5rem;
  backdrop-filter: blur(10px);
}

/* Button Styles */
.pmbr-btn-login {
  margin-bottom: 1rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  background: linear-gradient(135deg, #01a89e 0%, #016f68 100%);
  border: none;
  border-radius: 12px;
  height: 52px;
  font-size: 1rem;
  box-shadow: 0 8px 20px rgba(1, 168, 158, 0.3);
  transition: all 0.3s ease;
}

.pmbr-btn-login:hover {
  background: linear-gradient(135deg, #016f68 0%, #01a89e 100%);
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(1, 168, 158, 0.4);
}

.pmbr-btn-login:active {
  transform: translateY(0);
}

/* Footer Styles */
.pmbr-login-footer {
  text-align: center;
  padding-top: 1.5rem;
  border-top: 1px solid #e9ecef;
}

.pmbr-footer-text {
  color: #666;
  font-size: 0.9rem;
  margin: 0 0 0.75rem 0;
}

.pmbr-register-link {
  color: #01a89e;
  font-weight: 600;
  text-decoration: none;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  display: inline-block;
}

.pmbr-register-link:hover {
  color: #016f68;
  text-decoration: underline;
}

/* Features Sidebar */
.pmbr-features-sidebar {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 2rem;
  padding: 2rem;
}

.pmbr-feature-item {
  display: flex;
  align-items: flex-start;
  gap: 1.25rem;
  padding: 1.5rem;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(10px);
  transition: all 0.3s ease;
}

.pmbr-feature-item:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: translateX(8px);
  border-color: rgba(1, 168, 158, 0.3);
}

.pmbr-feature-icon {
  width: 56px;
  height: 56px;
  background: rgba(1, 168, 158, 0.2);
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #01a89e;
  font-size: 1.5rem;
  flex-shrink: 0;
  border: 1px solid rgba(1, 168, 158, 0.3);
}

.pmbr-feature-content h3 {
  font-size: 1.1rem;
  font-weight: 700;
  color: #ffffff;
  margin: 0 0 0.5rem 0;
  line-height: 1.3;
}

.pmbr-feature-content p {
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.8);
  margin: 0;
  line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .pmbr-login-container {
    flex-direction: column;
    gap: 2rem;
    padding: 1rem;
  }

  .pmbr-login-card {
    max-width: 100%;
    padding: 2rem;
  }

  .pmbr-features-sidebar {
    display: none;
  }

  .pmbr-login-title {
    font-size: 1.75rem;
  }

  .pmbr-logo-main {
    font-size: 1.75rem;
  }
}

@media (max-width: 768px) {
  .pmbr-login-container {
    padding: 0.5rem;
  }

  .pmbr-login-card {
    padding: 1.5rem;
    border-radius: 16px;
  }

  .pmbr-login-title {
    font-size: 1.5rem;
  }

  .pmbr-logo-img {
    width: 60px;
  }

  .pmbr-logo-main {
    font-size: 1.5rem;
  }

  .pmbr-btn-login,
  .pmbr-input >>> .el-input__inner {
    height: 48px;
  }
}

@media (max-width: 480px) {
  .pmbr-login-card {
    padding: 1.25rem;
  }

  .pmbr-login-title {
    font-size: 1.25rem;
  }

  .pmbr-logo-main {
    font-size: 1.25rem;
  }

  .pmbr-btn-login {
    height: 44px;
    font-size: 0.9rem;
  }
}
</style>
