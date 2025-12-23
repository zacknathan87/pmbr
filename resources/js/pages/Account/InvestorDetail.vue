<template>
  <div class="page-content">
    <div
      class="loader"
      v-if="loading"
      v-loading="loading"
      element-loading-background="rgba(0, 0, 0, 0.7)"
    ></div>

    <div v-if="!loading" style="position:relative;height:100%;padding: 15px">
      <el-row :gutter="20">
        <el-col :span="24">
          <div class="header-btn-case">
            <router-link to="/account">
              <el-button>
                <i class="fas fa-chevron-left"></i> {{ $t('app.back') }}
              </el-button>
            </router-link>
          </div>

          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span class="box-title">{{ $t('app.investor_details') }}</span>
            </div>
            <div v-if="investors.length > 0">
              <div class="investor-box" v-for="(item, i) in investors" :key="i">
                <div class="investor-name">{{ item.name }}</div>
                <div class="investor-bank-account">{{ item.bank_account_no }}</div>
                <div class="investor-bank">{{ item.bank_name }}</div>
              </div>
            </div>
            <div v-else>{{ $t('app.no_data') }}</div>
          </el-card>
        </el-col>
      </el-row>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      loading: true,
      investors: []
    };
  },
  created() {},
  methods: {
    getInvestors() {
      axios.get("/misc/investors").then(response => {
        this.investors = response.data.data;

        this.loading = false;
      });
    }
  },
  mounted() {
    // this.open();
    this.$nextTick(function() {
      this.getInvestors();
    });
  }
};
</script>


<style >
.page-title {
  font-size: 22px;
  margin-bottom: 15px;
}
.el-form--label-top .el-form-item__label {
  padding: 0;
  line-height: 12px;
}

.investor-box {
  padding: 15px 5px;
  margin-bottom: 15px;
  border-bottom: 1px solid #ccc;
  line-height: 1.2;
}
.investor-name {
  font-size: 16px;
  font-weight: bold;
}

.investor-bank {
  color: #666;
}
</style>