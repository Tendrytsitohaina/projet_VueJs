<template>
<div class="blurOpacity"></div>
<div class="suppressionForm">
    <div>
        <form @submit.prevent="submitForm">
            <div class="modalTitle">
                <h2>Suppréssion Location</h2>
                <button type="button" class="btn-close" @click="fermerDelete"></button>
            </div>
            <p>Etes-vous sur de procéder?</p>
            <p>Numero du location: {{ numlocA }}</p>
            <div class="hstack gap-2 justify-content-end">
                <span class="btn btn-light" @click="fermerDelete">Non</span>
                <button type="submit" class="btn btn-success">Oui, je suis sur</button>
            </div>
        </form>
    </div>
</div>
</template>

<script setup>
import { ref, defineEmits, defineProps } from 'vue'
import axios from 'axios'

const fermerDelete = () => {
    emit('fermerDelete')
}

const props = defineProps({
    numlocA: String
})
const emit = defineEmits(['toast', 'delete-success', 'fermerDelete'])

const submitForm = async () => {
  try {
    const res = await axios.post('http://localhost/cliprojvue/backend/API/utilisateurs/supprimer.php', {
      numloc: props.numlocA
    },{
      headers: { 'Content-Type': 'application/json' }
    })
    const data = await res.data

    console.log(res.data);

    if (res.status === 200) {
      emit('toast', data.message, 'success')
      emit('delete-success')
      emit('fermerDelete')
    } else {
      emit('toast', data.message || 'Erreur', 'error')
      console.log('Erreur')
    }
  } catch (e) {
    console.log(e)
    emit('toast', 'Erreur de connexion '+ e, 'error')
  }
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

