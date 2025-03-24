
import { createApp } from 'vue';  
import './assets/tailwind.css';  
import App from './App.vue';  
import router from './router';  
import { createPinia } from 'pinia';  
import '../axios';   

const pinia = createPinia();   
const app = createApp(App);  
app.use(pinia);  
app.use(router);   

app.mount('#app');  


// import { createApp } from 'vue';  
// // import './style.css'  
// import './assets/tailwind.css';  
// import App from './App.vue';  
// import router from './router';  
// import { createPinia } from 'pinia';  
// import '../axios';   
//  ///import { useAuthStore } from './stores/store';  
 
// const pinia = createPinia();   
// const app = createApp(App);  
// //const authStore=useAuthStore();
// //app.use(authStore)
// app.use(pinia);  
// app.use(router);  
 
// app.mount('#app');  