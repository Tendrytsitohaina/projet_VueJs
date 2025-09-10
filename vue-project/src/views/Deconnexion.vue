<template>
<!-- <div class="blurOpacity"></div> -->
<div class="suppressionForm">
    <div>
        <div>
           
            <div class="modalTitle">
                <h2>Déconnexion</h2>
                <button type="button" class="btn-close" @click="fermerDeconnexion"></button>
            </div>
            <p>Etes-vous sur de se deconnecter?</p>
            <div class="hstack gap-2 justify-content-end">
                <span class="btn btn-light" @click="fermerDeconnexion">Non</span>
                <button @click="logout" class="btn btn-success">Oui, je suis sur</button>
            </div>
    
        </div>
    </div>
</div>
</template>

<script setup>
import { ref, defineEmits, defineProps } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const toogleNav = ref(false)
const emit = defineEmits(['toast', 'delete-success', 'fermerDelete'])
const fermerDeconnexion = () => {
    emit('fermerDelete')
}

const props = defineProps({
    numlocA: String
})


const logout = async () => {
  try {
    await fetch('http://localhost/projet_VueJs/cliprojvue/backend/API/utilisateurs/logout.php', {
      method: 'POST',
      credentials: 'include', // important pour envoyer les cookies (session)
    })
    localStorage.removeItem('auth') // si tu l'utilises
    toogleNav.value = false
    emit('delete-success')
    router.push('/AuthLogin') // ou la route de login
  } catch (error) {
    console.log('Erreur de déconnexion'+ error)
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
    z-index: 99999999900000000000000000000000000000000000000000000000000000000000;
}
.suppressionForm{
    top: 25%;
    left: 23%;
    right: 23%;
    width: auto;
    position: fixed;
    z-index: 99999999900000000000000000000000000000000000000000000000000000000000000;
    background: linear-gradient(-135deg, #0d033d, #250e75, #5a1ca2, #9424b8);
    padding: 3rem;
    border-radius: 15px;

}
</style>
    
    