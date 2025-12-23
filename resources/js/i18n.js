import Vue from "vue";
import VueI18n from "vue-i18n";
import langData from './vue-i18n-locales.generated.js'
import enLocale from 'element-ui/lib/locale/lang/en'
import zhLocale from 'element-ui/lib/locale/lang/zh-CN'

Vue.use(VueI18n);


const messages = {
  en: {
    ...enLocale,
    ...langData.en,
  },
  zh: {
    ...zhLocale,
    ...langData.zh,
  }
}

export default new VueI18n({
  locale: localStorage.getItem('lang')||'en', // set locale
  messages, // set locale messages
});