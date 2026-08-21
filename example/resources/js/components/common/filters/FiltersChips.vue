<template>
  <div class="d-flex">
    <template v-for="(option, index) in modelValue" :key="option.code">
      <v-slide-y-reverse-transition  mode="out-in">
        <v-chip v-if="hasValue(option)" :class="{ 'mx-2': index > 0 }">
          <span>{{ option.label }}</span>
          <v-icon icon="mdi-arrow-right" class="mx-2"></v-icon>

          <template v-if="option.type === 'text' || option.type === 'select'">
            <span>{{ option.value }}</span>
          </template>

          <template v-if="option.type === 'boolean'">
            <span>{{ option.value ? 'Yes' : 'No' }}</span>
          </template>

          <template v-if="option.type === 'select-multiple'">
            <span>{{ (option.value || []).join(', ') }}</span>
          </template>

          <template v-if="option.type === 'date' || option.type === 'range'">
            <v-icon v-if="!option.value.gte">all_inclusive</v-icon>
            <template v-else>
              <span>{{ option.value.gte }}</span>
            </template>
            <span class="mx-2">-</span>
            <v-icon v-if="!option.value.lte">all_inclusive</v-icon>
            <template v-else>
              <span>{{ option.value.lte }}</span>
            </template>
          </template>

          <v-divider vertical class="mx-2" />

          <v-icon icon="mdi-close" size="16" @click="deleteChip(option)"></v-icon>
        </v-chip>
      </v-slide-y-reverse-transition>
    </template>
    <slot />
  </div>
</template>

<script lang="ts" setup>
import { DataTableGridFilter, useFilters } from '@/composable/useFilters'
const emit = defineEmits(['onDelete'])

const props = defineProps(['modelValue'])
const { hasValue } = useFilters()

const deleteChip = (option: DataTableGridFilter): void => {
    const value = props.modelValue.map((item: DataTableGridFilter) =>
        item.code === option.code ? { ...option, value: '' } : item
    )
    emit('onDelete', value)
}
</script>
