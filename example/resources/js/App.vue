<template>
    <component :is="layout">
        <router-view />
    </component>
</template>

<script setup lang="ts">
import {computed} from 'vue';
import Default from '@/layouts/Default.vue';
import {useRoute} from 'vue-router';

const route = useRoute()
const layout = computed(() => route.meta.layout || Default)
</script>
