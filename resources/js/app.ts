import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import '../css/app.css';
import MainLayout from '@/Layouts/MainLayout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
 
createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: async (name) => {
        const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue'))
        page.default.layout = page.default.layout || MainLayout;
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

//app.js (is js not ts at here)
//...
// createInertiaApp({
//     resolve: async (name) => {
//         const pages = import.meta.glob('./Pages/**/*.vue')
//         return (await pages[`./Pages/$[name].vue`]())
//     },
//     setup({el, App, props, plugin}) {
//         createApp({ render: () => h(App, props) })
//         .use(plugin)
//         .mount(el)
//     },
// })
// to become this: (changed to use it here so, we no need to define <script> with importing MainLayout.vue in each page that want to use that component)
// app.js (is js not ts at here)
//...
// createInertiaApp({
//     resolve: async (name) => {
//         const pages = import.meta.glob('./Pages/**/*.vue')
//         const page = (await pages[`./Pages/$[name].vue`]())
//         page.default.layout = page.default.layout || MainLayout
//         return page
//     },
//     setup({el, App, props, plugin}) {
//         createApp({ render: () => h(App, props) })
//         .use(plugin)
//         .mount(el)
//     },
// })