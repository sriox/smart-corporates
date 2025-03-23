import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import { usePage } from '@inertiajs/inertia-vue3'

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
/* import specific icons */
import { faList, faPenToSquare, faTrash, faRuler, faUser, faPaperPlane, faChartSimple, faThumbsUp, faPlus, faDownload } from '@fortawesome/free-solid-svg-icons'
/* add icons to the library */
library.add([faList, faPenToSquare, faTrash, faRuler, faUser, faPaperPlane, faChartSimple, faThumbsUp, faPlus, faDownload])

import DataTable from '@/Components/DataTable.vue'
import Button from '@/Components/Button.vue'
import Title from '@/Components/Title.vue'
import Space from '@/Components/Space.vue'
import EditButton from '@/Components/EditButton.vue'
import DeleteButton from '@/Components/DeleteButton.vue'
import UserButton from '@/Components/UserButton.vue'
import SendButton from '@/Components/SendButton.vue'
import RadioButton from '@/Components/RadioButton.vue'
import RadioButtonGroup from '@/Components/RadioButtonGroup.vue'
import PollSection from '@/Components/Poll/PollSection.vue'
import PollQuestion from '@/Components/Poll/PollQuestion.vue'
import Checkbox from '@/Components/Checkbox.vue'
import Input from '@/Components/Input.vue'
import Modal from '@/Components/Modal.vue'
import FormSelect from '@/Components/FormSelect.vue'
import FormTextArea from '@/Components/FormTextArea.vue'
import CompanyLogo from '@/Components/Company/CompanyLogo.vue'
import Indicator from '@/Components/Dashboard/Indicator.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import IndexLayout from '@/Layouts/IndexLayout.vue'
import SubmitLayout from '@/Layouts/SubmitLayout.vue'
import SubmitFinishLayout from '@/Layouts/SubmitFinishLayout.vue'
import moment from 'moment'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

// Plugin para acceder al usuario actual de forma global
const userPlugin = {
    install: (app, options) => {
        app.config.globalProperties.$user = {
            get current() {
                return usePage().props.value.auth.user
            },
            get name() {
                return this.current?.name
            },
            get email() {
                return this.current?.email
            },
            get isLoggedIn() {
                return !!this.current
            }
        }
    }
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(userPlugin)
            .component('AppLayout', AppLayout)
            .component('Button', Button)
            .component('Checkbox', Checkbox)
            .component('CompanyLogo', CompanyLogo)
            .component('DataTable', DataTable)
            .component('DeleteButton', DeleteButton)
            .component('EditButton', EditButton)
            .component('font-awesome-icon', FontAwesomeIcon)
            .component('FormSelect', FormSelect)
            .component('FormTextArea', FormTextArea)
            .component('IndexLayout', IndexLayout)
            .component('Indicator', Indicator)
            .component('Input', Input)
            .component('Modal', Modal)
            .component('PollQuestion', PollQuestion)
            .component('PollSection', PollSection)
            .component('RadioButton', RadioButton)
            .component('RadioButtonGroup', RadioButtonGroup)
            .component('SendButton', SendButton)
            .component('Space', Space)
            .component('SubmitFinishLayout', SubmitFinishLayout)
            .component('SubmitLayout', SubmitLayout)
            .component('Title', Title)
            .component('UserButton', UserButton)

        // Filters
        app.config.globalProperties.$filters = {
            decimals(value, positions = 0) {
                if (isNaN(value)) return value

                return parseFloat(value).toFixed(positions)
            },
            date(value) {
                return moment(value).format('DD/MM/YYYY')
            },
            datetime(value) {
                return moment(value).format('dd/mm/YY HH:ii:ss')
            },
        }

        app.mount(el)
    },
})

InertiaProgress.init({ color: '#4B5563' })
