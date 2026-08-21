import { ApiService } from '@/api';
import { type CollectionResponse } from '@/types/response';
import Setting from '@/types/models/setting';
import {
  GroupCollectionResponse,
  SettingResponse,
} from '@/types/setting';

export default class SettingService extends ApiService {
  protected readonly endpoint = 'settings';

  public list(params: any): Promise<CollectionResponse> {
    return new Promise((resolve, reject) => {
      return this.getRequest(this.url(''), params)
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }

  public groups(params: any): Promise<GroupCollectionResponse> {
    return new Promise((resolve, reject) => {
      return this.getRequest(this.url('groups'), params)
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }

  public update(
    id: number | string,
    params: Setting
  ): Promise<SettingResponse> {
    return new Promise((resolve, reject) => {
      return this.putRequest(this.url(id), params)
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }
}
