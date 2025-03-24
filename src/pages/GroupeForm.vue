<template>  
    <div class="my-4 max-w-screen-md border px-4 shadow-xl sm:mx-4 sm:rounded-xl sm:px-4 sm:py-4 md:mx-auto">  
        <div class="flex flex-col border-b py-4 sm:flex-row sm:items-start">  
            <div class="shrink-0 mr-auto sm:py-3">  
                <h1 class="font-medium">  
                    <span v-if="editMode">Modifier</span>  
                    <span v-else>Ajouter</span>  
                    un groupe  
                </h1>  
            </div>  
            <button @click="cancel" class="mr-2 hidden rounded-lg border-2 px-4 py-2 font-medium text-gray-500 sm:inline focus:outline-none focus:ring hover:bg-gray-200">Cancel</button>  
            <button @click="handleSave" class="hidden bg-gradient-to-l from-slate-800 to-violet-900 rounded-lg border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white sm:inline focus:outline-none focus:ring hover:bg-blue-700">Save</button>  
        </div>  

        
        <form @submit.prevent="handleSave">  
            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">Nom</p>  
                <input type="text" v-model="form.nom" placeholder="Nom" class="mb-2 w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" />  
                <small v-if="errors.nom" class="text-red-500">{{ errors.nom }}</small>  
            </div>  

            <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">Description</p>  
                <input type="text" v-model="form.description" placeholder="description" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
                <small v-if="errors.description" class="text-red-500">{{ errors.description }}</small>  
            </div> 
            <!-- <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
                <p class="shrink-0 w-32 font-medium">user</p>  
                <input type="text" v-model="form.user" placeholder="Groupe" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
                <small v-if="errors.user" class="text-red-500">{{ errors.user }}</small>  
            </div>   -->

            
            <div class="mt-6">  
                <button type="submit" class="rounded-lg border-2 bg-gradient-to-l from-slate-800 to-violet-900 border-transparent bg-blue-600 px-4 py-2 font-medium text-white focus:outline-none focus:ring hover:bg-blue-700">  
                    {{ editMode ? 'Mettre à jour' : 'Ajouter' }} le groupe  
                </button>  
            </div>  
        </form>  

        <!-- Message de Succès -->  
        <div v-if="successMessage" class="mt-4 p-2 bg-green-100 text-green-700 border border-green-300 rounded">  
            {{ successMessage }}  
        </div>  
    </div>  
</template>  

<script setup>  
import { reactive, ref } from 'vue';  
import axios from 'axios';  
import { useRouter, useRoute } from 'vue-router';  
//import { useStore } from 'vuex';

//const store = useStore();
const router = useRouter();  
const route = useRoute();  

const form = ref({  
    nom: '',  
    description: ''
});  

const errors = ref({});  
const successMessage = ref('');  
const editMode = ref(false);  

// const handleFileChange = (event) => {  
//     const file = event.target.files[0];  
//     if (file) {  
//         form.value.avatar = file;  
//     }  
// };  

const cancel = () => {  
    router.push('/groupes/index');  
};  


//const handleSave = async () => {  
    //errors.value = {};  
    //successMessage.value = '';  

    // Validation des champs  
    //if (!form.value.name) { errors.value.name = "Le nom est requis."; }  
    //if (!form.value.description) { errors.value.prenom = "La description est requis."; }  

    //if (Object.keys(errors.value).length > 0) return;  

    //const formData = new FormData();  
    //for (const key in form.value) {  
        //formData.append(key, form.value[key]);  
    //}  
    // const userId = store.state.currentUser ? store.state.currentUser.id : null;  
    // if (store && store.state && store.state.currentUser) {  
    //     const userId = store.state.currentUser.id;  
    //     formData.append('userId', userId);  
    // } else {  
    //     alert("User non connecté.");  
    //     return;  
    // }
    //try {  
        //const url = editMode.value ?   
           // `api/groupes/${route.params.id}` :   
            //'api/groupes';  
        //const method = editMode.value ? 'put' : 'post';  
        //const response = await axios[method](url,formData);  
        //successMessage.value = "groupe ajouté avec succès !";  

        //form.value = { nom: '', description: ''};  
        
         
        //router.push('/groupes/index');  
    //} catch (error) {  
        //if (error.response && error.response.status === 422) {   
            //errors.value = error.response.data.errors;  
        //} else {  
           // console.error(error);  
           // alert("Une erreur s'est produite, veuillez réessayer plus tard.");  
        //}  
    //};
//}; 

const handleSave = (values, actions) => {  
    console.log("yoooo");
    
    if(editMode.value){
        updadeGroupe(values, actions)
    }
    createGroupe(values, actions)
    
}

const createGroupe = (values, actions) => {  
    if (!form.value || !form.value.nom) {  
        errors.value.nom = "Le nom est requis.";  
    }  
    if (!form.value || !form.value.description) {  
        errors.value.description = "La description est requise.";  
    }  
     
    if (errors.value.nom || errors.value.description) {  
        return; // Prevent further execution if there are errors  
    }  
    
    axios.post('/groups', form.value)  
    .then((response) => {  
        router.push('/groupes/index');   
        toast.fire({ icon: "success", title: "Groupe added successfully" });   
    })  
    .catch((error) => {  
       console.log(errror);
       
    });  
}

const updateGroupe = (id, values, actions) => {  
    // Initialiser les erreurs  
    errors.value = {};  

    // Vérifiez les valeurs pour les erreurs  
    if (!form.value || !form.value.nom) {  
        errors.value.nom = "Le nom est requis.";  
    }  
    if (!form.value || !form.value.description) {  
        errors.value.description = "La description est requise.";  
    }  

    // Si des erreurs sont présentes, empêcher l'exécution  
    if (errors.value.nom || errors.value.description) {  
        return; // Prevent further execution if there are errors  
    }  

    // Effectuer la requête PUT ou PATCH pour mettre à jour le groupe  
    axios.put(`/groups/${id}`, form.value)  
    .then((response) => {  
        router.push('/groupes/index');   
        toast.fire({ icon: "success", title: "Groupe mis à jour avec succès" });   
    })  
    .catch((error) => {  
        console.error(error);  
        toast.fire({ icon: "error", title: "Erreur lors de la mise à jour du groupe." });  
    });  
};

// const updadeGroupe = (values, actions) => { 
//     axios.put(`/groups/${route.params.id}`, form)  
//     .then((response) => {  
//         router.push('/groupes/index') 
//         toast.fire({ icon: "Success", title: "groupe Updated Successfully"}) 
//     })  
//     .catch((error) => { 
//         if(error.response.status === 422) {
//             errors.value = error.response.data.errors; 
//         }
        
//     });  
// }
const fetchGroupe = async () => {  
    if (route.params.id) {  
        editMode.value = true;  
        try {  
            const response = await axios.get(`groups/${route.params.id}`);  
            form.value = response.data;  
        } catch (error) {  
            console.error(error);  
            alert("Une erreur est survenue lors de la récupération des informations.");  
        }  
    }  
};  

// Appeler la fonction pour le chargement initial  
fetchGroupe();  
</script>  