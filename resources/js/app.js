import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import Uploader from 'vue-media-upload';

import Toast, { TYPE }  from "vue-toastification";
import "vue-toastification/dist/index.css";

const toastOptions = {
    toastDefaults: {
        // ToastOptions object for each type of toast
        [TYPE.DEFAULT]: {
            timeout: 3000,
            hideProgressBar: true,
        }
    }
};
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Books';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Uploader)
            .use(ZiggyVue, Ziggy)
            .use(Toast, toastOptions)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
