<script>  
import { ref, onMounted } from 'vue';  
import axios from 'axios';  

const user = ref();  

export default {  
  setup() {  
    const user = ref(null); 

    onMounted(async () => {  
      try {  
        const token = localStorage.getItem('token');   
        const response = await axios.get('/api/user', {  
          headers: {  
            Authorization: `Bearer ${token}`,  
          },  
        });  
        user.value = response.data;  
      } catch (error) {  
        // console.error('Error fetching user:', error);  
        
      }  
    });  

    return { user }; 
  },  
};  

// onMounted(async () => {  
//     try {  
//         const token = localStorage.getItem('token'); // Assurez-vous que le token est présent ici  
//         const response = await axios.get('/api/user', {  
//             headers: {  
//                 Authorization: `Bearer ${token}`, // Inclure le token dans l'en-tête  
//             },  
//         });  
//         user.value = response.data;  
//     } catch (error) {  
//         console.error('Error fetching user:', error);  
//         // Vous pouvez également gérer les erreurs ici, par exemple afficher un message à l'utilisateur  
//     }  
// });  
</script>  

<template>

<!-- <div>
  <h1>home Page</h1>
  <h1>{{ user?.name }}</h1>
  <h1>{{ user?.email }}</h1>
</div> -->

    <div class="flex min-h-screen w-screen flex-col bg-gradient-to-l from-slate-800 to-violet-900">
      <header class="relative flex w-screen max-w-screen-xl flex-col overflow-hidden px-4 py-4 text-white md:mx-auto md:flex-row md:items-center"> 
    
    
    
  </header>

<div class="sm:my-auto mx-auto px-4 py-16 sm:max-w-xl md:max-w-full md:px-24 lg:max-w-screen-xl lg:px-8 lg:py-20">
    <div class="flex flex-col items-center justify-between lg:flex-row">
      <div class="mb-10 lg:mb-0 lg:max-w-lg lg:pr-5">
        <div class="mb-6 max-w-xl">
          <div>
            <p class="bg-teal-accent-400 mb-2 inline-block rounded-full px-3 text-xs font-semibold uppercase tracking-wider text-gray-50">Nouveau flux </p>
          </div>
          <h2 class="mb-6 max-w-lg font-sans text-3xl font-bold leading-snug tracking-tight text-white sm:text-5xl sm:leading-snug">
            Gérez Vos Contacts 
            <span class="my-1 inline-block rounded bg-white px-2 text-violet-600">Facilement </span>
            et Efficacement !
          </h2>
          <p class="text-base text-gray-200">La solution idéale pour organiser, suivre et collaborer avec vos contacts, où que vous soyez.</p>
        </div>
        <div class="flex flex-col items-center md:flex-row">
          <a href="/" class="mb-3 inline-flex h-12 w-full items-center justify-center rounded bg-violet-700 px-6 font-medium tracking-wide text-white shadow-md transition duration-200 hover:bg-violet-800 focus:outline-none md:mr-4 md:mb-0 md:w-auto">Commencé maintenant </a>
          
        </div>
      </div>
      <!-- <div class="relative shadow-xl shadow-violet-700 lg:w-1/2"> -->
        <!-- <img class="h-56 w-full rounded object-cover shadow-lg sm:h-96" src="/images/kIaysJ28maHz8lbmq_KsQ.png" alt="" /> --> 
        <!-- <a href="/" aria-label="Play Video" class="group absolute inset-0 flex h-full w-full items-center justify-center bg-gray-900 bg-opacity-30 transition-colors duration-300 hover:bg-opacity-10">
          <div class="flex h-16 w-16 transform items-center justify-center rounded-full bg-gray-100 shadow-2xl transition duration-300 group-hover:scale-110">
            <svg class="w-10 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
              <path d="M16.53,11.152l-8-5C8.221,5.958,7.833,5.949,7.515,6.125C7.197,6.302,7,6.636,7,7v10 c0,0.364,0.197,0.698,0.515,0.875C7.667,17.958,7.833,18,8,18c0.184,0,0.368-0.051,0.53-0.152l8-5C16.822,12.665,17,12.345,17,12 S16.822,11.335,16.53,11.152z"></path>
            </svg>
          </div>
        </a>
      </div> -->
    </div>
  </div>
</div> 

</template>
<script setup>

</script>