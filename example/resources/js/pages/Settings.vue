<template>
    <v-container fluid class="fill-height my-0 py-0 px-0">
        <v-row class="ma-0 pa-0">
            <v-col class="ma-0 pa-0" cols="4">
                <scrollable class="my-0 py-0" height="calc(100vh - 64px)">
                    <template v-slot:sticky>
                        <v-card flat>
                            <v-card-title class="mx-0">
                                <span>Settings</span>
                            </v-card-title>
                        </v-card>
                    </template>
                    <template v-slot:scrollable>
                        <v-tabs v-model="currentTab" direction="vertical" class="mt-0 px-0" :key="groups.length">
                        <v-tab
                            v-for="group in groups"
                            :value="group"
                            class="justify-start"
                        >
                            {{ group }}
                        </v-tab>
                        </v-tabs>
                    </template>
                </scrollable>
            </v-col>

            <v-divider vertical class="foreground-divider" />

            <v-col class="ma-0 pa-0 col-8 col-lg-8">
                <v-card-text>
                    <v-window v-model="currentTab">
                        <v-window-item v-for="(tabItem, index) in groups" :key="index" :value="tabItem">
                            <template v-for="(setting, index) in settings" :key="index">
                            <template  v-if="setting.group === tabItem">
                                <setting-inputs :setting="setting"/>
                            </template>
                            </template>
                        </v-window-item>
                    </v-window>
                </v-card-text>
<!--                <v-slide-x-transition mode="out-in">-->
<!--                    <v-tabs-items v-if="settings" v-model="currentTab" class="my-0 py-0">-->
<!--                        {{currentTab}}-->
<!--                        <template v-for="(tabItem, index) in groups" :key="index">-->
<!--                            {{tabItem}}-->
<!--                            <v-tab-item class="my-0 py-0" :value="tabItem">-->
<!--                                <template v-for="(setting, index) in settings" :key="index">-->
<!--                                    <template  v-if="setting.group === tabItem">-->
<!--                                      (  {{ setting.group }} {{tabItem}} )-->
<!--                                    </template>-->
<!--                                <component-->
<!--                                    :is="tabItem.component"-->
<!--                                    v-if="settings.group === tabItem"-->
<!--                                    :value="settings"-->
<!--                                    class="mx-0 px-0"-->
<!--                                    :loading="loadingUpdate"-->
<!--                                    @submit="updateSetting"-->
<!--                                />-->
<!--                                </template>-->
<!--                            </v-tab-item>-->
<!--                        </template>-->
<!--                    </v-tabs-items>-->
<!--                    <v-container v-else>-->
<!--                        <v-skeleton-loader type="image" class="my-3" />-->
<!--                        <v-skeleton-loader type="image" class="my-3" />-->
<!--                        <v-skeleton-loader type="image" class="my-3" />-->
<!--                    </v-container>-->
<!--                </v-slide-x-transition>-->
            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import { useSetting } from '@/stores/setting-store'
import Scrollable from '@/components/common/Scrollable.vue'
import SettingInputs from '@/components/inputs/SettingInputs.vue'
const { fetchSettings, fetchGroups } = useSetting()
const currentTab = ref(null)

const groups = ref<any>([])
const settings = ref<any>([])

const getGroups = async (): Promise<void> => {
    groups.value = await fetchGroups({});
}

const getSettings = async (): Promise<void> => {
    const settingCollection = await fetchSettings({page: {page:1, perPage: 100}});
    settings.value = settingCollection.data
}

// const inputComponents = {
//     input: {component: 'v-input'},
//     select: {component: 'v-select', multiple: false},
//     multiselect: {component: 'v-select', multiple: true},
//     switch: {component: 'v-switch'}
// }
// console.log(inputComponents['input'])
getGroups()
getSettings()
</script>
