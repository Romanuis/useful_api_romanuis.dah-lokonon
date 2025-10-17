<template>
  <div>
    <h2>Mes Modules</h2>
    <div v-for="module in modules" :key="module.id">
      <span>{{ module.name }}</span>
      <input
        type="checkbox"
        :checked="module.active"
        @change="toggleModule(module)"
      />
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      modules: []
    }
  },
  async mounted() {
    try {
      const res = await axios.get('/modules') // Route correcte du Module 0
      this.modules = res.data.map(m => ({ ...m, active: true }))
    } catch (error) {
      console.error('Erreur lors du chargement des modules', error)
    }
  },
  methods: {
    async toggleModule(module) {
      const action = module.active ? 'deactivate' : 'activate'
      try {
        await axios.post(`/modules/${module.id}/${action}`) // Route correcte du Module 0
        module.active = !module.active
      } catch (error) {
        console.error('Erreur lors de la mise à jour du module', error)
      }
    }
  }
}
</script>   
