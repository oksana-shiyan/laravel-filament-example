<template>
    <v-card>
        <v-layout>
            <v-app-bar color="primary" fixed dark app clipped-left clipped-right flat>
                <v-row>
                    <v-col>
            <span>
                <v-app-bar-nav-icon class="me-4" @click.stop="rail = !rail" />
                {{ 'Dashboard'}}
            </span>
                    </v-col>
                    <v-col class="d-flex justify-end">
                        <v-btn icon="mdi-account outlined" class="mr-5" :to="{name: 'profile'}"></v-btn>
                        <v-btn icon="mdi-logout outlined" class="mr-5" @click="logoutUser"></v-btn>
                    </v-col>
                </v-row>
            </v-app-bar>

            <v-navigation-drawer
                v-model="drawer"
                :rail="rail"
                permanent
                @click="rail = false"
            >
                <v-list-item
                    prepend-avatar="https://it-devgroup.com/assets/img/icons/logo.svg"
                    title="Test project"
                    nav
                >
                    <template v-slot:append>
                        <v-btn
                            variant="text"
                            icon="mdi-chevron-left"
                            @click.stop="rail = !rail"
                        ></v-btn>
                    </template>
                </v-list-item>

                <v-divider></v-divider>

                <v-list                 class="teal-lighten-5"
                                        density="compact" nav>
                    <v-list-item prepend-icon="mdi-home-city" title="Home" :to="{name: 'dashboard'}"></v-list-item>
                    <v-list-item prepend-icon="mdi-account-group-outline" :to="{name: 'users'}" title="Users" ></v-list-item>
                    <v-list-item prepend-icon="mdi-cogs" :to="{name: 'settings'}" title="Settings" ></v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-main>
                <router-view/>
            </v-main>
        </v-layout>
    </v-card>
</template>

<script setup lang="ts">
import {ref} from 'vue'
import {useAuth} from '@/stores/auth-store'
import router from '@/router'
import {storeToRefs} from 'pinia'

const drawer = ref(true)
const rail = ref(true)
const {user} = storeToRefs(useAuth())
const {logout} = useAuth()


const logoutUser = async (): Promise<void> => {
  try {
    await logout()
    await router.push({name: 'login'})
  } catch (err) {
    console.log('err', err)
  } finally {
  }
}

const items = [{
    href: 'home',
    router: true,
    title: 'Home',
    icon: 'home',
}, {
    href: 'examples',
    router: true,
    title: 'Example',
    icon: 'extension',
}, {
    href: 'about',
    router: true,
    title: 'About',
    icon: 'domain',
}]

</script>

