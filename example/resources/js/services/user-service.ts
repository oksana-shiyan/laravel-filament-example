import { ApiService } from '@/api';
import { type CollectionResponse } from '@/types/response';
import User from '@/types/models/user';
import { type UserResponse } from '@/types/user';
import ChangePassword from "@/types/models/changePassword";

export default class UserService extends ApiService {
  protected readonly endpoint = 'users';

  public list(params: any): Promise<CollectionResponse> {
    return new Promise((resolve, reject) => {
      return this.getRequest(this.url(''), params)
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }

  public show(id: number | string): Promise<UserResponse> {
    return new Promise((resolve, reject) => {
      return this.getRequest(this.url(id))
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }

  public create(params: User): Promise<UserResponse> {
    return new Promise((resolve, reject) => {
      return this.postRequest(this.url(''), params)
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }

  public update(id: number | string, params: User): Promise<UserResponse> {
    return new Promise((resolve, reject) => {
      return this.putRequest(this.url(id), params)
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }

  public delete(id: number): Promise<void> {
    return new Promise((resolve, reject) => {
      return this.deleteRequest(this.url(id))
        .then((res) => {
          resolve(res);
        })
        .catch((err) => reject(err.response));
    });
  }

    public changePassword(params: ChangePassword): Promise<UserResponse> {
        return new Promise((resolve, reject) => {
            return this.postRequest(this.url('change-password'), params)
                .then((res) => {
                    resolve(res);
                })
                .catch((err) => reject(err.response));
        });
    }
}
