<template>
    <data-table-wrapper header="User list">
        <template v-slot:datatable>
           <user-list />
        </template>
    </data-table-wrapper>
</template>

<script lang="ts" setup>
import DataTableWrapper from '@/components/common/table/DataTableWrapper.vue'
import UserList from '@/components/list/UserList.vue'
</script>

<style scoped>
</style>
