import {ApiService} from '@/api'
import {type LoginRequest, type LoginResponse} from '@/types/auth'
import {type UserResponse} from '@/types/user';

export default class AuthService extends ApiService {
    protected readonly endpoint = ''

    public login(data: LoginRequest): Promise<LoginResponse> {
        return new Promise((resolve, reject) => {
            return this.postRequest(this.url('login'), data)
                .then((res) => {
                    console.log(res)
                    resolve(res)
                })
                .catch((err) => reject(err.response.data))
        })
    }

    public user(): Promise<UserResponse> {
        return new Promise((resolve, reject) => {
            return this.getRequest(this.url('user'))
                .then((res) => {
                    resolve(res)
                })
                .catch((err) => reject(err.response.data))
        })
    }

    public logout(): Promise<void> {
        return new Promise((resolve, reject) => {
            return this.postRequest(this.url('logout'))
                .then((res) => {
                    resolve(res)
                })
                .catch((err) => reject(err.response.data))
        })
    }
}
