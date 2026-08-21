<template>
    <v-row class="p-15">
        <v-col>
            <h3>Key: {{form.key}}</h3>
            <p>{{form.description}}</p>
            <v-text-field
                v-if="form.type === 'input'"
                v-model="form.value"
                outlined
                validate-on-blur
                hide-details="auto"
                class="me-2"
            />
            <v-select
                v-if="form.type === 'select'"
                v-model="form.value"
                :items="getOptions"
                outlined
                validate-on-blur
                hide-details="auto"
                class="me-2"
            />
            <v-select
                v-if="form.type === 'multiselect'"
                v-model="form.value"
                :items="getOptions"
                outlined
                multiple
                chips
                validate-on-blur
                hide-details="auto"
                class="me-2"
            />
            <v-switch
                v-if="form.type === 'switch'"
                v-model="form.value"
                outlined
                validate-on-blur
                hide-details="auto"
                class="me-2"
            />
            <span class="text-red">{{error}}</span>
        </v-col>

        <v-col>
            <v-switch
                color="primary"
                v-model="form.isPublic"
                label="Is public"
            ></v-switch>
        </v-col>
    </v-row>
    <v-divider class="mb-5"></v-divider>
</template>

<script lang="ts" setup>
import { ref, computed, watch } from 'vue'
import Setting from '@/types/models/setting'
import debounce from 'lodash.debounce'
import { useSetting } from '@/stores/setting-store'

const props = defineProps({
    setting: {
        type: Object as () => Setting,
        required: true
    }
})

const { updateSetting } = useSetting()
const form = ref(props.setting)
const error = ref<string>('')

const getOptions = computed(() => {
    try {
        if (!form.value.options) {
            return [];
        }

        if (Array.isArray(form.value.options)) {
            return form.value.options;
        }

        return JSON.parse(form.value.options);
    } catch (e) {
        console.log(e)
    }
})

watch(() => form, debounce(async () => {
    error.value = ''
    try {
        await updateSetting(form.value.id as string, form.value)
    } catch (ex) {
        error.value = ex.data.errors.value
    }
}, 1000), {deep:true})

</script>
