
import { defineStore } from "pinia";  
import axios from "axios";  

export const useAuthStore = defineStore("auth", {  
  state: () => ({  
    currentUser: null,  
  }),  
  actions: {  
    async login(credentials) {  
      const response = await axios.post('/api/login', credentials);  
      const token = response.data.token;  
      localStorage.setItem('token', token);   
      this.setCurrentUser(response.data.user); // Assurez-vous de définir l'utilisateur après la connexion  
    },  
    setCurrentUser(user) {  
      this.currentUser = user;  
    },  
    async getUser() {  
      const response = await axios.get('/api/user');  
      this.setCurrentUser(response.data);  
    },  
  },  
  getters: {  
    user: (state) => state.currentUser,  
  },  
});




// import { defineStore } from "pinia";
// import axios from "axios";


// import { createStore } from 'vuex';  

// const store = createStore("auth", {  
//   state: () => ({  
//     currentUser: null,  
//   }),  
//   getters: {  
//     user: (state) => state.currentUser,  
//   },  

//   actions:{
//     async getToken () {
//       await axios.get('/sanctum/csrf-cookie')
//     },
//     async getUser(){
//       const data = await axios.get('/api/user');
//       user.currentUser = data.data;
//     }
  
//   },
//   // mutations: {  
//   //   setUser(state, user) {  
//   //     state.currentUser = user; // Mutation pour définir l'utilisateur  
//   //   },  
//   //   clearUser(state) {  
//   //     state.currentUser = null; // Mutation pour effacer l'utilisateur  
//   //   },  
//   // },  
// });  

// export default store;
    // store.js  
// import { defineStore } from "pinia";  
// import axios from "axios";  

// export const useAuthStore = defineStore("auth", {  
//   state: () => ({  
//     currentUser: null,  
//   }),  
//   mutations: {  
//     setCurrentUser(state, user) {  
//       state.currentUser = user;  
//     }  
//   },
//   getters: {  
//     user: (state) => state.currentUser,  
//   },  
//   actions: {  
//     async login(credentials) {  
//       const response = await axios.post('/api/login', credentials);  
//       this.token = response.data.token;  
//       localStorage.setItem('token', this.token); 
//   },  
//   setCurrentUser(user){
//     this.currentUser = user;
//   },
//     async getToken() {  
//       await axios.get('/sanctum/csrf-cookie');  
//     },  

//     async getUser() {  
//       const response = await axios.get('/api/user');  
//       this.currentUser = response.data;  
//     },  
//   },  
// });