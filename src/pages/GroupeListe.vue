<template>  
  <div class="mx-auto max-w-screen-lg px-4 py-8 sm:px-8">  
    <div class="flex items-center justify-between pb-0">  
      <div>  
        <h2 class="font-semibold text-gray-700">All</h2>  
        <div class="relative mb-5 w-full flex items-center justify-between rounded-md">  
          <svg class="absolute left-2 block h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">  
            <circle cx="11" cy="11" r="8"></circle>  
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>  
          </svg>  
          <input 
           type="text"
           name="search"
           class="h-12 w-full cursor-text rounded-md border border-gray-100 bg-gray-100 py-4 pr-40 pl-12 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Search contact..." v-model="searchQuery" />  
        </div>  
      </div>  
      <div class="ml-10 space-x-8 lg:ml-40">  
        <button @click="newGroupes" class="flex items-center gap-2 rounded-md bg-gradient-to-l from-slate-800 to-violet-900 px-4 py-2 text-sm font-semibold text-white focus:outline-none focus:ring hover:bg-blue-700">  
          Nouveau  
        </button>  
      </div>  
    </div>  

    <div v-if="isEditing" class="my-4 max-w-screen-md border px-4 shadow-xl sm:mx-4 sm:rounded-xl sm:px-4 sm:py-4 md:mx-auto">  
        <div class="flex flex-col border-b py-4 sm:flex-row sm:items-start">  
            <div class="shrink-0 mr-auto sm:py-3">  
                <h1 class="font-medium">  
                    <span v-if="editMode">Modifier</span>  
                    <!-- <span v-else>Ajouter</span>   -->
                    un groupe  
                </h1>  
            </div>  
            <button @click="cancel" class="mr-2 hidden rounded-lg border-2 px-4 py-2 font-medium text-gray-500 sm:inline focus:outline-none focus:ring hover:bg-gray-200">Cancel</button>  
            <button @click="updateGroupe" class="hidden bg-gradient-to-l from-slate-800 to-violet-900 rounded-lg border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white sm:inline focus:outline-none focus:ring hover:bg-blue-700">Save</button>  
        </div>  

        
        <form @submit.prevent="updateGroupe">  
            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">Nom</p>  
                <input type="text" v-model="form.nom" placeholder="Nom" class="mb-2 w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" />  
                <!-- <small v-if="errors.nom" class="text-red-500">{{ errors.nom }}</small>   -->
            </div>  

            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">Description</p>  
                <input type="text" v-model="form.description" placeholder="description" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
                <!-- <small v-if="errors.description" class="text-red-500">{{ errors.description }}</small>   -->
            </div> 
            <!-- <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">user</p>  
                <input type="text" v-model="form.user" placeholder="Groupe" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
                <small v-if="errors.user" class="text-red-500">{{ errors.user }}</small>  
            </div>   -->

            
            <div class="mt-6">  
                <button type="submit" class="rounded-lg border-2 bg-gradient-to-l from-slate-800 to-violet-900 border-transparent bg-blue-600 px-4 py-2 font-medium text-white focus:outline-none focus:ring hover:bg-blue-700">  
                    Mettre à jour le groupe  
                </button>  
            </div>  
        </form>  

        <!-- Message de Succès -->  
        <div v-if="successMessage" class="mt-4 p-2 bg-green-100 text-green-700 border border-green-300 rounded">  
            {{ successMessage }}  
        </div>  
    </div> 
    <div class="overflow-y-hidden rounded-lg border">  
      <div class="overflow-x-auto">  
        <table class="w-full">  
          <thead>  
            <tr class="bg-gradient-to-l from-slate-800 to-violet-900 text-left text-xs font-semibold uppercase tracking-widest text-white">  
              <th class="px-5 py-3">Nom</th>  
              <th class="px-5 py-3">Description</th>  
              <th class="px-5 py-3">Status</th>  
            </tr>  
          </thead>  
          <tbody class="text-gray-500">  
            <tr v-for="groupe in groupes" :key="groupe.id">  
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">  
                <p class="whitespace-no-wrap">{{ groupe.nom }}</p>  
              </td>  
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">  
                <p class="whitespace-no-wrap">{{ groupe.description }}</p>  
              </td>  
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">  
                <button @click="emitEdit(groupe.id)" class="bg-green-500 text-white p-1 ml-2 rounded">Modifier</button>  
                <button @click="deleteGroupe(groupe.id)" class="bg-red-500 text-white p-1 ml-2 rounded">Supprimer</button>  
                <button class="bg-yellow-500 text-white p-1 ml-2 rounded">Contacts groupe</button>  
              </td>  
            </tr>  
          </tbody>  
        </table>  
      </div>  
      <div class="flex flex-col items-center border-t bg-white px-5 py-5 sm:flex-row sm:justify-between">  
        <div class="mr-40 ml-40 px-40"></div>  
        <a class="btn text-xs text-gray-600 sm:text-sm border-1" href="#" 
        v-for="(link, index) in links"
         :key="index"
          v-html="link.label" 
          :class="{active:link.active, disable: !link.url}" 
          @click.prevent="changePage(link)">
        </a>  
      </div>  
    </div>  
  </div>  
</template>  

<script setup>  
import axios from "axios";  
import { ref, onMounted, watch } from "vue";  
import { useRouter } from 'vue-router';  
import Swal from "sweetalert2";  

const router = useRouter();  
const groupes = ref([]);  
const links = ref([]);  
const searchQuery = ref('');  
let isEditing = ref(false);
let currentGroupId = ref(null);
let form = ref({  
    nom: '',  
    description: '' 
}); 
 
  
onMounted(async () => {  
  await getGroupes();  
});  

watch(searchQuery, async () => {  
  await getGroupes();  
});  

const newGroupes = () => {  
  router.push('/groupes/store');  
};  

const emitEdit = async (id) => {  
  //axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
  try {  
    const response = await axios.get(`/groups/${id}`);  
    form.value.nom = response.data.nom;  
    form.value.description = response.data.description;  
    currentGroupId.value = id;  
    isEditing.value = true;  
  } catch (error) {  
    console.error('Erreur lors de la récupération du groupe :', error);  
  }  
}; 
const updateGroupe = async () => {  
  try {  
    await axios.put(`/groups/${currentGroupId.value}`, form.value);  
    Swal.fire({  
      icon: "success",  
      title: "Succès",  
      text: "Groupe mis à jour"  
    }); 
    isEditing.value = false;  
    await getGroupes();  
  } catch (error) {  
    console.error('Erreur lors de la mise à jour du groupe :', error);  
    Swal.fire({  
      title: 'Erreur',  
      text: 'Impossible de mettre à jour le groupr. Veuillez réessayer.',  
      icon: 'error',  
    });  
  }  
};

const getGroupes = async () => {  
  try {  

    const response = await axios.get(
      '/groups?&searchQuery='+searchQuery.value,
    );  
    groupes.value = response.data.data;  
    links.value = response.data.links;  

    console.log(response.data.data, "data");
    
  } catch (error) {  
    // console.error('Error fetching groupes:', error);  
    Swal.fire('Error', 'Could not fetch groupes. Please try again later.', 'error');  
  }  
};  

const changePage = async (link) => {  
  if (!link.url || link.active) {  
    return;  
  }  
  try {  
    const response = await axios.get(link.url);  
    groupes.value = response.data.data;  
    links.value = response.data.links;  
  } catch (error) {  
    console.error('Error changing page:', error);  
    Swal.fire('Error', 'Could not change page. Please try again later.', 'error');  
  }  
};  

// const emitEdit = (id) => {  
//   router.push(`/groups/${id}/show`);  
// };  
const deleteGroupe = async (id) =>  {  
     
      try {  
        const result = await Swal.fire({
      title: "Êtes-vous sûr ?",
      text: "Vous ne pourrez pas annuler cela !",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Oui, supprimez-le !"
    });
    if (result.isConfirmed) {
//       // Utilisation de l'instance Axios configurée
          // const response = await axios.delete(`http://localhost:8000/api/groupes/${id}`);
          const response = await axios.delete(`http://localhost:8000/api/groups/${id}`, {  
          withCredentials: true, // Assurez-vous que les cookies d'authentification sont envoyés  
        }); 
          
          console.log('Groupe supprimé avec succès:', response.data); 
          await Swal.fire({
        title: "Supprimé !",
        text: "Votre fichier a été supprimé.",
        icon: "success"
      });
      
      await getGroupes(); // Rechargement de la liste
    }
  } catch (error) {
    // console.error('Erreur lors de la suppression du groupe:', error);
    
    Swal.fire({
      title: 'Erreur',
      text: 'Impossible de supprimer le groupe. Veuillez réessayer.',
      icon: 'error',
    });
  }
  
};
</script>