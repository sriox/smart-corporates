import type { Page, PageProps, Errors, ErrorBag } from '@inertiajs/inertia'

declare global {
    interface InertiaPage extends Page<PageProps> {
        props: {
            errors: Errors & ErrorBag
            flash: {
                message: string
            }
            auth: {
                user: {
                    id: number
                    name: string
                    email: string
                    current_team_id?: number
                    current_team?: {
                        id: number
                        name: string
                    }
                    all_teams?: Array<{
                        id: number
                        name: string
                    }>
                    profile_photo_url?: string
                } | null
            }
            laravelVersion: string
            phpVersion: string
        }
    }
}
