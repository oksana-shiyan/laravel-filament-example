<template>
  <v-container grid-list-xl fluid>
    <v-row justify="center">
      <v-col wrap class="px-0 py-0">
        <v-container>
          <v-row align="center" class="mx-2 my-1 text-h6" justify="space-between">
            <slot>
              {{ header }}
              <slot name="actions" />
              <v-btn v-if="redirectName" depressed color="primary" :to="{ name: redirectName }">
                <slot name="button-content" />
              </v-btn>
            </slot>
          </v-row>
        </v-container>
        <v-divider />
        <v-container>
          <slot name="datatable" />
        </v-container>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts" setup>
    const props = defineProps(['header', 'redirectName'])
</script>
