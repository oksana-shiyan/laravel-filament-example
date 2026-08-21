export type ValidationRule = boolean | string

export const useNotWhitespaceValidationRule = (value: string = ''): ValidationRule => {
  if (value && value.match(/\s/g)) {
    return 'No whitespaces allowed'
  }
  return true
}

export const useNotEmptyValidationRule = (value: any): ValidationRule => {
  return !value ? 'Field cannot be empty' : true
}

export const useUniqueAttributeValidationRule = (
  value: string,
  list: string[],
  attributeName: string
): ValidationRule => {
  return list.includes(value) ? `This ${attributeName} already exists` : true
}

export const useMatchRangeValidationRule = (value: number, min: number, max: number): ValidationRule => {
  return !(value > min && value < max) ? `Value must be between ${min} and ${max}` : true
}

export const useNotEmptyArrayValidationRule = (value: any[]): ValidationRule => {
  return value.length === 0 ? 'List cannot be empty' : true
}

export const useEmailValidationRule = (value: string): ValidationRule => {
  if (!value.match(/\S+@\S+\.\S+/)) {
    return 'Invalid email format'
  }
  return true
}

export const useURLFormatValidationRule = (value: string): ValidationRule => {
  try {
    new URL(value)
    return true
  } catch (e) {
    return 'Invalid URL format'
  }
}

export const useJsonValidationRule = (value: string): ValidationRule => {
  try {
    JSON.parse(value)
    return true
  } catch (e) {
    return 'Invalid json format'
  }
}
