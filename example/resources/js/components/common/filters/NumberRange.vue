<template>
  <div class="d-flex flex-row">
    <v-text-field v-model.number="form.gte" dense outlined :label="$t('From')" hide-details="auto" class="me-4" />
    <v-text-field v-model.number="form.lte" dense outlined :label="$t('To')" hide-details="auto" class="ms-4" />
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { DataTableRangeFilter } from '@/composable/useFilters'

const props = defineProps({
    value: {
        type: Object as () => DataTableRangeFilter,
        required: true
    }
})
const emit =defineEmits(['input'])

const form = computed({
    get: () => props.value,
    set: (): void => {
        emit('input', { gte: form.value.gte?.toString(), lte: form.value.lte?.toString() })
    }
})
</script>
