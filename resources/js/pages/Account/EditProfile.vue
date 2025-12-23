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
      <div class="profile-header">
        <div class="header-card">
          <div class="header-content">
            <h1 class="header-title">{{ $t('app.edit_profile') }}</h1>
            <p class="header-subtitle">Update your personal information and banking details</p>
            <div class="header-actions">
              <router-link to="/account" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Form Container -->
      <div class="profile-container">
        <div class="profile-card">
          <el-form ref="form" label-position="top" :model="form">
               <el-form-item
                :label=" $t('app.username')"
                disabled
              >
                <el-input type="text" disabled :value="this.$auth.user().username"></el-input>
              </el-form-item>

              <el-form-item
                :label="$t('app.name')"
                :class="{ 'is-error': $v.form.name.$error }"
                required
              >
                <el-input type="text" v-model="form.name"></el-input>
                <vuelidate-input-error
                  v-if="$v.form.name.$error"
                  :validation-object="$v.form.name"
                  :field-label="$t('app.name')"
                ></vuelidate-input-error>
              </el-form-item>

              <el-form-item
                :label="$t('app.contact')"
                :class="{ 'is-error': $v.form.contact.$error }"
                required
              >
                <el-input type="text" v-model="form.contact"></el-input>
                <vuelidate-input-error
                  v-if="$v.form.contact.$error"
                  :validation-object="$v.form.contact"
                  :field-label="$t('app.contact')"
                ></vuelidate-input-error>
              </el-form-item>


              <el-form-item
                :label="$t('app.nric')"
                :class="{ 'is-error': $v.form.nric.$error }"
                required
              >
                <el-input type="text" v-model="form.nric"></el-input>
                <vuelidate-input-error
                  v-if="$v.form.nric.$error"
                  :validation-object="$v.form.nric"
                  :field-label="$t('app.nric')"
                ></vuelidate-input-error>
              </el-form-item>

              <hr>

              <el-form-item
                :label="$t('app.bank_name')"
                :class="{ 'is-error': $v.form.bankName.$error }"
                required
              >
                <el-input type="text" v-model="form.bankName"></el-input>
                <vuelidate-input-error
                  v-if="$v.form.bankName.$error"
                  :validation-object="$v.form.bankName"
                  :field-label="$t('app.name')"
                ></vuelidate-input-error>
              </el-form-item>
              
              <el-form-item
                :label="$t('app.bank_account_name')"
                :class="{ 'is-error': $v.form.bankAccountName.$error }"
                required
              >
                <el-input type="text" v-model="form.bankAccountName"></el-input>
                <vuelidate-input-error
                  v-if="$v.form.bankAccountName.$error"
                  :validation-object="$v.form.bankAccountName"
                  :field-label="$t('app.bank_account_name')"
                ></vuelidate-input-error>
              </el-form-item>

                    
              <el-form-item
                :label="$t('app.bank_account_no')"
                :class="{ 'is-error': $v.form.bankAccountNo.$error }"
                required
              >
                <el-input type="text" v-model="form.bankAccountNo"></el-input>
                <vuelidate-input-error
                  v-if="$v.form.bankAccountNo.$error"
                  :validation-object="$v.form.bankAccountNo"
                  :field-label="$t('app.bank_account_no')"
                ></vuelidate-input-error>
              </el-form-item>

                  <el-form-item
                :label="$t('app.bank_swift_code')"
              >
                <el-input type="text" v-model="form.bankSwiftCode"></el-input>
                <vuelidate-input-error
                  v-if="$v.form.bankSwiftCode.$error"
                  :validation-object="$v.form.bankSwiftCode"
                  :field-label="$t('app.bank_swift_code')"
                ></vuelidate-input-error>
              </el-form-item>



              <div class="form-actions">
                <el-button
                  :loading="formSubmitting"
                  @click="submit"
                  class="update-btn"
                  type="primary"
                >
                  <i class="fas fa-save"></i>
                  {{ $t('app.update') }}
                </el-button>
              </div>
            </el-form>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import { required, sameAs } from "vuelidate/lib/validators";

const validations = {
  form: {
    name: { required },
    nric: { required },
    contact: { required },
    bankName: { required },
    bankAccountName: { required },
    bankAccountNo: { required },
    bankSwiftCode: {  },
  }
};

export default {
  data() {
    return {
      user: {},
      formSubmitting: false,
      form: {
        name: this.$auth.user().name,
        nric: this.$auth.user().nric,
        contact: this.$auth.user().contact,
        bankName: this.$auth.user().bank_name,
        bankAccountName: this.$auth.user().bank_account_name,
        bankAccountNo: this.$auth.user().bank_account_no,
        bankSwiftCode: this.$auth.user().bank_swift_code,
      },

      loading: true
    };
  },
  validations: validations,
  created() {},
  methods: {
    submit() {
      this.formSubmitting = true;
      this.$v.form.$touch();
      // if its still pending or an error is returned do not submit
      if (this.$v.form.$error) {
        this.formSubmitting = false;
        return;
      }

      let formData = new FormData();
      formData.append("name", this.form.name);
      formData.append("nric", this.form.nric);
      formData.append("contact", this.form.contact);
      formData.append("bank_name", this.form.bankName);
      formData.append("bank_account_name", this.form.bankAccountName);
      formData.append("bank_account_no", this.form.bankAccountNo);
      formData.append("bank_swift_code", this.form.bankSwiftCode);

      axios.post("/account/updateProfile", formData).then(response => {
        if (response.data.status === 1) {
          this.formSubmitting = false;
          this.$v.form.$reset();

          this.$alert("Profile Updated!", "Success", {
            confirmButtonText: "OK",
            type: "success"
          });
        } else {
          this.$alert(response.data.errors, "Error", {
            confirmButtonText: "OK",
            type: "error"
          });

          this.formSubmitting = false;
        }
      });

      return true;
    }
  },
  mounted() {
    this.loading = false;
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
.profile-header {
  margin-bottom: 24px;
  max-width: 800px;
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

/* Main Container */
.profile-container {
  max-width: 800px;
  margin: 0 auto;
}

.profile-card {
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(20px);
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

/* Form Styles */
.el-form--label-top .el-form-item__label {
  color: #01A89E;
  font-weight: 600;
  font-size: 0.95rem;
  margin-bottom: 8px;
  padding: 0;
  line-height: 1.4;
}

.el-form-item {
  margin-bottom: 24px;
}

.el-input__inner {
  background: rgba(255, 255, 255, 0.9);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 12px;
  color: #333333;
  font-size: 1rem;
  padding: 16px 20px;
  transition: all 0.3s ease;
}

.el-input__inner:focus {
  border-color: #01A89E;
  background: rgba(255, 255, 255, 0.95);
  box-shadow: 0 0 0 3px rgba(1, 168, 158, 0.1);
}

.el-input__inner::placeholder {
  color: #999999;
}

.el-input__inner:disabled {
  background: rgba(255, 255, 255, 0.7);
  color: #666666;
  border-color: rgba(0, 0, 0, 0.1);
  cursor: not-allowed;
}

/* Separator */
.profile-card hr {
  border: none;
  height: 1px;
  background: linear-gradient(90deg, transparent 0%, rgba(1, 168, 158, 0.3) 50%, transparent 100%);
  margin: 32px 0;
}

/* Form Actions */
.form-actions {
  display: flex;
  justify-content: center;
  margin-top: 40px;
}

.update-btn {
  background: linear-gradient(135deg, #01A89E 0%, #017f7a 100%);
  border: none;
  border-radius: 12px;
  padding: 16px 32px;
  font-size: 1.1rem;
  font-weight: 600;
  color: #ffffff;
  transition: all 0.3s ease;
  box-shadow: 0 4px 16px rgba(1, 168, 158, 0.3);
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.update-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 24px rgba(1, 168, 158, 0.4);
}

.update-btn:active {
  transform: translateY(0);
}

/* Responsive Design */
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

  .profile-card {
    padding: 24px;
  }

  .update-btn {
    width: 100%;
    justify-content: center;
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

  .el-input__inner {
    padding: 14px 16px;
    font-size: 0.95rem;
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