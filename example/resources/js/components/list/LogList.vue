<template>
  <div>
    <data-table-filters-wrapper :items="[]">
      <v-row justify="center">
        <v-col cols="12">
          <v-data-table-server
            :headers="headers"
            :items="files"
            :loading="loading"
            item-key="key"
            class="v-data-table-shadowless"
              :hide-default-footer="true"

          >
              <template v-slot:item.actions="{ item }">
                  <v-btn @click="downloadLogFile(item.raw.key)">
                  <v-icon
                      size="small"
                  >
                      mdi-download
                  </v-icon>
                  </v-btn>
              </template>
              <template v-slot:bottom> </template>
          </v-data-table-server>
        </v-col>
      </v-row>
    </data-table-filters-wrapper>
<!--    <bulk-delete-button :count="selected.length" :is-floating="true" @delete="bulkDelete"/>-->
  </div>
</template>

<script lang="ts" setup>
import DataTableFiltersWrapper from '@/components/common/table/DataTableFiltersWrapper.vue'
import { ref} from 'vue'

import {useLog} from '@/stores/log-store'
import {LogResource} from "@/types/log";
const files = ref<Array<LogResource>>([]);
const loading = ref<Boolean>(true)
const { fetchFiles, download } = useLog()

const headers = ref([
    { title: 'Name', key: 'name', sortable: false },
    { title: 'Actions', key: 'actions', sortable: false }
])

const bulkDelete = (): void => {
    // const ids = selected.value.map((item) => item.id)
    // massDeleteLoader.loadData(() => api.customers.massDeleteCustomers(ids))
}


const onRequest = async (): Promise<void> => {
    loading.value = true
    files.value = await fetchFiles()
    loading.value = false
}

onRequest()

const downloadLogFile = async (key: string): Promise<void> => {
    try {
        await download(key)
    } catch (err) {
        console.log(err)
    }
}
// const availableFilters = ref([]) as Ref<DataTableGridFilter<any>[]>
//
// const onRowClick = (params: any): void => {
//     console.log(params)
// }
</script>
