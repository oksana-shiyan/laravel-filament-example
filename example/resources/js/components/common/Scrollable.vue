<template>
  <div :style="{ height }" class="scrollable-height">
    <slot name="sticky-wrapper">
      <div class="position-sticky">
        <slot name="sticky" />
      </div>
    </slot>
    <slot name="scrollable" />
    <slot name="sticky-bottom-wrapper">
      <div class="position-sticky-bottom align-end">
        <slot name="sticky-bottom" />
      </div>
    </slot>
  </div>
</template>

<script lang="ts" setup>

const props = defineProps(
    {
        height: {
            type: String,
            default:
                '100%'
            }
    })
</script>
