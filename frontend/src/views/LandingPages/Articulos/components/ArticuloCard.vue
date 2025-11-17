<script setup>
import { defineProps } from "vue";
import MaterialButton from "../../../../components/MaterialButton.vue";

// Define los props que recibirá la tarjeta
const props = defineProps({
  article: {
    type: Object,
    required: true,
    default: () => ({
      image: "",
      title: "Título del Artículo",
      description: "Descripción breve del artículo...",
      link: "#",
    }),
  },
});
</script>

<template>
  <div class="card h-100">
    <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
      <a :href="article.link" target="_blank" class="d-block">
        <img
          :src="article.image"
          class="img-fluid border-radius-lg"
          :alt="article.title"
        />
      </a>
    </div>

    <div class="card-body pt-3">
      <h5 class="card-title text-dark">
        {{ article.title }}
      </h5>
      <p class="card-text text-body">
        {{ article.description }}
      </p>
    </div>

    <!-- <div class="card-footer pt-0 border-0">
      <MaterialButton
        :is="'a'"
        :href="article.link"
        target="_blank"
        rel="noopener"
        variant="outline"
        color="success"
        size="sm"
        class="w-100"
      >
        Leer Más
      </MaterialButton>
    </div> -->
  </div>
</template>

<style scoped>
/* Estilo para que todas las tarjetas tengan una altura uniforme */
.card {
  display: flex;
  flex-direction: column;
}
.card-body {
  flex-grow: 1;
}
</style>
