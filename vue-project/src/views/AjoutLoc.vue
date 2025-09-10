<template>
<div class="blurOpacity"></div>
<div class="ajoutForm">
  <div>
    <form @submit.prevent="submitForm">
      <div class="modalTitle">
        <h2>Nouvelle Location</h2>
        <button type="button" class="btn-close" @click="fermerAjout"></button>
      </div>
      <div class="mt-2">
        <div class="form-floating mb-3">
          <input v-model="numloc" placeholder="Numero du Location"  class="form-control"/>
          <label class="text text-dark">Numero du Location</label>
        </div>
        <div class="form-floating mb-3">
          <input v-model="nom_loc" placeholder="nomEleve"  class="form-control"/>
          <label class="text text-dark">Nom du location</label>
        </div>
        <div class="form-floating mb-3">
          <input v-model="design_voiture" placeholder="matricule"  class="form-control"/>
          <label class="text text-dark">design Voiture</label>
        </div>
        <div class="form-floating mb-3">
          <input v-model="nbr_jour" placeholder="nomEleve" type="number" class="form-control"/>
          <label class="text text-dark">Nombre de Jour</label>
        </div>
        <div class="form-floating mb-3">
          <input v-model="taux_jour" placeholder="nomEleve" type="number" class="form-control"/>
          <label class="text text-dark">Taux Journalier</label>
        </div>
      </div>
      <div class="hstack gap-2 justify-content-end">
        <span class="btn btn-light" @click="fermerAjout">Annuler</span>
        <button type="submit" class="btn btn-success" :disabled="formInvalide">Ajouter</button>
      </div>
    </form>
  </div>
</div>
<FadeSlideTransition>
  <div v-if="toast.visible" class="meimToast">
    {{ toast.message }}
  </div>
</FadeSlideTransition>
</template>

<script setup>
import { ref, defineEmits, computed } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import FadeSlideTransition from './FadeSlideTransition.vue'

const numloc = ref('')
const nom_loc = ref('')
const design_voiture = ref('')
const taux_jour = ref('')
const nbr_jour = ref('')

const router = useRouter()

const emit = defineEmits(['toast', 'ajout-success'])

const formInvalide = computed(() => {
  return (
    !numloc.value ||
    !nom_loc.value ||
    !design_voiture.value ||
    !nbr_jour.value ||
    !taux_jour.value
  );
});

const fermerAjout = () =>{
  console.log('mety')
  router.push({ name: 'Home'})
}

const submitForm = async () => {
  try {
    const res = await axios.post('http://localhost/projet_VueJs/cliprojvue/backend/API/utilisateurs/ajouter.php', {
      numloc: numloc.value,
      nom_loc: nom_loc.value,
      design_voiture: design_voiture.value,
      nbr_jour: nbr_jour.value,
      taux_jour: taux_jour.value

    },{
      headers: { 'Content-Type': 'application/json' }
    })
    const data = await res.data

    console.log(res.ok)

    if (res.status === 200) {
      emit('toast', data.message, 'success')
      emit('ajout-success')
      emit('fermerAjout')
      router.push({ name: 'Home', query:{message: data.message, lastInserted: numloc.value}})
      numloc.value =''
      nom_loc.value=''
      design_voiture.value=''
      taux_jour.value=''
      nbr_jour.value=''
    } else {
      emit('toast', data.message || 'Erreur', 'error')
      showToast(data.message)
      console.log('Erreur')
    }
  } catch (e) {
    console.log(e)
    emit('toast', 'Erreur de connexion', 'error')
    showToast('Erreur de connexion '+e)
  }
}

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
  z-index: 9999;
}
.ajoutForm{
  top: 12%;
  left: 23%;
  right: 23%;
  width: auto;
  position: fixed;
  z-index: 99999;
  background: linear-gradient(-135deg, #0d033d, #250e75, #5a1ca2, #9424b8);
  padding: 3rem;
  border-radius: 15px;
  max-height: 90vh;
  overflow-y: auto;
}

@media screen and (max-width: 948px) {
  .ajoutForm{
    left: 10%;
    right: 10%
  }
}

.meimToast{
  position: fixed;
  bottom: 20px;
  left: 30%;
  right: 30%;
  background-color: #333;
  color: white;
  padding: 12px 20px;
  border-radius: 8px;
  z-index: 100000;
  text-align: center;
  z-index: 10000000000;
}

</style>











