<template>  
    <div class="my-4 max-w-screen-md border px-4 shadow-xl sm:mx-4 sm:rounded-xl sm:px-4 sm:py-4 md:mx-auto">  
        <div class="flex flex-col border-b py-4 sm:flex-row sm:items-start">  
            <div class="shrink-0 mr-auto sm:py-3">  
                <h1 class="font-medium">  
                    <!-- <span v-if="editMode">Modifier</span>   -->
                    <span>Ajouter</span>  
                    un contact  
                </h1>  
            </div>  
            <button @click="cancel" class="mr-2 hidden rounded-lg border-2 px-4 py-2 font-medium text-gray-500 sm:inline focus:outline-none focus:ring hover:bg-gray-200">Cancel</button>  
            <button @click="handleSave" class="hidden bg-gradient-to-l from-slate-800 to-violet-900 rounded-lg border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white sm:inline focus:outline-none focus:ring hover:bg-blue-700">Save</button>  
        </div>  

        
        <form @submit.prevent="handleSave">  
            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">Nom</p>  
                <input type="text" v-model="form.nom" placeholder="Nom" class="mb-2 w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" />  
                <small v-if="errors.name" class="text-red-500">{{ errors.nom }}</small>  
            </div>  

            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">Prénom</p>  
                <input type="text" v-model="form.prenom" placeholder="Prénom" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
                <small v-if="errors.prenom" class="text-red-500">{{ errors.prenom }}</small>  
            </div>  

            <div class="flex flex-col gap-4 py-4 lg:flex-row">  
                <div class="shrink-0 w-32 sm:py-4">  
                    <p class="mb-auto font-medium">Avatar</p>  
                    <p class="text-sm text-gray-600">Change your avatar</p>  
                </div>  
                <div class="flex h-56 w-full flex-col items-center justify-center gap-4 rounded-xl border border-dashed border-gray-300 p-5 text-center">  
                    <img  class="h-16 w-16 rounded-full" />  
                    <p class="text-sm text-gray-600">Drop your desired image file here to start the upload</p>  
                    <input type="file" @change="handleFileChange" class="max-w-full rounded-lg px-2 font-medium text-blue-600 outline-none ring-blue-600 focus:ring-1" />  
                </div>  
            </div>  

            
            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">Email</p>  
                <input type="email" v-model="form.email" placeholder="Email" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
                <small v-if="errors.email" class="text-red-500">{{ errors.email }}</small>  
            </div>  

            
            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">Téléphone</p>  
                <input type="text" v-model="form.numeroTelephone" placeholder="Téléphone" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
                <small v-if="errors.numeroTelephone" class="text-red-500">{{ errors.numeroTelephone }}</small>  
            </div>  

       
            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">groupe</p>  
                <select 
                    id="group-select" 
                    v-model="form.selectedGroup" 

                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
        <option value="" disabled>Choisir un groupe</option>
        <option 
          v-for="group in groupes" 
          :key="group.id" 
          :value="group.id"
        >
          {{ group.nom }}
        </option>
      </select>
                <!-- <small v-if="errors.user" class="text-red-500">{{ errors.user }}</small>   -->
            </div>  

            
            <div class="mt-6">  
                <button type="submit"  class="rounded-lg bg-gradient-to-l from-slate-800 to-violet-900 border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white focus:outline-none focus:ring hover:bg-blue-700">  
                    {{ editMode ? 'Mettre à jour' : 'Ajouter' }} le contact  
                </button>  
            </div>  
        </form>  

       
        <div v-if="successMessage" class="mt-4 p-2 bg-green-100 text-green-700 border border-green-300 rounded">  
            {{ successMessage }}  
        </div>  
    </div>  
</template>  

<script setup>  
import { ref, onMounted } from 'vue';  
import axios from 'axios';  
import { useRouter, useRoute } from 'vue-router';  
import { useStore } from 'vuex';

const store = useStore();
const router = useRouter();  
const route = useRoute(); 
const groupes = ref([]);  
const errors = ref({});  
const successMessage = ref('');  
const editMode = ref(false);

const form = ref({  
    nom: '',  
    prenom: '',  
    email: '',  
    numeroTelephone: '',  
    user: '',  
    avatar: null, 
    selectedGroup: null 
});  
onMounted(async () => {  
    if(route.name === 'contacts.show'){
    editMode.value = true
    getContacts()
   }  
  await getGroupes();  
});  
const getGroupes = async () => {  
  try {  

    const response = await axios.get(
      '/liste',
    );  
    groupes.value = response.data.data;   
    
  } catch (error) {  
    // console.error('Error fetching groupes:', error);  
    Swal.fire('Error', 'Could not fetch groupes. Please try again later.', 'error');  
  }  
};  
const handleFileChange = (event) => {  
    const file = event.target.files[0];  
    if (file) {  
        form.value.avatar = file;  
    }  
};  

const cancel = () => {  
    router.push('/contacts/index');  
};  

const handleSave = (values, actions) => {  
    if(editMode.value){
        updateContact(values, actions)
    }
    createContacts(values, actions)
    
}

const createContacts = async (values,actions) => {  
    errors.value = {};  
    successMessage.value = '';    
    if (!form.value.nom) { errors.value.nom = "Le nom est requis."; }  
    if (!form.value.prenom) { errors.value.prenom = "Le prénom est requis."; }  
    if (!form.value.email) { errors.value.email = "L'email est requis."; }  
    else if (!/\S+@\S+\.\S+/.test(form.value.email)) { errors.value.email = "L'email est invalide."; }  
    if (!form.value.numeroTelephone) { errors.value.numeroTelephone = "Le téléphone est requis."; }  

    if (Object.keys(errors.value).length > 0) return;  

    const formData = new FormData();  
    for (const key in form.value) {  
        formData.append(key, form.value[key]);  
    } 
    axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'
    try {  
        const url = '/contacts';   
        const response = await axios.post(url,formData);  
        successMessage.value = "Client ajouté avec succès !";  
        form.value = { name: '', prenom: '', email: '', numeroTelephone: '', avatar: null };  
        router.push('/contacts/index');  
    } catch (error) {  
        if (error.response && error.response.status === 422) {   
            errors.value = error.response.data.errors;  
        } else {  
            console.error(error);  
            alert("Une erreur s'est produite, veuillez réessayer plus tard.");  
        }  
    };
}; 

 const updateContact = async (values,actions) => {  
     errors.value = {};  
     successMessage.value = '';  
     if (!form.value.nom) { errors.value.nom = "Le nom est requis."; }  
     if (!form.value.prenom) { errors.value.prenom = "Le prénom est requis."; }  
     if (!form.value.email) { errors.value.email = "L'email est requis."; }  
     else if (!/\S+@\S+\.\S+/.test(form.value.email)) { errors.value.email = "L'email est invalide."; }  
     if (!form.value.numeroTelephone) { errors.value.numeroTelephone = "Le téléphone est requis."; }  
     if (Object.keys(errors.value).length > 0) return;  
     const formData = new FormData();  
     for (const key in form.value) {  
         formData.append(key, form.value[key]);  
     }  
     axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';  
     try {  
         const url = `/contacts/${route.params.id}`;  
         const response = await axios.put(url, formData);
         successMessage.value = "contact mis à jour avec succès !"; 
         form.value = { nom: '', prenom: '', email: '', numeroTelephone: '', avatar: null };  
         router.push('/contacts/index');  
     } catch (error) {  
         if (error.response && error.response.status === 422) {  
             errors.value = error.response.data.errors;  
         } else {  
             console.error(error);  
             alert("Une erreur s'est produite, veuillez réessayer plus tard.");  
         }  
     }  
 };

  
const fetchContact = async () => {  
    if (route.params.id) {  
        editMode.value = true;  
        try {  
            const response = await axios.get(`api/contacts/${route.params.id}`);  
            form.value = response.data;  
        } catch (error) {  
            console.error(error);  
            alert("Une erreur est survenue lors de la récupération des informations.");  
        }  
    }  
};  

// Appeler la fonction pour le chargement initial  
fetchContact();  
</script>  