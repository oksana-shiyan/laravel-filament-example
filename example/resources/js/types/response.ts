export interface CollectionResponse {
    data: Resource[],
    meta?: Pagination
}

export interface Resource {
    id: number,
    attributes: any
}

export interface Pagination {
    page: number,
    perPage: number,
    total: number
}

export class PaginationResponse {
}