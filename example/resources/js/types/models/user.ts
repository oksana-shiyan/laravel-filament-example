import { type UserData, type UserResponse } from '@/types/user';

export default class User implements UserInterface {
  id: number | string | null;
  name: string | null;
  email: string | null;
  role: string | null;
  createdAt: string | null;

  constructor(data?: UserResponse) {
    this.id = data?.id || null;
    this.name = data?.attributes.name || null;
    this.email = data?.attributes.email || null;
    this.role = data?.attributes.role || null;
    this.createdAt = data?.attributes.createdAt || null;
  }
}

export interface UserInterface extends UserData {
  id: number | string | null;
}


export declare type UserGroupFilters = 'query';
