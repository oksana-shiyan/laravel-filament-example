<template>
  <div class="d-flex flex-column">
    <div class="d-flex flex-row pb-5">
      <v-text-field
        v-model="form.name"
        label="Name"
        outlined
        :rules="rules.name"
        validate-on-blur
        hide-details="auto"
        class="me-2"
      />
      <v-text-field
        v-model="form.email"
        slugify
        label="Email"
        outlined
        :rules="rules.email"
        validate-on-blur
        hide-details="auto"
        class="ms-2"
        disabled
      />
    </div>
  </div>
</template>

<script lang="ts" setup>
import User from '@/types/models/user'
import { ref } from 'vue'
import { ValidationRule,  useNotEmptyValidationRule } from '@/composable/useValidationRules'

const props = defineProps({
    modelValue: {
        type: Object as () => User,
        required: true
    }
})
const form = ref(props.modelValue)

const rules = {
    name: [(): ValidationRule => useNotEmptyValidationRule(form.value.name)],
    email: [(): ValidationRule => useNotEmptyValidationRule(form.value.email)]
}
</script>
