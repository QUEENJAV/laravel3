


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
        <button @click="newFavoris" class="flex items-center gap-2 rounded-md bg-gradient-to-l from-slate-800 to-violet-900 px-4 py-2 text-sm font-semibold text-white focus:outline-none focus:ring hover:bg-blue-700">
            Ajouter  
        </button>
      </div>
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
            <!-- <th class="px-5 py-3">Groupe</th> -->
            <th class="px-5 py-3">Status</th>
          </tr>
        </thead>
        <tbody class="text-gray-500" v-for="favoris in favoris" :key="favoris.id" >
          <tr>
            <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <div class="h-10 w-10 flex-shrink-0">
                  <img class="h-full w-full rounded-full" :src="ourImage(favoris.image)" />
                </div>
            </td>
            <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <div class="ml-3">
                  <p class="whitespace-no-wrap">{{favoris.nom}}</p>
                </div>
            </td>
            <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <div class="ml-3">
                  <p class="whitespace-no-wrap">{{favoris.prenom}}</p>
                </div>
            </td>
            <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
              <p class="whitespace-no-wrap">{{favoris.email}}</p>
            </td>
            <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
              <p class="whitespace-no-wrap">{{favoris.numerotelephone}}</p>
            </td>
            <!-- <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
              <p class="whitespace-no-wrap">{{product.price}}</p>
            </td> -->

            <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                <!-- <button @click="emitEdit(contact.id)" class="bg-green-500 text-white p-1 ml-2 rounded">Modifier</button>   -->
                <button @click="deleteContactFavoris(favoris.id)" class="bg-red-500 text-white p-1 ml-2 rounded">Supprimer</button>
                <button  class="bg-yellow-500 text-white p-1 ml-2 rounded">Favoris</button>
                <!-- <button  class="bg-yellow-500 text-white p-1 ml-2 rounded">Ajouter a un groupe</button> -->
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
        @click="changePage(link)"
      >  </a>
      
    </div>
  </div>
</div>

</template>

<script>  
export default {  
//   props: ['price'],  
  data() {  
    return {  
      searchTerm: '',  
      dropdownOpen: false,  
    };  
  },  
  methods: {  
    toggleDropdown() {  
      this.dropdownOpen = !this.dropdownOpen;  
    },  
  },  
};  
</script>  
<script setup>
import axios from "axios";
import { Warning } from "postcss";
// import Swal from "sweetalert2";
import{ ref, onMounted, watch } from "vue"

import { useRouter } from 'vue-router';


const router = useRouter()

let contacts = ref([])

let favoris = ref([])

let links = ref([])

let searchQuery = ref('')

onMounted(async () => {
  getFavoris()
})

watch(searchQuery, () => {
    getFavoris()
})
 
const newFavoris = () => {
  router.push('/contacts/store')
}



 const getFavoris = async () => {
  let response = await axios.get('/api/favoris?&searchQuery='+searchQuery.value)
    .then((response) => {
        favoris.value = response.data.favoris.data
      links.value = response.data.favoris.links  
    })
 }

 const changePage = (link) =>{
  if(!link.url || link.active){
    return
  }
  axios.get(link.url)
    .then((response) => {
        favoris.value = response.data.favoris.data
      links.value = response.data.favoris.links  
    })
 }

//  const emitEdit = (id) => {
//   router.push(`/contacts/${id}/show`)
//  }

const deleteContactFavoris = (id) => {
  Swal.fire({
    title: "Are you sure?",
    text: "you won't be able to revert thi!",
    icon: "Warning",
    showCancelButton: true,
    confirmButtonColor:"#3085d6",
    cancelButtonColor:"#d33",
    confirmButtonText: "yes, delete it!"
  }).then((result) => {
    if(result.isConfirmed) {
      axios.delete(`/api/favoris/${id}`)
        .then(()=>{
          Swal.fire({
            title:"delete!",
            text: "your file has ben delete.",
            icon: "success"
          });
          getFavoris()
        })
    }
  });
}

</script>