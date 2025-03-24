<template>
  <div class="mx-auto max-w-screen-lg px-4 py-8 sm:px-8">
    <div class="flex items-center justify-between pb-0">
      <div>
        <h2 class="font-semibold text-gray-700">All</h2>
        <div class="relative mb-5 w-full flex  items-center justify-between rounded-md">
          <svg class="absolute left-2 block h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8" class=""></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65" class=""></line>
          </svg>
          <input type="name" name="search" class="h-12 w-full cursor-text rounded-md border border-gray-100 bg-gray-100 py-4 pr-40 pl-12 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Search contact..." v-model="searchQuery" />
        </div>
      </div> 
      <div class="flex items-center justify-between">
        <div class="ml-10 space-x-8 lg:ml-40">
          <button @click="handleNewContact" class="flex items-center gap-2 rounded-md bg-gradient-to-l from-slate-800 to-violet-900 px-4 py-2 text-sm font-semibold text-white focus:outline-none focus:ring hover:bg-blue-700">
            Nouveau  
          </button>
        </div>
      </div>
    </div>

    <div v-if="isEditing" class="my-4 max-w-screen-md border px-4 shadow-xl sm:mx-4 sm:rounded-xl sm:px-4 sm:py-4 md:mx-auto">  
      <div class="flex flex-col border-b py-4 sm:flex-row sm:items-start">  
        <div class="shrink-0 mr-auto sm:py-3">  
          <h1 class="font-medium">  
            <span>Modifier</span>  
            un contact  
          </h1>  
        </div>  
        <button @click="cancel" class="mr-2 hidden rounded-lg border-2 px-4 py-2 font-medium text-gray-500 sm:inline focus:outline-none focus:ring hover:bg-gray-200">Cancel</button>  
        <button @click="updateContact" class="hidden bg-gradient-to-l from-slate-800 to-violet-900 rounded-lg border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white sm:inline focus:outline-none focus:ring hover:bg-blue-700">Modifier</button>  
      </div>  

      <!-- <form @submit.prevent="updateContact">  
        <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
          <p class="shrink-0 w-32 font-medium">Nom</p>  
          <input type="text" v-model="form.nom" placeholder="Nom" class="mb-2 w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" />  
        </div>  

        <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
          <p class="shrink-0 w-32 font-medium">Prénom</p>  
          <input type="text" v-model="form.prenom" placeholder="Prénom" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
        </div>  

        <div class="flex flex-col gap-4 py-4 lg:flex-row">  
          <div class="shrink-0 w-32 sm:py-4">  
            <p class="mb-auto font-medium">Avatar</p>  
            <p class="text-sm text-gray-600">Change your avatar</p>  
          </div>  
          <div class="flex h-56 w-full flex-col items-center justify-center gap-4 rounded-xl border border-dashed border-gray-300 p-5 text-center">  
            <img :src="form.avatar" class="h-16 w-16 rounded-full" v-if="form.avatar" />  
            <p class="text-sm text-gray-600">Drop your desired image file here to start the upload</p>  
            <input type="file" @change="handleFileChange" class="max-w-full rounded-lg px-2 font-medium text-blue-600 outline-none ring-blue-600 focus:ring-1" />  
          </div>  
        </div>  

        <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
          <p class="shrink-0 w-32 font-medium">Email</p>  
          <input type="email" v-model="form.email" placeholder="Email" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
        </div>  

        <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
          <p class="shrink-0 w-32 font-medium">Téléphone</p>  
          <input type="text" v-model="form.numeroTelephone" placeholder="Téléphone" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
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
        </div>  

        <div class="mt-6">  
          <button type="submit" class="rounded-lg bg-gradient-to-l from-slate-800 to-violet-900 border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white focus:outline-none focus:ring hover:bg-blue-700">  
            Modifier le contact  
          </button>  
        </div>  
      </form>   -->
      <ContactUpdateForm 
      v-if="isEditing" 
      :contactData="currentContact" 
      :groupes="groupes"
      @update="updateContact"
      @cancel="cancel"
    />

      <div v-if="successMessage" class="mt-4 p-2 bg-green-100 text-green-700 border border-green-300 rounded">  
        {{ successMessage }}  
      </div>  
    </div> 

    <div class="overflow-y-hidden rounded-lg border">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-gradient-to-l from-slate-800 to-violet-900 text-left text-xs font-semibold uppercase tracking-widest text-white">
              <th class="px-5 py-3">Image</th>
              <th class="px-5 py-3">Nom</th>
              <th class="px-5 py-3">prenom</th>
              <th class="px-5 py-3">Email</th>
              <th class="px-5 py-3">Phone</th>
              <th class="px-5 py-3">Favoris</th>
              <th class="px-5 py-3">Groupe</th>
              <th class="px-5 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-500" v-for="contact in contacts" :key="contact.id" >
            <tr>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <div class="h-10 w-10 flex-shrink-0">
                  <img class="h-full w-full rounded-full" :src="ourImage(contact.image)" />
                </div>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <div class="ml-3">
                  <p class="whitespace-no-wrap">{{contact.nom}}</p>
                </div>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <div class="ml-3">
                  <p class="whitespace-no-wrap">{{contact.prenom}}</p>
                </div>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <p class="whitespace-no-wrap">{{contact.email}}</p>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <p class="whitespace-no-wrap">{{contact.numeroTelephone}}</p>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <button v-if="contact?.is_favorite == 1" @click="toggleFavorite(true, contact.id)" class="bg-green-500 text-white p-1 ml-2 rounded">Favorite</button>
                <button v-else @click="toggleFavorite(false, contact.id)" class="bg-red-500 text-white p-1 ml-2 rounded">Pas Favorite</button>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <p class="whitespace-no-wrap">{{contact?.group?.nom}}</p>
              </td>
              <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <button @click="emitEdit(contact.id)" class="bg-green-500 text-white p-1 ml-2 rounded">Modifier</button>  
                <button @click="deleteContact(contact.id)" class="bg-red-500 text-white p-1 ml-2 rounded">Supprimer</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex flex-col items-center border-t bg-white px-5 py-5 sm:flex-row sm:justify-between">
        <div class="mr-40 ml-40 px-40"></div>
        <a class="btn text-xs text-gray-600 sm:text-sm border-1 "
          href="#"
          v-for="(link, index) in links"
          :key="index"
          
          v-html="link.label"
          :class="{active:link.active, disable: !link.url}"
          @click.prevent="changePage(link)"
        >  </a>
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, watch, ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import ContactFormModifier from './ContactFormModifier.vue';
import {
  contacts,
  links,
  groupes,
  searchQuery,
  isEditing,
  currentContactId,
  form,
  newContact,
  ourImage,
  fetchGroupes,
  fetchContacts,
  toggleFavorite,
  changePage,
  emitEdit,
  
  updateContact,
  deleteContact
} from '../services/ContactListe.js'; 

// Référence au contact actuellement en cours d'édition
const currentContact = computed(() => {
  return contacts.value.find(contact => contact.id === currentContactId.value) || null;
});

// Fonction pour annuler l'édition
const cancel = () => {
  isEditing.value = false;
  currentContactId.value = null;
};

onMounted(async () => {
  await fetchContacts();
  await fetchGroupes();
});

watch(searchQuery, async () => {
  await fetchContacts();
});

const router = useRouter();

const handleNewContact = () => {
  router.push('/contacts/store');
}
</script>
<!-- <script setup>
import { onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import {
  contacts,
  links,
  groupes,
  searchQuery,
  isEditing,
  currentContactId,
  form,
  newContact,
  ourImage,
  fetchGroupes,
  fetchContacts,
  toggleFavorite,
  changePage,
  emitEdit,
  updateContact,
  deleteContact
} from '../services/ContactListe.js'; 

onMounted(async () => {
  await fetchContacts();
  await fetchGroupes();
});

watch(searchQuery, async () => {
  await fetchContacts();
});


const router = useRouter();

const handleNewContact = () => {
  router.push('/contacts/store');
}
</script> -->