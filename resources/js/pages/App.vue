<template>
  <router-view></router-view>
</template>

<script>
export default {
  data() {
    return {
       user: {},
       tawkWidgetList: {
        en: "1evcbtc4i",
        zh: "1evcbtc4i",
      },
    };
  },
  methods: {
  },
  mounted() {

    // this.$Tawk.$createChat( this.tawkWidgetList[localStorage.getItem('lang')] )
  }
};
</script>