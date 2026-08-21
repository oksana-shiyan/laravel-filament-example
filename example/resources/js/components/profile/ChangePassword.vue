<template>
    <v-form v-model="valid" @submit.prevent="submit">
        <v-text-field
            v-model="form.oldPassword"
            label="Current password"
            :rules="rules.oldPassword"
            :error-messages="errors.oldPassword"
            type="password"
        ></v-text-field>
        <v-text-field
            v-model="form.password"
            label="New password"
            :rules="rules.password"
            :error-messages="errors.password"
            type="password"
        ></v-text-field>
        <v-text-field
            v-model="form.passwordConfirmation"
            label="Confirm password"
            type="password"
            :rules="rules.passwordConfirmation"
            :error-messages="errors.passwordConfirmation"
        ></v-text-field>
        <div>
            <div class="d-flex justify-end">
                <v-btn type="submit">
                    Save
                </v-btn>
            </div>
        </div>
    </v-form>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import ChangePassword from '@/types/models/changePassword'
import {useAuth} from '@/stores/auth-store'
import {useNotEmptyValidationRule, ValidationRule} from '@/composable/useValidationRules'
import {useUser} from '@/stores/user-store'
import { useNotifier } from 'vuetify-notifier'

const $notifier = useNotifier();

interface ChangePasswordErrors {
    password?: string,
    oldPassword?: string,
    passwordConfirmation?: string,
}
const { user } = useAuth()
const { changePassword } = useUser()
const form = ref<ChangePassword>(new ChangePassword())
const valid = ref<Boolean|null>(null)

const errors = ref<ChangePasswordErrors>({
    password: '',
    oldPassword: '',
    passwordConfirmation: '',
})

const rules = {
    password: [(): ValidationRule => useNotEmptyValidationRule(form.value.password)],
    oldPassword: [(): ValidationRule => useNotEmptyValidationRule(form.value.oldPassword)],
    passwordConfirmation: [
        (): ValidationRule => useNotEmptyValidationRule(form.value.passwordConfirmation),
        (): ValidationRule => {
            if (form.value.password !== form.value.passwordConfirmation) {
                return 'The passwords dosen\'t match'
            }

            return true
        }
    ]
}

const submit = async(): Promise<void> => {
    if (!valid.value) {

    }
    try {
        await changePassword(form.value)
        $notifier.toast('Password was changed', "success");
        form.value = new ChangePassword()
    } catch (ex) {
        errors.value = ex.data.errors
    }
}

</script>
