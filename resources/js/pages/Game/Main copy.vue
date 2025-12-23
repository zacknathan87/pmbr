<template>
  <div class="page-content">
    <div class="loader" v-loading="loading" element-loading-background="rgba(0, 0, 0, 0.7)"></div>

    <el-row :gutter="20">
      <el-col :span="12" v-for="g in gameChannel" :key="g['id']">
        <router-link :to="'/game/'+g['uuid']">
          <el-card :body-style="{ padding: '0px' }" class="box-card">
            <div class="box-img-cover" :style="'background-image: url(/uploads/channels/'+g['cover_filename']+')'">
            </div>
            <div style="padding: 14px;">
              <span>{{ g['name'] }}</span>
            </div>
          </el-card>
        </router-link>
      </el-col>
    </el-row>
  </div>
</template>


<script>
export default {
  data() {
    return {
      loading: true,

      gameChannel: []
    };
  },
  created() {},
  methods: {
    getGameChannel() {
      axios.get("/misc/gameChannel").then(response => {
        this.gameChannel = response.data.data;

        this.loading = false;
      });
    },
    async checkUser() {
      console.log('work');
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
    this.$nextTick(function() {
      this.getGameChannel();
    });
  }
};
</script>

<style  scoped>
</style>

<style>
.box-card {
  margin-bottom: 20px;
}
</style>