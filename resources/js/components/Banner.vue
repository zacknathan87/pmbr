<template>
  <div class="block banner-case" v-if="banner">
        <el-carousel class="banner" trigger="click" height="200px" arrow="never">
          <el-carousel-item v-for="(v, i) in banner" :key="i">
            <div
              v-if="v.type == 'image'"
              class="banner-item"
              :style="
                'background-image: url(uploads/banners/' + v.filename + ')'
              "
            ></div>
            <div v-if="v.type == 'video'" class="banner-item">
              <video autoplay  muted loop webkit-playsinline playsinline style="width: 100%; margin-top: -50px">
                <source
                  :src="'/uploads/banners/' + v.filename"
                  type="video/mp4"
                />
                Your browser does not support the video tag.
              </video>
            </div></el-carousel-item
          >
        </el-carousel>
      </div>
</template>

<script>
export default {

  data() {
    return {

      loading: true,
      banner: [],
    }
  },
  methods: {

    getBanner() {
      axios.get("/misc/banner").then((response) => {
        this.banner = response.data.data;
      });

      this.loading = false;
    },
  },
  mounted() {

    this.getBanner();
  }

}
</script>

<style>

</style>