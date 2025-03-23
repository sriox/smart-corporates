export interface Person {
    id: number
    company_id: number
    first_name: string
    last_name: string
    document: string
    phone?: string
    email: string
    created_at: Date
    updated_at: Date
    deleted_at?: Date
    participants_count?: number
    completed_count?: number
    name: string
    participants?: Participant[]
}

export interface Participant {
    id: number
    person_id: number
    poll_instance_id: number
    code: string
    start_at: Date
    finish_at?: Date
    policy_accepted_at?: Date
    age_range_id?: number
    gender_id?: number
    service_time_range_id?: number
    company_level_id?: number
    area_id?: number
    division_id?: number
    created_at: Date
    updated_at: Date
    deleted_at?: Date
    latest_state?: LatestState
}

export interface LatestState {
    id: number
    event: string
    participant_id: number
    valid: number
}

export type Status = 'success' | 'info' | 'error' | 'warning' | ''
