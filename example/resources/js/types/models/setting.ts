import { SettingData, SettingField, SettingResponse } from '@/types/setting';

export default class Setting implements SettingInterface {
  id: number | string | null;
  key: string;
  description: string | null;
  value: string | null;
  options: any | null;
  type: SettingField;
  validation: string | null;
  group: string;
  isPublic: boolean;

  constructor(data?: SettingResponse) {
    this.id = data?.id || null;
    this.key = data?.attributes.key || '';
    this.description = data?.attributes.description || null;
    this.value = this.getValue(
      data?.attributes.value || null,
      data?.attributes.type || 'input'
    );
    this.options = data?.attributes.options || null;
    this.type = data?.attributes.type || 'input';
    this.validation = data?.attributes.validation || null;
    this.group = data?.attributes.group || '';
    this.isPublic = Boolean(data?.attributes.isPublic) || false;
  }

  public getValue(value: any | null, type: SettingField): any {
    if (type === 'multiselect' && value) {
      return JSON.parse(value);
    }

    if (type === 'switch') {
      return Boolean(Number(value));
    }

    return value;
  }
}

export interface SettingInterface extends SettingData {
  id: number | string | null;
}
