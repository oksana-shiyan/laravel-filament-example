<template>
    <v-row>
        <v-col class="ma-5">
            <h2>Profile ({{user.email}}) </h2>
            <v-tabs
                v-model="tab"
                bg-color="primary"
            >
                <v-tab value="changePassword">Change password</v-tab>
                <v-tab value="logs">Logs</v-tab>
            </v-tabs>
            <v-card-text>
                <v-window v-model="tab">
                    <v-window-item value="changePassword">
                        <v-row>
                            <v-col>
                                <ChangePassword/>
                            </v-col>
                            <v-col></v-col>
                            <v-col></v-col>
                        </v-row>
                    </v-window-item>

                    <v-window-item value="logs">
                        <log-list/>
                    </v-window-item>
                </v-window>
            </v-card-text>
        </v-col>
    </v-row>
</template>

<script lang="ts" setup>
import {ref} from 'vue'
import ChangePassword from '@/components/profile/ChangePassword.vue'
import LogList from '@/components/list/LogList.vue'
import { useAuth } from '@/stores/auth-store'

const tab = ref(null)
const { user } = useAuth()

</script>

<style scoped>

</style>
