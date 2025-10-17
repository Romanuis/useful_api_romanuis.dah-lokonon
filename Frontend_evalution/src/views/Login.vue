<template>
  <form @submit.prevent="handleSubmit">
    <input v-model="email" type="email" placeholder="Email" required />
    <input v-model="password" type="password" placeholder="Mot de passe" required />
    <button type="submit" :disabled="status.loggingIn">Connexion</button>
  </form>
</template>

<script>
import { useAuthStore } from '@/stores/auth'
import axios from 'axios'

export default {
  data() {
    return {
      email: '',
      password: '',
      status: { loggingIn: false }
    }
  },
  methods: {
    async handleSubmit() {
      this.status.loggingIn = true
      try {
        const res = await axios.post('/login', { // Route correcte du Module 0
          email: this.email,
          password: this.password
        })
        useAuthStore().setToken(res.data.token)
        this.$router.push('/dashboard')
      } catch (error) {
        alert('Échec de la connexion')
      } finally {
        this.status.loggingIn = false
      }
    }
  }
}
</script>
