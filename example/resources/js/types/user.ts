import {CollectionResponse, type Pagination, type Resource} from '@/types/response'
import User from '@/types/models/user';

export interface UserData {
    readonly id: string | number | null
    name: string | null
    email: string | null
    role: string | null
    createdAt: string | null
}

export interface UserResponse extends Resource {
    attributes: UserData
}

export interface UserFilter {
    query: string | null,
    role: string | null
}

export interface UserRequestParam {
    filter: UserFilter,
    page: Pagination
}

export interface UserCollectionResponse extends Omit<CollectionResponse, 'data'> {
    data: User[]
}
