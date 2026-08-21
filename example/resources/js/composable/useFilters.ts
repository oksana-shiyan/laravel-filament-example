import { Ref, ref } from 'vue'

export const useFilters = (): Grid => {
  const openFilters = ref(false)

  const clearFilterValues = (filtersOptions: DataTableGridFilter[]): DataTableGridFilter[] => {
    return filtersOptions.map((item) => ({
      ...item,
      value: item.type === 'text' ? '' : { gte: '', lte: '' }
    }))
  }

  const extractFilters = (filtersOptions: DataTableGridFilter[]): any => {
    const extracted: DataTableKeyedFilters = {}

    filtersOptions.forEach((option: DataTableGridFilter) => {
      if (option.type === 'boolean' && typeof option.value === 'boolean') {
        extracted[option.code] = option.value
      }

      if (option.type === 'select-multiple') {
        const value = option.value as any[]
        if (value.length > 0) {
          extracted[option.code] = value
        }
      }

      if ((option.type === 'text' || option.type === 'select') && option.value) {
        extracted[option.code] = option.value
      }

      if (option.type === 'range' || option.type === 'date') {
        const rangeValue = option.value as DataTableRangeFilter
        let gte: DataTableRange
        let lte: DataTableRange

        if (rangeValue.gte) {
          gte = rangeValue.gte
        }
        if (rangeValue.lte) {
          lte = rangeValue.lte
        }

        extracted[option.code] = { gte, lte }
      }
    })

    return extracted
  }

  const hasValue = (option: DataTableGridFilter): boolean => {
    if (option.type === 'boolean' && typeof option.value === 'boolean') {
      return true
    }

    if (option.type === 'text' || option.type === 'select') {
      return !!option.value
    }

    if (option.type === 'select-multiple') {
      const value = option.value as any[]
      return value.length > 0
    }

    const optionValue = option.value as DataTableRangeFilter
    return !!(optionValue.gte || optionValue.lte)
  }

  return {
    openFilters,
    extractFilters,
    clearFilterValues,
    hasValue
  }
}

interface Grid {
  openFilters: Ref
  extractFilters: Function
  clearFilterValues: Function
  hasValue: Function
}

export type DataTableRange = string | number | undefined
export type DataTableGridFilterType = 'range' | 'date' | 'text' | 'boolean' | 'select' | 'select-multiple'
export type DataTableValue = boolean | string | number | string[] | number[] | boolean[] | DataTableRangeFilter

export interface DataTableRangeFilter {
  gte: DataTableRange
  lte: DataTableRange
}

export interface DataTableKeyedFilters {
  [key: string]: DataTableValue
}

export interface DataTableGridFilter<T = any> {
  code: T
  label: string
  type: DataTableGridFilterType
  value: DataTableValue
  options?: any[]
}
