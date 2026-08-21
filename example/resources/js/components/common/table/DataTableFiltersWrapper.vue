<template>
  <v-container>
    <v-row v-if="items.length" align="center">
      <v-col cols="10">
        <filters-chips v-model="selectedFilters" class="px-4 py-3" @onDelete="updateOnDelete" />
      </v-col>
      <v-col cols="2" class="d-flex justify-end">
        <v-btn depressed small @click="openFilters = !openFilters">
          <span>{{ 'Filters' }}</span>
          <v-icon icon="mdi-filter"></v-icon>
        </v-btn>
      </v-col>
    </v-row>

    <slot :filters="extractedFilters" />

    <portal to="side-drawer">
      <v-navigation-drawer v-model="openFilters" right width="300" app temporary clipped>
        <filters-grid
          v-if="openFilters"
          v-model="selectedFilters"
          class="fill-height"
          :items="availableFilters"
          @onApply="updateFilters"
          @onClear="clearFilters"
        />
      </v-navigation-drawer>
    </portal>
  </v-container>
</template>

<script lang="ts" setup>
import {Ref, ref} from 'vue'
import FiltersChips from '@/components/common/filters/FiltersChips.vue'
import FiltersGrid from '@/components/common/filters/FiltersGrid.vue'
import {DataTableGridFilter, useFilters} from "@/composable/useFilters";
import deepClone from 'deepclonejs'

const emit = defineEmits(['onChange'])
const extractedFilters = ref([])
const props = defineProps(['items'])

let availableFilters = deepClone(props.items) as DataTableGridFilter[]

const { extractFilters, openFilters, clearFilterValues } = useFilters()
const selectedFilters = ref([]) as Ref<DataTableGridFilter[]>
const updateFilters = (value: DataTableGridFilter[]): void => {
    console.log('update filters')
    selectedFilters.value = deepClone(value)
    extractedFilters.value = extractFilters(selectedFilters.value)
    openFilters.value = false
    emit('onChange', {
        filter: extractedFilters.value
    })
}

const updateOnDelete = (value: DataTableGridFilter[]): void => {
    availableFilters = deepClone(value)
    updateFilters(value)
}

const clearFilters = (): void => {
    updateOnDelete(clearFilterValues(selectedFilters.value))
}
</script>
