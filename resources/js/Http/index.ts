import Axios, { AxiosInstance } from 'axios'
const baseURL = import.meta.env.VITE_APP_URL + '/api'

const axios: AxiosInstance = Axios.create({
    baseURL,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
})

export default axios
