<template>
  <div>
    <el-dropdown trigger="click">
      <span class="el-dropdown-link">
        <img
          :src="'/img/flags/' + this.$root.$i18n.locale + '.svg'"
          width="25px"
          style="display: inline-block; margin: 5px auto"
        />
       
      </span>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item
          v-for="locale in locales"
          :key="locale"
          @click.native="switchLocale(locale)"
        >
          <img
            :src="'/img/flags/' + locale + '.svg'"
            width="30px"
            style="display: block; margin: 5px auto"
          />
        </el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
  </div>
</template>

<script>
import CryptoJS from "crypto-js";
export default {
  data() {
    return {
      user: {},
      tawkApiKey: `${process.env.MIX_TAWK_API_KEY}`,
      locales: ["en", "zh"],
      tawkWidgetList: {
        en: "default",
        zh: "1ejs4ur4e",
      },
    };
  },
  name: "LanguageSwitcher",
  methods: {
    switchLocale(locale) {
      if (this.$root.$i18n.locale !== locale) {
        this.$root.$i18n.locale = locale;
        localStorage.setItem("lang", locale);
        this.setBackendLocale(locale);

        this.$Tawk.$changeWidget(this.tawkWidgetList[locale]);

        this.user = this.$auth.user();

        if (this.user) {
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
        }
      }
    },
    setBackendLocale(locale) {
      axios.get("/locale/" + locale).then((response) => {});
    },
  },
  mounted() {
    console.log(this.$Tawk);
  },
};
</script>

<style scoped>
.el-dropdown-link {
  color: #000 !important;
  padding: 10px;
  border-radius: 5px;
  display:flex;
}
</style>
