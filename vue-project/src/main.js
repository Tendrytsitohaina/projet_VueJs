import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './main.css'

function burgerChange(x){
    x.classList.toggle('change');
}

createApp(App).use(router).mount('#app')
