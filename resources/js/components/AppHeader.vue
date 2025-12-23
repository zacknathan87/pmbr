<template>
  <el-header class="top-bar">
    <div class="app-container" :class="{ 'container-full': isHomePage }">
      <div class="header-content" :class="{ 'content-full': isHomePage }">
        <!-- Logo Section -->
        <div class="logo-section">
          <router-link ref="link" to="/" class="logo-link">
            <div class="logo-wrapper">
              <img src="/images/pmbr/logo-new.png" alt="PMBR Logo" class="logo-image">
              <div class="logo-text">
                <span class="logo-main">PMBR</span>
              </div>
            </div>
          </router-link>
        </div>

        <!-- Navigation & Action Buttons -->
        <div class="action-buttons">
          <!-- Logged-in user navigation -->
          <div v-if="this.$auth.check()" class="user-nav">
            <router-link to="/trades" class="nav-link">
              <i class="fas fa-gamepad"></i>
              <span>Trades</span>
            </router-link>
            <router-link to="/result" class="nav-link">
              <i class="fas fa-chart-bar"></i>
              <span>Results</span>
            </router-link>
            <router-link to="/my-trades" class="nav-link">
              <i class="fas fa-history"></i>
              <span>My Trades</span>
            </router-link>
            <router-link to="/account" class="nav-link">
              <i class="fas fa-user-circle"></i>
              <span>Account</span>
            </router-link>
            <a href="#" @click="logout" class="nav-link logout-link">
              <i class="fas fa-sign-out-alt"></i>
              <span>Logout</span>
            </a>
          </div>

          <!-- Guest user buttons -->
          <router-link v-if="!this.$auth.check()" to="/register">
            <el-button class="btn-cyber-register" type="primary">
              <i class="fas fa-user-plus"></i>
              <span>{{ $t("app.register") }}</span>
            </el-button>
          </router-link>

          <router-link v-if="!this.$auth.check()" to="/login">
            <el-button class="btn-cyber-login" type="primary">
              <i class="fas fa-sign-in-alt"></i>
              <span>{{ $t("app.login") }}</span>
            </el-button>
          </router-link>

          <language-switcher />
        </div>
      </div>
    </div>
  </el-header>
</template>
<script>
export default {
   data() {
     return {
       appName: process.env.MIX_APP_NAME,
     };
   },
   computed: {
     isHomePage() {
       return this.$route.path === '/' || this.$route.path === '/home';
     }
   },
   methods: {
     logout() {
       this.$auth.logout();
       this.$router.push('/login');
     },
   },
};
</script>

<style scoped>
/* App Header - Modern Redesign */
.top-bar {
  background: #ffffff;
  border-bottom: 1px solid #e9ecef;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  height: 70px !important;
  position: relative;
  z-index: 1000;
}

.header-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100%;
  padding: 0 2rem;
}

/* Logo Section */
.logo-section {
  display: flex;
  align-items: center;
}

.logo-link {
  display: flex;
  align-items: center;
  text-decoration: none;
  transition: all 0.3s ease;
}

.logo-link:hover {
  transform: translateY(-2px);
}

.logo-wrapper {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.logo-image {
  width: 40px;
  height: auto;
  object-fit: contain;
}

.logo-text {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.logo-main {
  font-size: 1.5rem;
  font-weight: 800;
  color: #01a89e;
  letter-spacing: 2px;
  line-height: 1;
}

.logo-sub {
  font-size: 0.7rem;
  color: #666;
  font-weight: 500;
  letter-spacing: 0.5px;
  margin-top: 2px;
  text-transform: uppercase;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  align-items: center;
  gap: 1rem;
}

/* User Navigation */
.user-nav {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-right: 1rem;
}

.nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #01a89e;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.625rem 1rem;
            border-radius: 10px;
            background: #f8f9fa;
            border: 1px solid transparent;
            transition: all 0.3s ease;
            white-space: nowrap;
          }

.nav-link:hover {
  background: rgba(1, 168, 158, 0.1);
  border-color: rgba(1, 168, 158, 0.2);
  color: #016f68;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(1, 168, 158, 0.15);
}

.logout-link {
  color: #dc3545;
}

.logout-link:hover {
  background: rgba(220, 53, 69, 0.1);
  border-color: rgba(220, 53, 69, 0.2);
  color: #c53030;
  box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
}

.nav-link i {
  font-size: 1rem;
}

/* Button Styles */
.btn-cyber-register,
.btn-cyber-login {
  border: none;
  border-radius: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(1, 168, 158, 0.2);
  padding: 0.625rem 1.5rem;
  height: 42px;
}

.btn-cyber-register {
  background: linear-gradient(135deg, #01a89e 0%, #016f68 100%);
  color: #ffffff;
}

.btn-cyber-register:hover {
  background: linear-gradient(135deg, #016f68 0%, #01a89e 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(1, 168, 158, 0.3);
}

.btn-cyber-login {
  background: #ffffff;
  color: #01a89e;
  border: 2px solid #01a89e;
}

.btn-cyber-login:hover {
  background: #01a89e;
  color: #ffffff;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(1, 168, 158, 0.3);
}

.btn-cyber-register i,
.btn-cyber-login i {
  margin-right: 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .header-content {
    padding: 0 1rem;
  }

  .logo-image {
    width: 32px;
  }

  .logo-main {
    font-size: 1.25rem;
  }

  .logo-sub {
    display: none;
  }

  .user-nav {
    display: none;
  }

  .btn-cyber-register,
  .btn-cyber-login {
    padding: 0.5rem 1rem;
    height: 38px;
    font-size: 0.85rem;
  }

  .btn-cyber-register i,
  .btn-cyber-login i {
    margin-right: 0.375rem;
  }
}

@media (max-width: 480px) {
  .header-content {
    padding: 0 0.75rem;
  }

  .logo-image {
    width: 28px;
  }

  .logo-main {
    font-size: 1.1rem;
    letter-spacing: 1px;
  }

  .nav-link {
    padding: 0.5rem 0.75rem;
    font-size: 0.85rem;
  }

  .nav-link span {
    display: none;
  }

  .nav-link i {
    margin-right: 0;
  }

  .btn-cyber-register,
  .btn-cyber-login {
    padding: 0.5rem 0.75rem;
    height: 36px;
    font-size: 0.8rem;
  }

  .btn-cyber-register span,
  .btn-cyber-login span {
    display: inline;
  }
}
</style>
