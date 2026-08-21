import {type Resource} from '@/types/response'

export interface LogResource extends Resource {
    name: string,
    key: string
}

export interface LogCollectionResponse {
    files: Array<LogResource>
}

