<template>
  <div class="my-4 max-w-screen-md border px-4 shadow-xl sm:mx-4 sm:rounded-xl sm:px-4 sm:py-4 md:mx-auto">  
    <div class="flex flex-col border-b py-4 sm:flex-row sm:items-start">  
      <div class="shrink-0 mr-auto sm:py-3">  
        <h1 class="font-medium">  
          <span>Modifier</span>  
          un contact  
        </h1>  
      </div>  
      <button @click="$emit('cancel')" class="mr-2 hidden rounded-lg border-2 px-4 py-2 font-medium text-gray-500 sm:inline focus:outline-none focus:ring hover:bg-gray-200">Cancel</button>  
      <button @click="submitForm" class="hidden bg-gradient-to-l from-slate-800 to-violet-900 rounded-lg border-2 border-transparent bg-blue-600 px-4 py-2 font-medium text-white sm:inline focus:outline-none focus:ring hover:bg-blue-700">Modifier</button>  
    </div>  

    <form @submit.prevent="submitForm">  
      <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
        <p class="shrink-0 w-32 font-medium">Nom</p>  
        <input type="text" v-model="contactForm.nom" placeholder="Nom" class="mb-2 w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 sm:mr-4 sm:mb-0 focus:ring-1" />  
      </div>  

      <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
        <p class="shrink-0 w-32 font-medium">Prénom</p>  
        <input type="text" v-model="contactForm.prenom" placeholder="Prénom" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
      </div>  

      <div class="flex flex-col gap-4 py-4 lg:flex-row">  
        <div class="shrink-0 w-32 sm:py-4">  
          <p class="mb-auto font-medium">Avatar</p>  
          <p class="text-sm text-gray-600">Change your avatar</p>  
        </div>  
        <div class="flex h-56 w-full flex-col items-center justify-center gap-4 rounded-xl border border-dashed border-gray-300 p-5 text-center">  
          <img :src="contactForm.avatar" class="h-16 w-16 rounded-full" v-if="contactForm.avatar" />  
          <p class="text-sm text-gray-600">Drop your desired image file here to start the upload</p>  
          <input type="file" @change="handleFileChange" class="max-w-full rounded-lg px-2 font-medium text-blue-600 outline-none ring-blue-600 focus:ring-1" />  
        </div>  
      </div>  

      <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
        <p class="shrink-0 w-32 font-medium">Email</p>  
        <input type="email" v-model="contactForm.email" placeholder="Email" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
      </div>  

      <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
        <p class="shrink-0 w-32 font-medium">Téléphone</p>  
        <input type="text" v-model="contactForm.numeroTelephone" placeholder="Téléphone" class="w-full rounded-md border bg-white px-2 py-2 outline-none ring-blue-600 focus:ring-1" />  
      </div>  

      <div class="flex flex-col gap-4 border-b py-4 sm:flex-row">  
        <p class="shrink-0 w-32 font-medium">groupe</p>  
        <select 
          id="group-select" 
          v-model="contactForm.selectedGroup" 
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
    </form>  

    <div v-if="successMessage" class="mt-4 p-2 bg-green-100 text-green-700 border border-green-300 rounded">  
      {{ successMessage }}  
    </div>  
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
  contactData: {
    type: Object,
    required: true
  },
  groupes: {
    type: Array,
    required: true
  }
});

const emit = defineEmits(['update', 'cancel']);

const contactForm = ref({
  nom: '',
  prenom: '',
  email: '',
  numeroTelephone: '',
  selectedGroup: '',
  avatar: null,
  avatarFile: null
});

const successMessage = ref('');


watch(() => props.contactData, (newContact) => {
  if (newContact) {
    contactForm.value = {
      nom: newContact.nom || '',
      prenom: newContact.prenom || '',
      email: newContact.email || '',
      numeroTelephone: newContact.numeroTelephone || '',
      selectedGroup: newContact.group?.id || '',
      avatar: newContact.image ? ourImage(newContact.image) : null,
      avatarFile: null
    };
  }
}, { immediate: true });

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    contactForm.value.avatarFile = file;
    contactForm.value.avatar = URL.createObjectURL(file);
  }
};

const submitForm = () => {
  const formData = new FormData();
  formData.append('nom', contactForm.value.nom);
  formData.append('prenom', contactForm.value.prenom);
  formData.append('email', contactForm.value.email);
  formData.append('numeroTelephone', contactForm.value.numeroTelephone);
  formData.append('selectedGroup', contactForm.value.selectedGroup);
  
  if (contactForm.value.avatarFile) {
    formData.append('avatar', contactForm.value.avatarFile);
  }
  

  emit('update', formData);
};


const ourImage = (img) => {
  
  return img.startsWith('http') ? img : `/storage/${img}`;
};
</script>