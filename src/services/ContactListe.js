import axios from "axios";
import Swal from "sweetalert2";
import { ref, onMounted, watch } from "vue";
// import { useRouter } from 'vue-router';
import { contactService } from "./contactService.js"
import { groupService } from "./groupService.js";

import { useRouter } from 'vue-router';
const router = useRouter();

let contacts = ref([]);
let links = ref([]);
const groupes = ref([]);

let searchQuery = ref('');
let isEditing = ref(true);
let currentContactId = ref(null);
let form = ref({
    nom: '',
    prenom: '',
    email: '',
    numeroTelephone: '',
    user: '',
    avatar: null,
    selectedGroup: null
});

onMounted(async () => {
  await fetchContacts();
  await fetchGroupes();
});

watch(searchQuery, async () => {
  await fetchContacts();
});
const newContact = () => {
  return '/contacts/store'; 
}
// const newContact = () => {
//   router.push('/contacts/store');
// }

const ourImage = (img) => {
  return img.replace(/\\/g, '');
}

const fetchGroupes = async () => {
  try {
    const response = await groupService.getGroupes();
    groupes.value = response.data.data;
  } catch (error) {
    console.error('Error fetching groupes:', error);
  }
};

const fetchContacts = async () => {
  try {
    const response = await contactService.getContacts(searchQuery.value);
    contacts.value = response.data.data;
    links.value = response.data.links;
  } catch (error) {
    console.error('Erreur lors de la récupération des contacts:', error);
    Swal.fire({
      title: 'Erreur',
      text: 'Impossible de récupérer les contacts. Veuillez réessayer.',
      icon: 'error',
    });
  }
};

const toggleFavorite = async (state = true, id) => { 
  try {
    const response = await contactService.toggleFavorite(id, state);
    Swal.fire({
      icon: "success",
      title: "Success",
      text: "Action successful"
    });
    fetchContacts();
  } catch (error) {
    console.error('Erreur lors de la récupération des contacts:', error);
    Swal.fire({
      title: 'Erreur',
      text: 'Impossible de récupérer les contacts. Veuillez réessayer.',
      icon: 'error',
    });
  }
}

const changePage = async (url) => {
  if (!link.url || link.active) {
    return;
  }

  try {
    const response = await contactService.changePage(url);
    contacts.value = response.data.data;
    links.value = response.data.links;
  } catch (error) {
    console.error('Erreur lors du changement de page:', error);
  }
};

const emitEdit = async (id) => {
  try {
    const response = await contactService.getContact(id);
    form.value.nom = response.data.nom;
    form.value.prenom = response.data.prenom;
    form.value.email = response.data.email;
    form.value.numeroTelephone = response.data.numeroTelephone;
    form.value.avatar = response.data.avatar;
    form.value.selectedGroup = response.data.groupe_id;
    currentContactId.value = id;
    isEditing.value = true;
  } catch (error) {
    console.error('Erreur lors de la récupération du contact :', error);
  }
};

const updateContact = async () => {
  try {
    const formData = new FormData();
    formData.append('nom', form.value.nom);
    formData.append('prenom', form.value.prenom);
    formData.append('email', form.value.email);
    formData.append('numeroTelephone', form.value.numeroTelephone);
    formData.append('selectedGroup', form.value.selectedGroup);
    
    if (form.value.avatar) {
      formData.append('avatar', form.value.avatar);
    }

    await contactService.updateContact(currentContactId.value, formData);
    Swal.fire({
      icon: "success",
      title: "Succès",
      text: "Contact mis à jour"
    });
    isEditing.value = false;
    await fetchContacts();
  } catch (error) {
    console.error('Erreur lors de la mise à jour du contact :', error);
    Swal.fire({
      title: 'Erreur',
      text: 'Impossible de mettre à jour le contact. Veuillez réessayer.',
      icon: 'error',
    });
  }
};

//  const updateContact = async (formData) => {
//   try {
//     const response = await axios.post(`/api/contacts/${currentContactId.value}?_method=PUT`, formData, {
//       headers: {
//         'Content-Type': 'multipart/form-data',
//       },
//     });
    
//     if (response.data.success) {
      
//       await fetchContacts(); 
//       isEditing.value = false; 
//       return { success: true, message: response.data.success };
//     }
//   } catch (error) {
//     console.error('Error updating contact:', error.response?.data?.error || error.message);
//     return { success: false, message: error.response?.data?.error || 'Une erreur est survenue' };
//   }
// };

const deleteContact = async (id) => {
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
      await performDeleteContact(id);
      await Swal.fire({
        title: "Supprimé !",
        text: "Votre fichier a été supprimé.",
        icon: "success"
      });
      await fetchContacts();
    }
  } catch (error) {
    handleDeleteError(error);
  }
};

const performDeleteContact = async (id) => {
  const response = await contactService.deleteContact(id);
  console.log('Contact supprimé avec succès:', response.data);
};

const handleDeleteError = (error) => {
  console.error('Erreur lors de la suppression du contact:', error);
  Swal.fire({
    title: 'Erreur',
    text: 'Impossible de supprimer le contact. Veuillez réessayer.',
    icon: 'error',
  });
};

export {
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
};