<template>
  <v-form @submit.prevent="$emit('onApply', filterGrid)">
    <scrollable class="pa-0 ma-0">
      <template v-slot:sticky>
        <v-card flat>
          <v-card-title class="py-2">
            <span>{{ 'Filters' }}</span>
          </v-card-title>
          <v-divider />
        </v-card>
      </template>
      <template v-slot:scrollable>
        <div class="px-3 filters-height">
          <v-container v-for="(option, index) in filterGrid" :key="index">
            <v-row v-if="requireLabel(option.type)">
              <v-col class="my-0 py-0">
                <span>{{ option.label }}</span>
              </v-col>
            </v-row>
            <v-row v-if="option.type === 'text'">
              <v-col>
                <v-text-field v-model="option.value" dense outlined :label="option.label" hide-details="auto" />
              </v-col>
            </v-row>

            <number-range v-if="option.type === 'range'" v-model="option.value" class="mt-4" />

            <v-row v-if="option.type === 'date'">
              <v-col>
                <date-range v-model="option.value" />
              </v-col>
            </v-row>
            <v-row v-if="option.type === 'boolean'" align="center" justify="space-between" class="mx-0">
              <span>{{ option.label }}</span>
              <v-switch v-model.trim="option.value" />
            </v-row>
            <v-row v-if="option.type === 'select' || option.type === 'select-multiple'">
              <v-col>
                <v-select
                  v-model="option.value"
                  dense
                  outlined
                  :label="option.label"
                  hide-details="auto"
                  :items="option.options"
                  :multiple="option.type === 'select-multiple'"
                />
              </v-col>
            </v-row>
            <slot />
          </v-container>
        </div>
      </template>
      <template v-slot:sticky-bottom>
        <v-divider />
        <v-card class="py-7" flat>
          <v-row justify="space-around" class="mx-0">
            <slot name="actions.before" />
            <v-btn depressed @click="$emit('onClear')">Clear</v-btn>
            <v-btn color="primary" depressed type="submit">{{ 'Apply' }}</v-btn>
            <slot name="actions.after" />
          </v-row>
        </v-card>
      </template>
    </scrollable>
  </v-form>
</template>

<script lang="ts" setup>
import { ref, Ref } from 'vue'
import { DataTableGridFilter, DataTableGridFilterType } from '@/composable/useFilters'
import DateRange from './DateRange.vue'
import NumberRange from './NumberRange.vue'
import Scrollable from '@/components/common/Scrollable.vue'
import deepClone from 'deepclonejs'

const props = defineProps({
    modelValue: {
        type: Array as () => DataTableGridFilter[],
        required: true
    },
    items: {
        type: Array as () => DataTableGridFilter[],
        required: true
    }
})

const filterGrid = ref([...props.items]) as Ref<DataTableGridFilter[]>

props.modelValue.forEach((value) => {
  const index = filterGrid.value.findIndex((item) => item.code === value.code)
  if (index >= 0) {
    filterGrid.value[index] = deepClone(value)
  }
})

const requireLabel = (type: DataTableGridFilterType): boolean => {
  return type === 'date' || type === 'range'
}
</script>
