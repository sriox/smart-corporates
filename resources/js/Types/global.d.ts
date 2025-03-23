export {}

declare global {
    interface ImportMetaEnv {
        env: {
            VITE_API_URL: string
        }
    }

    interface Dimension {
        id: number
        poll_id: number
        name: string
        slug: string
        description: string
    }

    interface ParticipantPollAnswer {
        pollAnswer: {
            id: number
            value: number
        }
        question: {
            question: string
            variable: string
            description: string
            order: number
            question_grop: {
                name: string
                slug: string
                description: string
            }
        }
    }

    interface DimensionResult {
        poll_instance_id: number
        dimension_id: number
        order: number
        dimension: string
        value: number
        factor: number
        result: number
    }

    interface DimensionAttributeResult {
        dimension: string
        attribute: string
        result: number
    }

    interface DimensionAttributeVariableResult {
        poll_instance_id: number
        dimension_id: number
        dimension: string
        attribute_id: number
        attribute_name: string
        question_id: number
        question_variable: string
        result: number
    }

    interface TopHighAttributeResult {
        attribute: string
        result: number
    }

    interface TopLowAttributeResult {
        attribute: string
        result: number
    }
    interface TopIndicatorResult {
        question_variable: string
        result: number
    }

    interface OpenQuestionWord {
        id: number
        open_question_id: number
        word: string
        frequency: number
        weight: number
        word_count: number
    }

    interface OpenQuestion {
        id: number
        poll_id: number
        question: string
        description: string
        type: string
        open_question_words: OpenQuestionWord[]
    }

    interface PollInstance {
        id: number
        company: Company
        user_id: number
        poll_id: number
        code: string
        notes: string
        start_at?: Date
        end_at?: Date
        created_at: Date
        updated_at: Date
        deleted_at?: Date
        completedCount: number
        participantsCount: number
        participants?: Participant[]
    }

    interface Company {
        address: string
        city_id: number
        created_at: Date
        deleted_at: Date
        document: string
        email: string
        id: number
        logo_path: string
        logo_url: string
        name: string
        phone: string
        slug: string
        updated_at: Date
    }
}
