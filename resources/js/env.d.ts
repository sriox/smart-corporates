interface ImportMetaEnv extends Readonly<Record<string, string>> {
    readonly VITE_APP_URL: string
    // more env variables...
}

interface ImportMeta {
    readonly env: ImportMetaEnv
}
