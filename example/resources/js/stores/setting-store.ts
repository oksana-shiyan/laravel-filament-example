import { defineStore } from 'pinia';
import {
  GroupCollectionResponse,
  SettingCollectionResponse,
  SettingRequestParam,
} from '@/types/setting';
import SettingService from '@/services/setting-service';
import Setting from '@/types/models/setting';

export const useSetting = defineStore('settings', (): UseSettings => {
  const settingService = new SettingService();

  const fetchSettings = async (
    params: SettingRequestParam
  ): Promise<SettingCollectionResponse> => {
    const { data, meta } = await settingService.list(params);
    return { data: data.map((o) => new Setting(o)), meta };
  };

  const fetchGroups = async (
    params: SettingRequestParam
  ): Promise<GroupCollectionResponse> => {
    return await settingService.groups(params);
  };

  const updateSetting = async (
    id: number | string,
    params: Setting
  ): Promise<Setting> => {
    try {
      return new Setting(await settingService.update(id, params));
    } catch (e) {
      throw e;
    }
  };
  return { fetchSettings, updateSetting, fetchGroups };
});

export interface UseSettings {
  fetchSettings: (params: any) => Promise<SettingCollectionResponse>;
  fetchGroups: (params: any) => Promise<GroupCollectionResponse>;
  updateSetting: (id: number | string, params: Setting) => Promise<Setting>;
}
