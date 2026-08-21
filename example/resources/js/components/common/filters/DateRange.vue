<template>
  <v-menu :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        v-model="form"
        dense
        outlined
        prepend-icon="mdi-calendar"
        readonly
        v-bind="attrs"
        hide-details="auto"
        v-on="on"
      />
    </template>
    <v-date-picker v-model="form" no-title scrollable range />
  </v-menu>
</template>

<script lang="ts" setup>
import { watch, ref, Ref } from 'vue'
import { DataTableRangeFilter } from '@/composable/useFilters'

const props = defineProps( {
    value: {
        type: Object as () => DataTableRangeFilter,
        required: true
    }
})
const emit = defineEmits(['input'])
const form = ref([props.value.gte || '', props.value.lte || '']) as Ref<[string, string]>

watch(form, () => emit('input', { gte: form.value[0], lte: form.value[1] || '' }), { deep: true })

</script>
