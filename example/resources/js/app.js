import "../css/app.scss";
import { createApp } from 'vue';
import App from './App.vue'
import router from './router';
// Vuetify
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as labsComponents from 'vuetify/labs/components'
import * as directives from 'vuetify/directives'
import { createPinia } from 'pinia'
import VuetifyNotifier from 'vuetify-notifier'

const myCustomLightTheme = {
    dark: false,
    colors: {
        background: '#ffffff',
        surface: '#FFFFFF',
        primary: '#018786',
        'primary-darken-1': '#018786',
        secondary: '#03DAC6',
        'secondary-darken-1': '#018786',
        error: '#B00020',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FB8C00',
    },
}


const vuetify = createVuetify({
    components: {
        ...components,
        ...labsComponents,
    },
    directives,
    theme: {
        defaultTheme: 'myCustomLightTheme',
        themes: {
            myCustomLightTheme,
        },
    }
})

const app = createApp(App)

app.use(router)
app.use(vuetify)
app.use(createPinia())
app.use(VuetifyNotifier, {
    default: {
        defaultColor: 'primary', //default color for all notifications
        closeIcon: 'mdi-close', //default close icon for component
    },
})
app.mount('#app')
