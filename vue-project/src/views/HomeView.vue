<template>
  <FadeSlideTransition>
    <SupprimerLoc v-if="showDelete" :numlocA="selectedId" @fermerDelete="showDelete = false" @toast="showToast" @delete-success="chargerUtilisateurs"/>
  </FadeSlideTransition>
  <FadeSlideTransition>
    <ModifierLoc v-if="showUpdate" :numlocB="updateData" @fermerUpdate="showUpdate = false" @toast="showToast" @update-success="chargerUtilisateurs"/>
  </FadeSlideTransition>
  
  <FadeSlideTransition>
    <div v-if="toast.visible" class="meimToast">
      {{ toast.message }}
    </div>
  </FadeSlideTransition>
  <div class="titleTab">
    <h1 color="white">Liste des locations</h1>
    <div class="d-flex gap-2 align-items-center mb-2">
      <input
        type="text"
        v-model="recherche"
        placeholder="🔍 Rechercher des infos..."
        class="elegant-input"
        @input="chargerUtilisateurs"
      />
      
      <select v-model="triPar" class="form-select form-select-sm" style="max-width: 180px; border-radius: 2rem;" @change="chargerUtilisateurs">
        <option disabled value="">🔽 Trier par</option>
        <option value="numloc">Numéro location</option>
        <option value="nom_loc">Nom location</option>
        <option value="design_voiture">Design voiture</option>
        <option value="nbr_jour">Nombre du jour</option>
        <option value="taux_jour">Taux journalier</option>
      </select>
    </div>
  </div>
  <div class="table-responsive arround mb-0">
    <table class="table table-info table-bordered align-middle table-nowrap mb-0 table-sm">
      <thead class="table-info text-muted sticky-top">
        <tr class="text text-center">
          <th>Numero Location</th>
          <th>Nom Location</th>
          <th>Design voiture</th>
          <th>Nombre du jour(j)</th>
          <th>Taux Journalier(€/j)</th>
          <th>Loyer(€)</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="utilisateurs.length === 0" key="no-data" class="text text-center">
          <td colspan="7">Aucun données existantes en ce moment</td>
        </tr>
        <tr v-for="u in utilisateurs" :key="u.numloc" class="text text-center" :class="{'highlight-row': u.matricule === lastInserted}">
          <td>{{ u.numloc }}</td>
          <td>{{ u.nom_loc }}</td>
          <td>{{ u.design_voiture }}</td>
          <td>{{ u.nbr_jour }}</td>
          <td>{{ u.taux_jour }}</td>
          <td>{{ u.taux_jour* u.nbr_jour }}</td>
          <td>
            <button
              class="btn btn-primary btn-sm"
              style="margin-right: 2%"
              @click="getData(u); showUpdate = true"
            >
              Modifier
            </button>
            <button
              class="btn btn-danger btn-sm"
              style="margin-right: 2%"
              @click="getNumLoc(u.numloc);   showDelete = true "
            >
              Supprimer
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div> 
</template>

<script setup>

import {ref, onMounted} from 'vue'
import SupprimerLoc from './SupprimerLoc.vue'
import ModifierLoc from './ModifierLoc.vue'
import FadeSlideTransition from "./FadeSlideTransition.vue"
import { useRoute } from 'vue-router'
import router from '@/router'
import axios from 'axios'

const route = useRoute()
const message = ref('')
const lastInserted = ref('')

const utilisateurs = ref([])
const recherche = ref('')
const showDelete = ref(false)
const showUpdate = ref(false)
const selectedId = ref('')
const updateData = ref({})
const triPar = ref('')

function getNumLoc(numloc){
  selectedId.value = numloc
}

function getData(data){
  updateData.value = data
}

const chargerUtilisateurs = async () => {
  console.log(`REcherche val ici:${recherche.value}`)
  await axios.get(`http://localhost/projet_VueJs/cliprojvue/backend/API/utilisateurs/lister.php?q=${recherche.value}&tri=${triPar.value}`)
  .then(res => {
    console.log(res.data)
    utilisateurs.value = res.data.filter(u => u.numloc !== null && u.numloc !== '')
  })
  if(route.query.message){
    message.value = route.query.message
    showToast(message.value)
    router.replace({ query: {}})
    window.history.replaceState(null, '', route.path)
    
  }

  if(route.query.lastInserted){
    lastInserted.value = route.query.lastInserted
    window.history.replaceState(null, '', route.path)
    setTimeout(()=>{
      lastInserted.value = null
    }, 5000)
  } 
}
onMounted(() =>{
  chargerUtilisateurs()
  // console.log(utilisateurs.value)
})

import { reactive } from 'vue';
const toastTimer = null
const toast = reactive({
  visible: false,
  message: ''
})

function showToast(message) {
  toast.visible = false;
  toast.message = '';
  if(toastTimer){
    clearTimeout(toastTimer)
  }
  setTimeout(() => {
    toast.message = message;
    toast.visible = true;
    setTimeout(() => {
      toast.visible = false;
      toast.message = '';
      toastTimer = null;
    }, 3000)
  }, 50)
}

</script>

<style>

.meimToast{
  position: fixed;
  bottom: 20px;
  left: 30%;
  right: 30%;
  background-color: #333;
  color: white;
  padding: 12px 20px;
  border-radius: 8px;
  z-index: 100000000000000000000000;
  text-align: center;
}

.highlight-row{
  background-color: #d4edda;
  transition: background-color 0.5s ease;
}

.titleTab{
  display: flex;
  justify-content: space-between;
}

.elegant-input {
  border-radius: 2rem;
  border: 1px solid #ced4da;
  padding: 0.2rem 1.25rem;
  transition: all 0.3s ease;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.elegant-input:focus {
  border-color: #6610f2;
  box-shadow: 0 0 0 0.25rem rgba(102, 16, 242, 0.25);
}
@media screen and (max-width: 768px) {
  
  .titleTab{
    display: block;
    align-items: center;
  }
}

.modalTitle{
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modalTitle h2{
  color:white;
}

.blurOpacity{
  position: fixed;
  background: rgba(0, 0, 0, 0.5);
  width: 100vw;
  height: 150vh;
  left: 50%;
  right: 50%;
  margin-left: -50vw;
  margin-right: -50vw;
  margin-top: -50vh;
  z-index: 999999999;
}
.suppressionForm{
  top: 25%;
  left: 23%;
  right: 23%;
  width: auto;
  position: fixed;
  z-index: 999999999;
  background: linear-gradient(-135deg, #0d033d, #250e75, #5a1ca2, #9424b8);
  padding: 3rem;
  border-radius: 15px;
}

</style>