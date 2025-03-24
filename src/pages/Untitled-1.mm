
// <template>  
//   <div>  
//     <h1>Liste des Groupes</h1>  
//     <ul>  
//       <li v-for="groupe in groupes" :key="groupe.id">  
//         <strong>{{ groupe.nom }}</strong>  
//         <button @click="fetchContacts(groupe.id)">Voir Contacts</button>  
//         <ul v-if="groupeContacts[groupe.id]">  
//           <li v-for="contact in groupeContacts[groupe.id]" :key="contact.id">  
//             {{ contact.nom }}  
//             <button @click="toggleFavorite(contact)">   
//               {{ contact.favori ? 'Retirer Favori' : 'Mettre en Favori' }}   
//             </button>  
//           </li>  
//         </ul>  
//         <form @submit.prevent="addContact(groupe.id)">  
//           <input v-model="newContactName" placeholder="Ajouter un contact">  
//           <button type="submit">Ajouter</button>  
//         </form>  
//         <h4>Mes Favoris</h4>  
//         <ul>  
//           <li v-for="fav in getFavorites()" :key="fav.id">  
//             {{ fav.nom }}  
//           </li>  
//         </ul>  
//       </li>  
//     </ul>  
//   </div>  
// </template>  

// <script setup>  
// import { ref, onMounted } from 'vue';  
// import axios from 'axios';  

// const groupes = ref([]);  
// const groupeContacts = ref({});  
// const newContactName = ref('');  
// const favorites = ref([]);  // Liste des contacts favoris  

// onMounted(async () => {  
//   await fetchGroupes();  
// });  

// const fetchGroupes = async () => {  
//   try {  
//     const response = await axios.get('/api/groupes'); // Endpoint pour récupérer les groupes  
//     groupes.value = response.data.groupes;  
//   } catch (error) {  
//     console.error('Error fetching groupes:', error);  
//   }  
// };  

// // Fonction pour récupérer les contacts d'un groupe  
// const fetchContacts = async (groupeId) => {  
//   try {  
//     const response = await axios.get(`/api/groupes/${groupeId}/contacts`);  
//     groupeContacts.value[groupeId] = response.data.contacts;  
//   } catch (error) {  
//     console.error('Error fetching contacts for groupe:', error);  
//   }  
// };  

// // Fonction pour ajouter un contact à un groupe  
// const addContact = async (groupeId) => {  
//   if (!newContactName.value) return;  

//   try {  
//     const newContact = { nom: newContactName.value, favori: false };  
//     const response = await axios.post(`/api/groupes/${groupeId}/contacts`, newContact);  
//     await fetchContacts(groupeId);  // Rafraîchir la liste des contacts  
//     newContactName.value = '';  // Réinitialiser le champ  
//   } catch (error) {  
//     console.error('Error adding contact:', error);  
//   }  
// };  

// // Fonction pour mettre ou retirer un contact en favoris  
// const toggleFavorite = (contact) => {  
//   if (contact.favori) {  
//     // Si le contact est déjà favori, le retirer  
//     favorites.value = favorites.value.filter(fav => fav.id !== contact.id);  
//     contact.favori = false;  
//   } else {  
//     // Sinon, l'ajouter à la liste des favoris  
//     favorites.value.push(contact);  
//     contact.favori = true;  
//   }  
// };  

// // Fonction pour obtenir la liste des favoris  
// const getFavorites = () => {  
//   return favorites.value;  
// };  
// </script>  

// <style scoped>  
// /* Ajoutez vos styles ici */  
// </style>