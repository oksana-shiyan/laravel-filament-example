<template>
  <div>
    <data-table-filters-wrapper :items="availableFilters" @onChange="setFilter">
      <v-row justify="center">
        <v-col cols="12">
          <v-data-table-server
            v-model:items-per-page="perPage"
            :items-length="total"
            :headers="headers"
            :items="users"
            :loading="loading"
            item-key="id"
            class="v-data-table-shadowless"
            :search="search"
            @update:options="onRequest"
            @click:row="onRowClick"
            @dblclick:row="editItem"
          >
              <template v-slot:item.actions="{ item }">
                  <router-link :to="{name:'single-user', params: {id: item.raw.id}}">
                  <v-icon
                      size="small"
                      class="me-2"
                  >
                      mdi-pencil
                  </v-icon>
                  </router-link>
<!--                  <v-icon-->
<!--                      size="small"-->
<!--                  >-->
<!--                      mdi-delete-->
<!--                  </v-icon>-->
              </template>
          </v-data-table-server>
        </v-col>
      </v-row>
    </data-table-filters-wrapper>
<!--    <bulk-delete-button :count="selected.length" :is-floating="true" @delete="bulkDelete"/>-->
  </div>
</template>

<script lang="ts" setup>

import BulkDeleteButton from '@/components/common/elements/BulkDeleteButton.vue'
import DataTableFiltersWrapper from '@/components/common/table/DataTableFiltersWrapper.vue'
import User, {UserGroupFilters} from '@/types/models/user'
import {Ref, ref} from 'vue'
import {UserFilter, UserRequestParam} from '@/types/user'
import {useUser} from '@/stores/user-store'
import {DataTableGridFilter} from "@/composable/useFilters";
import { useRouter } from "vue-router";

const router = useRouter()
const {fetchUsers, deleteUser} = useUser();
const selected = ref<User[]>([])
//const pagination = ref<Pagination>({page: 1, perPage: 15, total: 0});
const page = ref<Number>(1);
const perPage = ref<Number>(15);
const total = ref<Number>(0);
const users = ref<User[]>([]);
const filter = ref<UserFilter>({query: null, role: null})
const current = ref<User>(new User())
const loading = ref<Boolean>(true)
const search = ref<Boolean>(true)
const headers = ref([
    { title: 'Name', key: 'name', sortable: true },
    { title: 'Email', key: 'email' },
    { title: 'Role', key: 'role' },
    { title: 'Created At', key: 'createdAt' },
    { title: 'Actions', key: 'actions', sortable: false }
])

const bulkDelete = (): void => {
    // const ids = selected.value.map((item) => item.id)
    // massDeleteLoader.loadData(() => api.customers.massDeleteCustomers(ids))
}


const onRequest = async (params: any): Promise<void> => {
    console.log(params)
    loading.value = true
    const {data, meta} = await fetchUsers({filter: filter.value, page: {page: params.page, perPage: params.itemsPerPage}} as UserRequestParam)
    users.value = data
    loading.value = false
    page.value = params.page
    perPage.value = params.itemsPerPage
    total.value = meta ? meta.total : 0
}

const setFilter = async (params: any): Promise<void> => {
    filter.value = params.filter
    search.value = !search.value
}

const availableFilters = ref([
    { type: 'text', code: 'query', label: 'Query', value: '' },
    { type: 'text', code: 'email', label: 'Email', value: '' },
    { type: 'text', code: 'name', label: 'Name', value: '' }
]) as Ref<DataTableGridFilter<UserGroupFilters>[]>

const onRowClick = (params: any): void => {
    console.log(params)
}
const editItem = (id: any, param: any): void => {
    console.log(id)
    console.log(param)
   // router.push({name: 'single-user', params: {id: id}})
}
</script>
