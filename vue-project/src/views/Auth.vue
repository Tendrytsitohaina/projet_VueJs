<template>
    <div class="auth-wrapper">
      <transition name="slide-login" mode="out-in">
        <div class="auth-form" v-if="isLogin" key="login">
          <div class="greetingform">
            <div>
              <h2>Connexion</h2>
                <form @submit.prevent="login">
                  <input v-model="username" type="text" placeholder="Nom d'utilisateur" required />
                  <input v-model="password" type="password" placeholder="Mot de passe" required />
                  <button type="submit" class="btn btn-primary">Se connecter</button>
                  <p>Pas de compte ? <span @click="toggle">Créer un compte</span></p>
                </form>
              </div>
          </div>
          <div class="message">
            <p style="color: white; font-size: 1.3em;">Hey, Bienvenue de nouveau sur <br> application web pour votre gestion de location. <br><br>
            Veuillez-vous authentifier pour continuer!</p>
          </div>
        </div>
      </transition>
  
      <transition name="slide-signup" mode="out-in">
        <div class="auth-form" v-if="!isLogin" key="signup">
          <div class="greetingform">
            <h2>Inscription</h2>
              <form @submit.prevent="signup">
                <input v-model="username" type="text" placeholder="Nom d'utilisateur" required />
                <input v-model="password" type="password" placeholder="Mot de passe" required />
                <button type="submit" class="btn btn-primary" >Créer un compte</button>
                <p>Déjà inscrit ? <span @click="toggle">Connexion</span></p>
              </form>
          </div>
          <div class="message">
            <p style="color: white; font-size: 1.3em;">Hey, Soyez le bienvenu sur <br> notre application web pour votre gestion de location. <br><br>
              Veuillez-vous créer un compte pour continuer!</p>
          </div>
        </div>
      </transition>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  
  const isLogin = ref(true)
  const username = ref('')
  const password = ref('')
  const router = useRouter()
  
  const toggle = () => {
    isLogin.value = !isLogin.value
  }
  
  const login = async () => {
  try {
    const response = await fetch('http://localhost/projet_VueJs/cliprojvue/BackEnd/API/utilisateurs/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        username: username.value,
        password: password.value
      })
    })

    const data = await response.json()
    console.log(data)

    if (data.success) {
      // Stocker le token ou session si nécessaire
      localStorage.setItem('auth', 'true') // Facultatif, à remplacer par gestion de session côté PHP
      alert('Vous êtes connéctée')
      router.push('/')
    } else {
      alert(data.message)
    }
  } catch (error) {
    console.log(error)
    alert('Erreur serveur')
  }
}
  
const signup = async () => {
  try {
    const response = await fetch('http://localhost/projet_VueJs/cliprojvue/BackEnd/API/utilisateurs/signup.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        username: username.value,
        password: password.value
      })
    })

    const data = await response.json()
    console.log(data.value)

    if (data.success) {
      alert('Compte créé avec succès')
      isLogin.value = true
    } else {
      alert(data.message || 'Erreur lors de l’inscription')
    }
  } catch (error) {
    console.error('Erreur signup:', error)
    alert('Erreur serveur')
  }
}
  </script>
  
  <style scoped>
  .auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
    position: relative;
  }
  
  .auth-form {
    width: 50%;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    position: absolute;
    display: flex;
    gap: 10px;
  }
  .greetingform{
    flex: 1;
    padding: 2rem;
  }
  .message{
    padding: 2rem;
    background-color: #0d033d;
    display: flex;
    flex: 1;
    align-items: center;
    color: aliceblue;
    justify-content: center;
    border-bottom-right-radius: 8px;
    border-top-right-radius: 8px;
  }
  
  input {
    display: block;
    width: 100%;
    margin: 0.5rem 0;
    padding: 0.5rem;
  }
  
  button {
    width: 100%;
    padding: 0.5rem;
    margin-top: 1rem;
  }
  
  p {
    margin-top: 1rem;
    font-size: 0.9rem;
    color: black;
  }
  
  p span {
    color: #007bff;
    cursor: pointer;
    text-decoration: underline;
  }
  
  /* Transition login: glisse de gauche */
  .slide-login-enter-active,
  .slide-login-leave-active {
    transition: all 0.6s ease;
  }
  .slide-login-enter-from {
    transform: translateX(-100%);
    opacity: 0;
  }
  .slide-login-leave-to {
    transform: translateX(100%);
    opacity: 0;
  }
  
  /* Transition signup: glisse de droite */
  .slide-signup-enter-active,
  .slide-signup-leave-active {
    transition: all 0.6s ease;
  }
  .slide-signup-enter-from {
    transform: translateX(100%);
    opacity: 0;
  }
  .slide-signup-leave-to {
    transform: translateX(-100%);
    opacity: 0;
  }
  </style>