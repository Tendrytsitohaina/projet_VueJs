<template>
  <div class="blurOpacity"></div>
  <div class="modifierForm">
    <div>
        <form @submit.prevent="submitForm">
          <div class="modalTitle">
            <h2>Modifier une Location</h2>
            <button type="button" class="btn-close" @click="fermerUpdate"></button>
          </div>
          <div class="mt-2">
            <div class="form-floating mb-3">
              <input v-model="numloc" placeholder="Numero du Location" required class="form-control"/>
              <label class="text text-dark">Numero du Location</label>
            </div>
              <div class="form-floating mb-3">
              <input v-model="nom_loc" placeholder="nomEleve" required class="form-control"/>
            <label class="text text-dark">Nom du location</label>
            </div>
            <div class="form-floating mb-3">
              <input v-model="design_voiture" placeholder="matricule" required class="form-control"/>
              <label class="text text-dark">design Voiture</label>
            </div>
            <div class="form-floating mb-3">
              <input v-model="nbr_jour" placeholder="nomEleve" required class="form-control"/>
              <label class="text text-dark">Nombre de Jour</label>
            </div>
            <div class="form-floating mb-3">
              <input v-model="taux_jour" placeholder="nomEleve" required class="form-control"/>
              <label class="text text-dark">Taux Journalier</label>
            </div>
          </div>
          <div class="hstack gap-2 justify-content-end">
            <span class="btn btn-light" @click="fermerUpdate">Annuler</span>
            <button type="submit" class="btn btn-success" :disabled="formInvalide">Modifier</button>
          </div>
        </form>
    </div>
  </div>
</template>
    
<script setup>
import { ref, defineEmits, defineProps, watch, computed } from 'vue'
import axios from 'axios'

const fermerUpdate = () => {
    emit('fermerUpdate')
}

const numloc = ref('')
const nom_loc = ref('')
const design_voiture = ref('')
const taux_jour = ref(0)
const nbr_jour = ref(0)  

const formInvalide = computed(() => {
  return (
    !numloc.value ||
    !nom_loc.value ||
    !design_voiture.value ||
    !nbr_jour.value ||
    !taux_jour.value
  );
});

const props = defineProps({
    numlocB: Object
})
const emit = defineEmits(['toast', 'update-success', 'fermerUpdate'])

const submitForm = async () => {
  try {
    const res = await axios.post('http://localhost/projet_VueJs/cliprojvue/backend/API/utilisateurs/modifier.php', {
      numloc: numloc.value,
      nom_loc: nom_loc.value,
      design_voiture: design_voiture.value,
      nbr_jour: nbr_jour.value,
      taux_jour: taux_jour.value

    },{
      headers: { 'Content-Type': 'application/json' }
    })
    const data = await res.data

    console.log(res.data);

    if (res.status === 200) {
      emit('toast', data.message, 'success')
      emit('update-success')
      emit('fermerUpdate')
    } else {
      emit('toast', data.message || 'Erreur', 'error')
      console.log('Erreur')
    }
  } catch (e) {
    console.log(e)
    emit('toast', 'Erreur de connexion '+ e, 'error')
  }
}
watch(() => props.numlocB, (newVal) => {
  if (newVal) {
    numloc.value = newVal.numloc
    nom_loc.value = newVal.nom_loc
    design_voiture.value = newVal.design_voiture
    taux_jour.value = newVal.taux_jour
    nbr_jour.value = newVal.nbr_jour
  }
}, { immediate: true })

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
  z-index: 999999999;
}
.modifierForm{
  top: 10%;
  left: 23%;
  right: 23%;
  width: auto;
  height: auto;
  max-height: 90vh;
  overflow-y: auto;
  position: fixed;
  z-index: 999999999;
  background: linear-gradient(-135deg, #0d033d, #250e75, #5a1ca2, #9424b8);
  padding: 3rem;
  border-radius: 15px;
}
@media screen and (max-width: 948px) {
  .modifierForm{
    left: 10%;
    right: 10%
  }
}
</style>
    
    