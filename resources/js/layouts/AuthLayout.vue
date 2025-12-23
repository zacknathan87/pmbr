<template>
  <div class="auth-wrapper">
    <router-view></router-view>
  </div>
</template>


<style>
.auth-wrapper {
  position: relative;
  z-index: 1;
  text-align: center;
  color: #2c3e50;
  margin: 0;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.el-footer {
  z-index: 1;
}
</style>