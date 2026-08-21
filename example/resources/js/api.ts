import axios, {AxiosInstance} from 'axios'
import {useAuth} from '@/stores/auth-store'
import {storeToRefs} from 'pinia'

export const client = (): AxiosInstance => {
    const client = axios.create({
        baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost:7760/api',
        headers: {
            'Content-Type': 'application/json'
        }
    })

    client.interceptors.request.use((request) => {
        const {token} = storeToRefs(useAuth())
        if (token.value) {
            request.headers['Authorization'] = `Bearer ${token.value}`
        }

        return request
    })

    return client
}

export abstract class ApiService {
    public api: AxiosInstance = client()

    protected abstract readonly endpoint: string

    public getRequest<T = any>(url: string, params?: any): Promise<T> {
        return new Promise<T>((resolve, reject) => {
            this.api
                .get(url, {params: params})
                .then((res) => resolve(res.data?.data || res.data))
                .catch((err) => reject(err))
        })
    }

    public postRequest<T = any, U = any>(url: string, data?: T): Promise<U> {
        return new Promise<U>((resolve, reject) =>
            this.api.post(url, data)
                .then((res) => resolve((res.data?.data || res.data?.message || res.data) as U))
                .catch((err) => reject(err))
        )
    }

    public putRequest<T = any, U = any>(url: string, data?: T): Promise<U> {
        return new Promise<U>((resolve, reject) => {
            this.api.put(url, data)
                .then((res) => resolve((res.data?.data || res.data) as U))
                .catch((err) => reject(err))
        })
    }

    public patchRequest<T = any, U = any>(url: string, data: T): Promise<U> {
        return new Promise<U>((resolve, reject) => {
            this.api
                .patch(url, data)
                .then((res) => resolve(res.data?.data as U))
                .catch((err) => reject(err))
        })
    }

    public deleteRequest<T = void>(url: string): Promise<T> {
        return new Promise<T>((resolve, reject) => {
            this.api
                .delete(url)
                .then((res) => resolve(res.data?.data))
                .catch((err) => reject(err))
        })
    }

    protected url(...args: (string | number)[]): string {
        args.unshift(this.endpoint)

        return args.filter(Boolean).join('/')
    }
}

