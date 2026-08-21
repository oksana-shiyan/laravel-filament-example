<template>
  <v-slide-y-transition mode="out-in">
    <v-card v-if="!loading" flat class="px-6 py-5">
      <v-row v-if="id" justify="space-between" align="center">
        <v-col>
          <v-container>
            <slot name="header" />
          </v-container>
        </v-col>
        <slot name="actions">
          <slot name="beforeSubmitAction" />
          <slot name="submitAction">
            <v-btn
              v-if="showDelete"
              :disabled="!valid"
              :loading="submitLoading"
              class="mx-4"
              text
              @click="$emit('delete')"
            >
              Delete
            </v-btn>
            <template>
              <v-btn
                v-if="showUpdate"
                depressed
                :disabled="!valid"
                :loading="submitLoading"
                :type="'submit'"
                color="primary"
              >
                Update
              </v-btn>
            </template>
          </slot>
        </slot>
      </v-row>

      <v-row v-else justify="space-between" align="center">
        <v-col>
          <v-container>
            <slot name="header" />
          </v-container>
        </v-col>
        <slot name="actions">
          <slot name="beforeSubmitAction" />
          <slot name="submitAction">
            <v-btn
              v-if="showCreate"
              depressed
              :disabled="!valid"
              :loading="submitLoading"
              type="submit"
              color="primary"
            >
              Create
            </v-btn>
          </slot>
        </slot>
      </v-row>
    </v-card>
  </v-slide-y-transition>
</template>

<script lang="ts" setup>

const props =defineProps({
    valid: {
        type: Boolean,
        default: false
    },
    id: {
        type: Boolean,
        required: true
    },
    loading: {
        type: Boolean,
        default: false
    },
    submitLoading: {
        type: Boolean,
        default: false
    },
    showCreate: {
        type: Boolean,
        default: true
    },
    showDelete: {
        type: Boolean,
        default: true
    },
    showUpdate: {
        type: Boolean,
        default: true
    }
})
</script>
