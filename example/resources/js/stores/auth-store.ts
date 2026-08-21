import {type Ref, ref} from 'vue'
import {defineStore} from 'pinia'
import AuthService from '@/services/auth-service'
import type {LoginRequest, LoginResponse} from '@/types/auth'
import User, {type UserInterface} from '@/types/models/user'
import {type UserResponse} from '@/types/user';

export const useAuth = defineStore('auth', (): UseAuth => {
    const user = ref<User>(new User())
    const authService = new AuthService();
    const token = ref<String>(localStorage.getItem('token') as String)

    const updateToken = (newToken: String): void => {
        token.value = newToken
        localStorage.setItem('token', newToken as string)
    }
    const login = async (data: LoginRequest): Promise<void> => {
        const loginResponse: LoginResponse = await authService.login(data);
        updateToken(loginResponse.accessToken as String)
    }

    const fetchUser = async (): Promise<void> => {
        const userResponse: UserResponse = await authService.user();
        user.value = new User(userResponse);
    }

    const logout = async (): Promise<void> => {
        await authService.logout();
        localStorage.removeItem('token')
        token.value = ''
    }

    return {token, user, login, fetchUser, logout}
})

export interface UseAuth {
    user: Ref<User | null>,
    login: (data: LoginRequest) => Promise<void>,
    fetchUser: () => Promise<void>,
    logout: () => Promise<void>,
    token: Ref<String>
}
