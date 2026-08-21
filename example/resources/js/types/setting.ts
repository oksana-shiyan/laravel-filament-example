import {
  CollectionResponse,
  type Pagination,
  type Resource,
} from '@/types/response';
import Setting from '@/types/models/setting';

export interface SettingData {
  key: string | null;
  description: string | null;
  value: any | null;
  options: any | null;
  type: SettingField;
  validation: string | null;
  group: string;
  isPublic: boolean;
}

export interface SettingResponse extends Omit<Resource, 'attributes'> {
  attributes: SettingData;
}

export interface SettingFilter {
  query: string | null;
  group: string | null;
}

export interface SettingRequestParam {
  filter: SettingFilter;
  page: Pagination;
}

export interface SettingCollectionResponse
  extends Omit<CollectionResponse, 'data'> {
  data: Setting[];
}

export interface GroupCollectionResponse
  extends Omit<CollectionResponse, 'data'> {
  data: string[];
}

export type SettingField = 'input' | 'switch' | 'select' | 'multiselect';
