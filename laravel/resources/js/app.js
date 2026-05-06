import '../css/app.css'
import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import axios from 'axios'

const token = localStorage.getItem('token')

if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

router.on('start', (event) => {
    const token = localStorage.getItem('token')

    if (token) {
        event.detail.visit.headers['Authorization'] = `Bearer ${token}`
    }
})

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue')
        const page = pages[`./Pages/${name}.vue`]

        if (!page) throw new Error(`Page not found: ${name}`)

        return await page()
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})