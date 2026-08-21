<template>
  <v-slide-y-reverse-transition mode="out-in">
    <floating-bottom v-if="$vuetify.breakpoint.smAndDown && count && isFloating">
      <v-col>
        <v-row align="center" justify="center">
          <v-btn color="secondary" class="ma-2" large depressed @click="$emit('delete')">
            <span>{{ 'Delete' }} ({{ count }})</span>
            <v-icon right>delete</v-icon>
          </v-btn>
        </v-row>
      </v-col>
    </floating-bottom>
    <v-btn
      v-if="$vuetify.breakpoint.mdAndUp && count && !isFloating"
      color="secondary"
      depressed
      small
      v-bind="$attrs"
      @click="$emit('delete')"
    >
      {{ $t('Delete') }} ({{ count }})
      <v-icon right>delete</v-icon>
    </v-btn>
  </v-slide-y-reverse-transition>
</template>

<script lang="ts" setup>

import FloatingBottom from '@/components/common/elements/FloatingBottom.vue'
const props = defineProps(['count', 'isFloating'])

</script>
