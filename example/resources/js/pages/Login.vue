<template>
    <v-app>
    <v-main>
        <v-container class="fill-height">
        <v-row align="center" justify="center">
            <v-col cols="12" sm="8" md="4" lg="4">
            <v-card>
                <v-card-title class="py-5 font-weight-black">Login to dashboard</v-card-title>
                <v-form v-model="valid" lazy-validation @submit.prevent="submitForm">
                    <v-card-text>
                        <v-text-field
                            v-model='form.email'
                            label="Username"
                            :rules="rules.email"
                            :error-messages="errors.email"
                        />
                        <v-text-field
                            v-model='form.password'
                            label="Password"
                            type="password"
                            :rules="rules.password"
                            :error-messages="errors.password"
                        />
                    </v-card-text>
                    <v-card-actions class="justify-end">
                    <v-btn   class="text-none mb-4"
                             color="primary"
                             type="submit"
                             size="x-large"
                             variant="flat"
                    >
                        Login
                    </v-btn>
                </v-card-actions>
                </v-form>
            </v-card>
            </v-col>
        </v-row>
        </v-container>
    </v-main>
    </v-app>
</template>

<script lang="ts"  setup>

import {ref} from 'vue';
import {LoginRequest} from '@/types/auth'
import {useAuth} from '@/stores/auth-store'
import router from '@/router'
import {storeToRefs} from 'pinia'
import { useNotifier } from 'vuetify-notifier'
import {useNotEmptyValidationRule, ValidationRule} from '@/composable/useValidationRules'

interface LoginErrors {
    email?: string;
    password?: string;
}

const $notifier = useNotifier();
const loading = ref<Boolean>(false);
const form = ref<LoginRequest>({email: '', password: ''})
const valid = ref<Boolean|null>(null)
const {token, user} = storeToRefs(useAuth())
const {login, fetchUser} = useAuth()

if (token ) {
    router.push({name: 'dashboard'})
}

const errors = ref<LoginErrors>({email: '', password: ''})

const rules = {
    password: [(): ValidationRule => useNotEmptyValidationRule(form.value.password)],
    email: [(): ValidationRule => useNotEmptyValidationRule(form.value.email)]
}

const submitForm = async () => {
    if(!valid.value) {
        return
    }
    loading.value = true;
    try {
        await login(form.value)
        await router.push({name: 'dashboard'})
        await fetchUser()
    } catch (err: any) {
        console.log(err)
        $notifier.toast(err.data.message, "error");
    } finally {
        loading.value = false
    }
}
</script>

<style lang="scss"/>

