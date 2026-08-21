<template>
  <div class="floating-bottom">
    <slot />
  </div>
</template>

<style lang="scss">
.floating-bottom {
  position: fixed;
  z-index: 4;
  bottom: 5vh;
  right: 0;
  left: 0;
}
</style>
