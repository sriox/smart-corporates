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
                    name: string
                }
            }
            laravelVersion: string
            phpVersion: string
        }
    }
}
