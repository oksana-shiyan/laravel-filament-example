<template>
  <v-slide-y-reverse-transition mode="out-in">
    <div v-if="!loading" class="col-10 mx-auto">
      <slot />
    </div>
    <div v-else class="d-flex justify-center mt-16">
      <v-progress-circular size="50" color="primary" indeterminate />
    </div>
  </v-slide-y-reverse-transition>
</template>

<script lang="ts" setup>

const props = defineProps({
    loading: {
        type: Boolean,
        default: true
    }
})
</script>
