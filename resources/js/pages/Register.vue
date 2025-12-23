<template>
  <div class="pmbr-register">
    <div class="pmbr-register-bg" :style="{ backgroundImage: 'url(/images/pmbr/login-bg-new.jpg)' }"></div>
    <div class="pmbr-register-overlay"></div>
    
    <div class="pmbr-register-container">
      <!-- Register Card -->
      <div class="pmbr-register-card">
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
          <h1 class="pmbr-register-title">Create Account</h1>
          <p class="pmbr-register-subtitle">Join our investment platform today</p>
        </div>

        <el-alert
          v-if="error"
          :title="error"
          type="error"
          effect="dark"
          class="pmbr-alert-error"
        />

        <el-form
          class="pmbr-register-form"
          :model="form"
          :rules="rules"
          ref="form"
        >
          <el-form-item
            label="Referral Code (Optional)"
            :class="{ 'is-error': $v.form.referrer.$error }"
          >
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-users"></i>
              <el-input
                type="text"
                v-model="form.referrer"
                placeholder="Enter referral code"
                class="pmbr-input"
              />
            </div>
          </el-form-item>

          <el-form-item
            label="Full Name"
            :class="{ 'is-error': $v.form.name.$error }"
            required
          >
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-user"></i>
              <el-input
                type="text"
                v-model="form.name"
                placeholder="Enter your full name"
                class="pmbr-input"
              />
            </div>
          </el-form-item>

          <el-form-item
            label="Username"
            :class="{ 'is-error': $v.form.username.$error }"
            required
          >
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-at"></i>
              <el-input
                type="text"
                v-model="form.username"
                placeholder="Choose a username"
                class="pmbr-input"
              />
            </div>
          </el-form-item>

          <el-form-item
            label="Country"
            :class="{ 'is-error': $v.form.country.$error }"
            required
          >
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-globe"></i>
              <el-select
                v-model="form.country"
                placeholder="Select your country"
                class="pmbr-select"
              >
                <el-option label="Malaysia" value="2">Malaysia</el-option>
                <el-option label="Singapore" value="3">Singapore</el-option>
                <el-option label="China" value="4">China</el-option>
                <el-option label="Australia" value="5">Australia</el-option>
                <el-option label="Thailand" value="6">Thailand</el-option>
                <el-option label="Brunei" value="7">Brunei</el-option>
                <el-option label="New Zealand" value="8">New Zealand</el-option>
                <el-option label="Cambodia" value="9">Cambodia</el-option>
                <el-option label="Philippines" value="10">Philippines</el-option>
                <el-option label="Hong Kong" value="11">Hong Kong</el-option>
                <el-option label="Macau" value="12">Macau</el-option>
              </el-select>
            </div>
          </el-form-item>

          <el-form-item
            label="Password"
            :class="{ 'is-error': $v.form.password.$error }"
            required
          >
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-lock"></i>
              <el-input
                type="password"
                v-model="form.password"
                placeholder="Create a strong password"
                class="pmbr-input"
              />
            </div>
            <div class="pmbr-password-requirements">
              <small class="pmbr-requirements-text">
                Password must contain:
              </small>
              <ul class="pmbr-requirements-list">
                <li :class="{ 'met': hasUpperCase }">
                  <i :class="`fas fa-${hasUpperCase ? 'check' : 'times'}`"></i>
                  Uppercase letter
                </li>
                <li :class="{ 'met': hasLowerCase }">
                  <i :class="`fas fa-${hasLowerCase ? 'check' : 'times'}`"></i>
                  Lowercase letter
                </li>
                <li :class="{ 'met': hasSymbol }">
                  <i :class="`fas fa-${hasSymbol ? 'check' : 'times'}`"></i>
                  Symbol (!@#$%)
                </li>
              </ul>
            </div>
          </el-form-item>

          <el-form-item
            label="Confirm Password"
            :class="{ 'is-error': $v.form.confirmPassword.$error }"
            required
          >
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-lock"></i>
              <el-input
                type="password"
                v-model="form.confirmPassword"
                placeholder="Confirm your password"
                class="pmbr-input"
              />
            </div>
          </el-form-item>

          <el-form-item
            label="Phone Number"
            :class="{ 'is-error': $v.form.contact.$error }"
            required
          >
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-phone"></i>
              <el-input
                type="text"
                v-model="form.contact"
                placeholder="Enter your phone number"
                class="pmbr-input"
              />
            </div>
          </el-form-item>

          <el-form-item
            label="Identification Number"
            :class="{ 'is-error': $v.form.nric.$error }"
            required
          >
            <div class="pmbr-input-wrapper">
              <i class="pmbr-input-icon fas fa-id-card"></i>
              <el-input
                type="text"
                v-model="form.nric"
                placeholder="Enter your ID number"
                class="pmbr-input"
              />
            </div>
          </el-form-item>

          <el-form-item>
            <el-button
              :loading="formSubmitting"
              @click="submit"
              class="pmbr-btn-register"
              type="primary"
              block
            >
              <span v-if="!formSubmitting">Create Account</span>
              <span v-else>Creating Account...</span>
            </el-button>
          </el-form-item>
        </el-form>

        <div class="pmbr-register-footer">
          <p class="pmbr-footer-text">Already have an account?</p>
          <router-link to="/login" class="pmbr-login-link">
            Sign In
          </router-link>
        </div>
      </div>

      <!-- Features Sidebar -->
      <div class="pmbr-features-sidebar">
        <div class="pmbr-feature-item">
          <div class="pmbr-feature-icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="pmbr-feature-content">
            <h3>Real-time Analytics</h3>
            <p>Track your bids with live updates</p>
          </div>
        </div>

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
            <i class="fas fa-gem"></i>
          </div>
          <div class="pmbr-feature-content">
            <h3>Premium Features</h3>
            <p>Access exclusive bidding opportunities</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { required, sameAs } from "vuelidate/lib/validators";

// Custom password strength validator
const passwordStrength = (value) => {
  if (!value) return false;
  // Must contain at least one uppercase letter, one lowercase letter, and one symbol
  const hasUpperCase = /[A-Z]/.test(value);
  const hasLowerCase = /[a-z]/.test(value);
  const hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value);
  return hasUpperCase && hasLowerCase && hasSymbol;
};

const validations = {
  form: {
    name: { required },
    nric: { required },
    username: { required },
    password: { required, passwordStrength },
    confirmPassword: { required, sameAsPassword: sameAs("password") },
    contact: { required },
    country: { required },
    referrer: {},
  },
};

export default {
  name: "register",
  data() {
    return {
      appName: process.env.MIX_APP_NAME,
      referrer: {},
      form: {
        parent_id: "",
        name: "",
        nric: "",
        username: "",
        password: "",
        confirmPassword: "",
        contact: "",
        referrer: "",
        country: "",
      },
      error: "",
      loading: false,
      formSubmitting: false,
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
          {
            validator: (rule, value, callback) => {
              if (!value) {
                callback();
                return;
              }
              const hasUpperCase = /[A-Z]/.test(value);
              const hasLowerCase = /[a-z]/.test(value);
              const hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value);

              if (!hasUpperCase) {
                callback(new Error("Password must contain at least one uppercase letter"));
                return;
              }
              if (!hasLowerCase) {
                callback(new Error("Password must contain at least one lowercase letter"));
                return;
              }
              if (!hasSymbol) {
                callback(new Error("Password must contain at least one symbol"));
                return;
              }
              callback();
            },
            trigger: "blur"
          }
        ],
        name: [
          { required: true, message: "Full name is required", trigger: "blur" },
        ],
        country: [
          { required: true, message: "Country is required", trigger: "change" },
        ],
        contact: [
          { required: true, message: "Phone number is required", trigger: "blur" },
        ],
        nric: [
          { required: true, message: "Identification number is required", trigger: "blur" },
        ],
      },
    };
  },
  validations: validations,
  computed: {
    // Password validation checks computed properties
    hasUpperCase() {
      return /[A-Z]/.test(this.form.password);
    },
    hasLowerCase() {
      return /[a-z]/.test(this.form.password);
    },
    hasSymbol() {
      return /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(this.form.password);
    },
  },
  methods: {
    submit() {
      this.formSubmitting = true;
      this.$v.form.$touch();
      if (this.$v.form.$error) {
        this.formSubmitting = false;
        return;
      }

      let formData = new FormData();
      formData.append("name", this.form.name);
      formData.append("nric", this.form.nric);
      formData.append("username", this.form.username);
      formData.append("contact", this.form.contact);
      formData.append("password", this.form.password);
      formData.append("confirm_password", this.form.confirmPassword);
      formData.append("parent_id", this.form.parent_id);
      formData.append("referrer", this.form.referrer);
      formData.append("country", this.form.country);

      axios.post("/auth/register", formData).then((response) => {
        if (response.data.status === 1) {
          this.$store
            .dispatch("auth/login", {
              data: this.form,
              remember: this.form.remember,
              fetchUser: this.form.fetchUser,
              staySignedIn: true,
            })
            .then(null, (res) => {
              if (res.response.data.status == 0) {
                this.error = res.response.data.error;
              }
            });
        } else {
          this.$alert(response.data.errors, "Error", {
            confirmButtonText: "OK",
            type: "error",
          });

          this.formSubmitting = false;
        }
      });

      return true;
    },
    invalidReferrer() {
      this.$confirm("Invalid Referrer", "Error", {
        confirmButtonText: "OK",
        showCancelButton: false,
        type: "danger",
      })
        .then(() => {
          this.$router.push("/login");
        })
        .catch(() => {
          this.$router.push("/login");
        });
    },
    getReferrer(referrer) {
      axios.get("/misc/referrer/" + referrer).then((response) => {
        if (response.data.status == 1) {
          this.referrer = response.data.data;
          this.form.parent_id = this.referrer.id;
          this.form.referrer = this.referrer.username;
        } else {
          this.invalidReferrer();
        }

        this.loading = false;
      });
    },
  },
  mounted() {
    if (this.$route.params.referrer) {
      this.getReferrer(this.$route.params.referrer);
    }
  },
};
</script>

<style scoped>
/* PMBR Register Page - Modern Redesign */
.pmbr-register {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow-y: auto;
  padding: 2rem 1rem;
}

.pmbr-register-bg {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  z-index: -1;
}

.pmbr-register-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(1, 168, 158, 0.92) 0%, rgba(1, 168, 158, 0.85) 100%);
  backdrop-filter: blur(8px);
  z-index: 0;
}

.pmbr-register-container {
  display: flex;
  width: 100%;
  max-width: 1400px;
  min-height: 700px;
  position: relative;
  z-index: 10;
  gap: 3rem;
}

/* Register Card */
.pmbr-register-card {
  flex: 1;
  max-width: 520px;
  background: rgba(255, 255, 255, 0.98);
  border-radius: 20px;
  padding: 1.5rem;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  max-height: 90vh;
  overflow-y: auto;
}

/* Logo Section */
.pmbr-logo-section {
  text-align: center;
  margin-bottom: 1rem;
}

.pmbr-logo-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
}

.pmbr-logo-img {
  width: 100px;
  height: auto;
  object-fit: contain;
}

.pmbr-logo-text {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.pmbr-logo-main {
  font-size: 1.5rem;
  font-weight: 800;
  color: #01a89e;
  letter-spacing: 2px;
  line-height: 1;
}

.pmbr-logo-sub {
  font-size: 0.65rem;
  color: #666;
  font-weight: 500;
  letter-spacing: 0.5px;
  margin-top: 0.25rem;
  text-transform: uppercase;
}

/* Card Header */
.pmbr-card-header {
  text-align: center;
  margin-bottom: 1.5rem;
}

.pmbr-register-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #01a89e;
  margin-bottom: 0.5rem;
  line-height: 1.2;
}

.pmbr-register-subtitle {
  font-size: 0.9rem;
  color: #666;
  margin: 0;
  line-height: 1.5;
}

/* Form Styles */
.pmbr-register-form {
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
  font-size: 1rem;
  z-index: 2;
}

.pmbr-input {
  width: 100%;
}

.pmbr-input >>> .el-input__inner {
  background: #f8f9fa;
  border: 2px solid #e9ecef;
  border-radius: 10px;
  color: #333;
  padding: 0.75rem 1rem 0.75rem 2.75rem;
  font-size: 0.95rem;
  font-weight: 500;
  transition: all 0.3s ease;
  height: 48px;
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

.pmbr-select {
  width: 100%;
}

.pmbr-select >>> .el-input__inner {
  background: #f8f9fa;
  border: 2px solid #e9ecef;
  border-radius: 10px;
  color: #333;
  padding: 0.75rem 1rem 0.75rem 2.75rem;
  font-size: 0.95rem;
  font-weight: 500;
  transition: all 0.3s ease;
  height: 48px;
}

.pmbr-select >>> .el-input__inner:focus {
  border-color: #01a89e;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(1, 168, 158, 0.1);
}

/* Alert Styles */
.pmbr-alert-error {
  background: rgba(220, 53, 69, 0.1);
  border: 1px solid rgba(220, 53, 69, 0.3);
  border-radius: 10px;
  color: #dc3545;
  margin-bottom: 1.5rem;
  backdrop-filter: blur(10px);
}

/* Button Styles */
.pmbr-btn-register {
  margin-bottom: 1rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  background: linear-gradient(135deg, #01a89e 0%, #016f68 100%);
  border: none;
  border-radius: 10px;
  height: 48px;
  font-size: 1rem;
  box-shadow: 0 8px 20px rgba(1, 168, 158, 0.3);
  transition: all 0.3s ease;
}

.pmbr-btn-register:hover {
  background: linear-gradient(135deg, #016f68 0%, #01a89e 100%);
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(1, 168, 158, 0.4);
}

.pmbr-btn-register:active {
  transform: translateY(0);
}

/* Footer Styles */
.pmbr-register-footer {
  text-align: center;
  padding-top: 1.5rem;
  border-top: 1px solid #e9ecef;
}

.pmbr-footer-text {
  color: #666;
  font-size: 0.9rem;
  margin: 0 0 0.75rem 0;
}

.pmbr-login-link {
  color: #01a89e;
  font-weight: 600;
  text-decoration: none;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  display: inline-block;
}

.pmbr-login-link:hover {
  color: #016f68;
  text-decoration: underline;
}

/* Features Sidebar */
.pmbr-features-sidebar {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1.5rem;
  padding: 2rem;
}

.pmbr-feature-item {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1.25rem;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 14px;
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
  width: 48px;
  height: 48px;
  background: rgba(1, 168, 158, 0.2);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #01a89e;
  font-size: 1.25rem;
  flex-shrink: 0;
  border: 1px solid rgba(1, 168, 158, 0.3);
}

.pmbr-feature-content h3 {
  font-size: 1rem;
  font-weight: 700;
  color: #ffffff;
  margin: 0 0 0.5rem 0;
  line-height: 1.3;
}

.pmbr-feature-content p {
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.8);
  margin: 0;
  line-height: 1.4;
}

/* Password Requirements */
.pmbr-password-requirements {
  margin-top: 0.5rem;
  padding: 0.75rem;
  background: rgba(1, 168, 158, 0.08);
  border-radius: 8px;
  border: 1px solid rgba(1, 168, 158, 0.15);
}

.pmbr-requirements-text {
  color: #666;
  font-size: 0.8rem;
  font-weight: 500;
  margin-bottom: 0.5rem;
  display: block;
}

.pmbr-requirements-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.pmbr-requirements-list li {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.8rem;
  color: #dc3545;
  transition: color 0.3s ease;
}

.pmbr-requirements-list li.met {
  color: #28a745;
}

.pmbr-requirements-list li i {
  font-size: 0.65rem;
  width: 12px;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .pmbr-register-container {
    flex-direction: column;
    gap: 2rem;
    padding: 1rem;
  }

  .pmbr-register-card {
    max-width: 100%;
    padding: 2rem;
    max-height: none;
  }

  .pmbr-features-sidebar {
    display: none;
  }

  .pmbr-register-title {
    font-size: 1.5rem;
  }

  .pmbr-logo-main {
    font-size: 1.5rem;
  }
}

@media (max-width: 768px) {
  .pmbr-register {
    padding: 0.5rem;
  }

  .pmbr-register-card {
    padding: 1.5rem;
    border-radius: 16px;
  }

  .pmbr-register-title {
    font-size: 1.25rem;
  }

  .pmbr-logo-img {
    width: 50px;
  }

  .pmbr-logo-main {
    font-size: 1.25rem;
  }

  .pmbr-btn-register,
  .pmbr-input >>> .el-input__inner,
  .pmbr-select >>> .el-input__inner {
    height: 44px;
    font-size: 0.9rem;
  }
}

@media (max-width: 480px) {
  .pmbr-register-card {
    padding: 1.25rem;
  }

  .pmbr-register-title {
    font-size: 1.1rem;
  }

  .pmbr-logo-main {
    font-size: 1.1rem;
  }

  .pmbr-btn-register {
    height: 40px;
    font-size: 0.85rem;
  }

  .pmbr-feature-item {
    padding: 1rem;
  }
}
</style>
