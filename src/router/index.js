import { createRouter, createWebHistory } from "vue-router";

import Home from '../pages/Home.vue'
import LoginPage from '../pages/Login.vue'
import RegisterPage from '../pages/Register.vue'
import ContactForm from "../pages/ContactForm.vue"
import notFound from '../components/notFoun.vue'
import ContactListe from "../pages/ContactListe.vue"
import GroupeListe from "../pages/GroupeListe.vue"
import GroupeForm from "../pages/GroupeForm.vue"
import Favoris from "../pages/Favoris.vue";
import path from 'path'; 

const routes = [
    {  
        path: '/:pathMatch(.*)*',  
        name: 'NotFound',  
        component: notFound 
    },
    {
        path: '/',
        name: 'Home',
        component: Home
    },

    {
        path: '/login',
        name: 'Login',
        component:LoginPage
        
    },
    {
        path: '/register',
        name: 'Register',
        component:RegisterPage
        // component: () => import("../pages/Register.vue"),
        
    },
   
    {
        path: '/contacts/store',
        name: 'ContactForm',
        component: () => import("../pages/ContactForm.vue"),
        
    },
    {  
        path: '/contacts/index',  
        name: 'contacts.index',  
        component: ContactListe 
    },
    {
        path:'/contacts/:id/show',
        name:'contacts.show',
        component:ContactForm
    },
    {  
        path: '/groupes/store',  
        name: 'groupes.store',  
        component: GroupeForm
    },
    {  
        path: '/groupes/index',  
        name: 'groupes.index',  
        component: GroupeListe
    },
    // {  
    //     path: '/favoris/store',  
    //     name: 'favoris.store',  
    //     component: favorisForm
    // },
    {  
        path: '/favoris/index',  
        name: 'favoris.index',  
        component: Favoris
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes
});


export default router