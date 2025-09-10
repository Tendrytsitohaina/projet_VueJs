<!-- eslint-disable no-unused-vars -->
<template>
  <div id="app">
    <div class="overlay" v-if="toogleNav" @click="toogleNav = false"></div>
    <div class="header container-fluid" v-if="!isAuthRoute">
      <div class="logo">
        <h2><span>e-</span>Tomobile.</h2>
      </div>
      <div class="router mobile-menu" :class="{show: toogleNav}">
        <router-link to="/"><span style="--i:1" @click="toogleNav = false">Tableau de Bord</span></router-link>
        <router-link to="/home"><span style="--i:2" @click="toogleNav = false">Listage et mis-à-jour</span></router-link>
        <router-link to="/ajoutLocation"><span style="--i:3" @click="toogleNav = false">Nouvelle Location</span> </router-link>
        <router-link ><span style="--i:4" @click="openDeconnexion">Déconnexion</span></router-link>
      </div>
      <div class="humberger" :class="{change: toogleNav}"@click="toogleMenu">
        <div class="up"></div>
        <div class="middle"></div>
        <div class="down"></div>
      </div>
    </div>
    <div class="container" :class="{ noPadding: isAuthRoute }">
      <router-view />
    </div>
  </div>
  <FadeSlideTransition>
    <Deconnexion v-if="deconnexion" @fermerDelete="deconnexion = false" @delete-success="deconnexion = false"/>
  </FadeSlideTransition>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import FadeSlideTransition from './views/FadeSlideTransition.vue';
import Deconnexion from './views/Deconnexion.vue';
import { useRoute } from 'vue-router';
const toogleNav = ref(false)
const toogleMenu = () =>{
  toogleNav.value = !toogleNav.value
  console.log(toogleNav.value)
}

const deconnexion = ref(false)
const openDeconnexion = ()=>{
  deconnexion.value = true
}

const route = useRoute()

const isAuthRoute = computed(()=> route.path === '/AuthLogin')

import { useRouter } from 'vue-router'

const router = useRouter()

const logout = async () => {
  try {
    await fetch('http://localhost/projet_VueJs/cliprojvue/backend/API/utilisateurs/logout.php', {
      method: 'POST',
      credentials: 'include', // important pour envoyer les cookies (session)
    })
    localStorage.removeItem('auth') // si tu l'utilises
    toogleNav.value = false
    router.push('/AuthLogin') // ou la route de login
  } catch (error) {
    console.log('Erreur de déconnexion'+ error)
  }
}

const isAuthenticated = ref(false)

onMounted(async () => {
  try {
    const res = await fetch('http://localhost/projet_VueJs/cliprojvue/backend/API/utilisateurs/checkAuth.php', {
      method: 'GET',
      credentials: 'include' // pour que le cookie de session PHP soit envoyé
    })

    const data = await res.json()

    if (data.authenticated) {
      isAuthenticated.value = true
    } else {
      isAuthenticated.value = false
      router.push('/AuthLogin') // redirige si non authentifié
    }
  } catch (error) {
    console.error('Erreur de vérification de session', error)
    router.push('/AuthLogin')
  }
})
</script>

<style>

.title{
  font-size: 3em;
  font-weight: bold;
  background: linear-gradient(to right, #ba5a8f, #f9259a);
  background-clip: text;
  color: transparent;
  text-align: center;
  margin-top: 1em;
}
.container.noPadding {
  padding-top: 0 !important;
}

.up{
    margin-top: -14px;
    width: 50px;
    height: 0.83vh;
    border-radius: 5px;
    background-color: white;
    transition:  0.4s;
}

.middle{
    margin-top: 5px;
    width: 50px;
    height: 0.8vh;
    border-radius: 5px;
    background-color: white;
    transition: ease-in-out 0.4s;
}

.down{
    margin-top: 4.5px;
    width: 50px;
    height: 0.83vh;
    border-radius: 5px;
    background-color: white;
    transition:  0.4s;
}

.change .middle{
    opacity: 0;
}

.change .up{
    transform: translate(-20% , 70%);
    rotate: -45deg;
}
.change .down{
    transform: translate(-20% , -90%);
    rotate: 42deg;
}

/*  */

.logo h2{
  font-family: cursive;
  color: white;
  margin-left:2rem;
  font-size: 1.75em;
}
.logo span{
  color:#d13f8d
}

.router span{
  background: #e1cbe9;
  padding: 0.65em 1em;
  margin: 0 0.75em;
  border-radius: 10px;
  transition: all .5s;
  color: rgb(0, 0, 0);
}

.router span:hover{
  opacity: 0.8;
}

.header{
  background: #0d033d;
  padding: 0.5rem;
  position: fixed;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0px 4px 15px rgba(255, 255, 255, 0.1);
  z-index:9999999999999999999999999999999999;
}
.container{
  padding-top: 15vh;
}

.humberger{
  display: none;
}

@media screen and (max-width: 948px) {
  .router{
    position: absolute;    
  }

  .router span{
    margin: 10px 0;
  }
  .humberger{
    display: block;
    align-items: center;
    margin-right: 6%;
    margin-top:0.75rem
  }

  .overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    backdrop-filter: blur(5px);
    background: rgba(0, 0, 0, 0.4);
    z-index: 9999999999;
    transition: opacity 0.4s ease;
  }

  /* Menu mobile de base caché */
  .mobile-menu {
    position: fixed;
    top: 0;
    left: -100%;
    width: 65%;
    height: 100vh;
    background-color: rgba(20, 20, 20, 0.95); /* fond dark semi-transparent */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: start;
    padding: 2rem;
    transition: left 0.5s ease;
    z-index: 9999;
  }

  /* Lorsqu'on toggle vers "open" */
  .mobile-menu.show {
    left: 0;
  }

  /* Style général des liens */
  .mobile-menu span {
    display: inline-block;
    color: white;
    margin: 1rem 0;
    padding: 0.75em 1.25em;
    border-radius: 10px;
    background: linear-gradient(134deg, #0d033d, #250e75, #5a1ca2, #9424b8);
    transform: translateX(-20px);
    opacity: 0;
    animation: slideIn 0.5s forwards;
    animation-delay: calc(var(--i) * 0.8s); /* décalage progressif */
  }

  /* Animation des liens */
  @keyframes slideIn {
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }
  
  .ajoutForm{
    left: 15%;
  }
  .logo{
    margin-left: 4%;
  }
}
</style>
