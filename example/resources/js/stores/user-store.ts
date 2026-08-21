import { defineStore } from 'pinia';
import UserService from '@/services/user-service';
import User from '@/types/models/user';
import {
  type UserCollectionResponse,
  type UserRequestParam,
} from '@/types/user';
import ChangePassword from "@/types/models/changePassword";

export const useUser = defineStore('user', (): UseUsers => {
  const userService = new UserService();

  const fetchUsers = async (
    params: UserRequestParam
  ): Promise<UserCollectionResponse> => {
    const { data, meta } = await userService.list(params);
    return { data: data.map((o) => new User(o)), meta };
  };

  const fetchUser = async (id: number | string): Promise<User> => {
    try {
      return new User(await userService.show(id));
    } catch (e) {
      throw e;
    }
  };

  const updateUser = async (
    id: number | string,
    params: User
  ): Promise<User> => {
    try {
      return new User(await userService.update(id, params));
    } catch (e) {
      throw e;
    }
  };

  const createUser = async (params: User): Promise<User> => {
    try {
      return new User(await userService.create(params));
    } catch (e) {
      throw e;
    }
  };

  const deleteUser = async (id: number): Promise<void> => {
    await userService.delete(id);
  };

    const changePassword = async (data: ChangePassword): Promise<void> => {
        await userService.changePassword(data);
    };

    return { fetchUsers, deleteUser, fetchUser, updateUser, createUser, changePassword };
});

export interface UseUsers {
  fetchUsers: (params: any) => Promise<UserCollectionResponse>;
  deleteUser: (id: number) => Promise<void>;
  fetchUser: (id: number | string) => Promise<User>;
  updateUser: (id: number | string, params: User) => Promise<User>;
  createUser: (params: User) => Promise<User>;
  changePassword: (params: ChangePassword) => Promise<void>;
}
