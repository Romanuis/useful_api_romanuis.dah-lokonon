import { defineStore } from 'pinia'
import { ref } from 'vue'
export const useAuthStore = defineStore('auth', {
  state: () => ({
    token:localStorage.getItem('teken') || null, user:null,
    module:[]
  }),
  actions: {
    setToken(token) {
      this.token = token
      localStorage.setItem('token, token')
    },
    logout() {
      this.token = null
      localStorage.removeItem('token')
      globalThis.modules = []
    }
  }
})
