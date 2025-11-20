<script setup>
import { defineProps, defineEmits } from "vue";
import MaterialButton from "../../../../components/MaterialButton.vue";

// Props y Emits
const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(["add-comment"]);

// Función para mostrar estrellas
const getStars = (rating) => {
  if (!rating) return "";
  const stars = "★".repeat(rating) + "☆".repeat(5 - rating);
  return `${stars} (${rating}/5)`;
};
</script>

<template>
  <div class="card h-100">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">{{ post.author }}</h5>
      <p class="card-text text-body">
        {{ post.content }}
      </p>

      <div v-if="post.comments.length > 0" class="mt-auto pt-3 border-top">
        <h6 class="text-xs text-uppercase text-secondary font-weight-bolder">
          Comentarios:
        </h6>
        <ul class="list-group list-group-flush">
          <li
            v-for="comment in post.comments.slice(0, 2)"
            :key="comment.id"
            class="list-group-item border-0 p-0"
          >
            <p class="text-dark text-sm mb-0">
              <strong>{{ comment.author }}:</strong> {{ comment.text }}
            </p>
            <span class="text-xs text-warning">{{
              getStars(comment.rating)
            }}</span>
          </li>
          <li
            v-if="post.comments.length > 2"
            class="list-group-item border-0 p-0 text-sm text-muted"
          >
            ...y {{ post.comments.length - 2 }} más
          </li>
        </ul>
      </div>
    </div>

    <div class="card-footer pt-0 border-0">
      <MaterialButton
        variant="outline"
        color="success"
        size="sm"
        class="w-100"
        data-bs-toggle="modal"
        :data-bs-target="`#commentModal-${post.id}`"
      >
        Comentar
      </MaterialButton>
    </div>
  </div>
</template>

<style scoped>
/* Asegura que la tarjeta tenga una altura mínima */
.card {
  min-height: 250px;
}
</style>
