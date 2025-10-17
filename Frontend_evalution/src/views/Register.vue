<template>
  <form @submit.prevent="handleSubmit">
    <input v-model="name" type="text" placeholder="Nom" required />
    <input v-model="email" type="email" placeholder="Email" required />
    <input v-model="password" type="password" placeholder="Mot de passe" required />
    <input
      v-model="confirmPassword"
      type="password"
      placeholder="Confirmer le mot de passe"
      required
    />
    <button type="submit">Inscription</button>
  </form>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
    };
  },
  methods: {
    async handleSubmit() {
      if (this.password !== this.confirmPassword) {
        alert("Les mots de passe ne correspondent pas");
        return;
      }
      try {
        const res = await axios.post("/register", {
          // Route du Module 0
          name: this.name,
          email: this.email,
          password: this.password,
        });
        alert("Inscription réussie");
        this.$router.push("/login");
      } catch (error) {
        alert("Échec de l’inscription");
      }
    },
  },
};
</script>
