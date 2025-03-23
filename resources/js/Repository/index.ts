import Axios from 'axios'

let input = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement
var csrf = input.content

const axios = Axios.create({
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrf,
    },
})

// axios.defaults.withCredentials = true

export function useRepo() {
    return {
        get(url: string, params: Record<string, any> = {}) {
            return axios.get(url, { params })
        },
        post(url: string, body: Record<string, any> = {}) {
            return axios.post(url, body)
        },
    }
}
