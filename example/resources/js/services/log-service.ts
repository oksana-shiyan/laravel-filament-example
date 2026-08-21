import { ApiService } from '@/api';
import {LogCollectionResponse} from '@/types/log';


export default class LogService extends ApiService {
  protected readonly endpoint = 'logs';

  public list(): Promise<LogCollectionResponse> {
    return new Promise((resolve, reject) => {
      return this.getRequest(this.url(''), )
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }

  public download(key: string): Promise<UserResponse> {
    return new Promise((resolve, reject) => {
      return this.getRequest(this.url(key))
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }
}
