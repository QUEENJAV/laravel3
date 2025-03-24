// import { useAuthStore } from '../stores/store';
// import { createPinia } from 'pinia'
// import { createApp } from 'vue'

// const pinia = createPinia()

// authStore = useAuthStore()
// export const handeAuthStore = (data) => {
//     authStore.$patch({currentUser: data})
//   }

import { useAuthStore } from '../stores/store';   

export const handeAuthStore = (data) => {  
  const authStore = useAuthStore();   
  authStore.$patch({ currentUser: data });  
}; 