<template>
  <div id="main" :class="{ 'full-width-layout': isHomePage }">
    <app-header></app-header>

    <el-container class="main-content" :class="{ 'full-width': isHomePage }">
      <div class="app-container" :class="{ 'container-full': isHomePage }">
        <router-view></router-view>
      </div>
    </el-container>

    <app-footer></app-footer>
  </div>
</template>

<script>
import navigationMenu from "../components/Menu.vue";
import CryptoJS from "crypto-js";

export default {
  data() {
    return {
      user: {},
      tawkApiKey: `${process.env.MIX_TAWK_API_KEY}`,
    };
  },
  components: {
    navigationMenu,
  },
  computed: {
    isHomePage() {
      return this.$route.path === '/home' || this.$route.path === '/';
    }
  },
  methods: {
    setTawk() {
      this.user = this.$auth.user();

      var hashed = CryptoJS.HmacSHA256(this.user.email, this.tawkApiKey);
      var hashInBase64 = CryptoJS.enc.Base64.stringify(hashed);

      let payload = {
        name: this.user.username,
        email: this.user.email,
        emailHmac: hashInBase64,
        username: this.user.username,
        userId: this.user.id,
      };
      this.$Tawk.$updateChatUser(payload);
    },
  },
  mounted() {
    if (this.$auth.user()) {
      this.setTawk();
    }
  },
};
</script>

<style>
.el-dropdown-link-custom {
  color: #fff !important;
  padding: 10px;
  border-radius: 5px;
  background: #000 !important;
}

/* Full-width layout for home page */
.full-width-layout {
  width: 100%;
}

.full-width-layout .main-content.full-width {
  width: 100%;
  max-width: none;
}

.full-width-layout .app-container.container-full {
  max-width: 100%;
  width: 100%;
  padding: 0;
}

</style>