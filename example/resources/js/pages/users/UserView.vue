<template>
    <v-form @submit.prevent="submitItem">
        <scrollable class="pa-0 ma-0">
            <template v-slot:scrollable>
                <resource-header
                        :key="item.id"
                        :id="!!item.id"
                        :valid="valid"
                        :loading="loadingRequest"
                        :show-update="canUpdate"
                        :show-delete="canDelete"
                        :submitLoading="submitLoading"
                    >
                        <template v-if="item.id" #header>
                            <v-row>User: {{ item.name }}</v-row>
                            <v-row class="text-caption">
                                <span class=" blue-grey-lighten-5"> {{ item.id ?? '' }} </span>
                            </v-row>
                        </template>
                        <template v-else #header>
                            <v-row>Add new user</v-row>
                        </template>
                    </resource-header>
                <v-divider/>
                <v-container>
                    <resource-loader :loading="loadingRequest">
                        <user-inputs v-if="item" :key="item.id" v-model="item"/>
                    </resource-loader>
                </v-container>
             </template>
            <template v-slot:sticky-bottom>
                <v-divider />
                <v-card class="py-7" flat>
                <v-row justify="space-around" class="mx-0">
                    <v-btn color="primary" depressed type="submit">{{ hasValidId ? 'Update' : 'Create'}}</v-btn>
                </v-row>
            </v-card>
            </template>
        </scrollable>
    </v-form>
</template>
<script lang="ts" setup>
import UserInputs from '@/components/inputs/UserInputs.vue'
import ResourceHeader from '@/components/common/resource/ResourceHeader.vue'
import ResourceLoader from '@/components/common/resource//ResourceLoader.vue'
import Scrollable from '@/components/common/Scrollable.vue'
import {useUser} from '@/stores/user-store'
import {useRoute} from 'vue-router'
import User from '@/types/models/user'
import { ref, watch } from 'vue'
import { useNotifier } from 'vuetify-notifier'

const $notifier = useNotifier();
const loadingRequest = ref<boolean>(false)
const submitLoading = ref<boolean>(false)
const canUpdate = ref<boolean>(true)
const canCreate = ref<boolean>(false)
const canDelete = ref<boolean>(false)
const valid = ref<boolean>(true)

const router = useRoute()
const userId = router.params.id as string

const hasValidId = userId !== '__'
const { fetchUser, updateUser, createUser } = useUser()
const item = ref<User>(new User())

const getUser = async () => {
    item.value = await fetchUser(userId)
}

if (hasValidId) {
    getUser()
}

const submitItem = async():Promise<void> => {
    try {
        hasValidId ? await updateUser(item.value.id as string, item.value) : await createUser(item.value)
        $notifier.toast(hasValidId ? "Updated" : "Created", "success");
    } catch (e) {
        $notifier.toast("Error", "error");
    } finally {
    }
}

watch(item, () => {
    canDelete.value =hasValidId && item.value.role != 'admin'
})
</script>
