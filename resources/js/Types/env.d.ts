interface ImportMetaEnv extends Readonly<Record<string, string>> {
    readonly VITE_API_URL: string
    readonly VITE_APP_URL: string
    readonly NODE_ENV: 'development' | 'production'
    readonly PORT?: string
    readonly PWD: string
    // more env variables...
}
interface ImportMeta {
    readonly env: ImportMetaEnv
}
