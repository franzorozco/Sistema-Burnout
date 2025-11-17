<script setup>
import { ref, defineProps, defineEmits } from "vue";
import MaterialTextArea from "../../../../components/MaterialTextArea.vue";
import MaterialButton from "../../../../components/MaterialButton.vue";

// Props y Emits
const props = defineProps({
  postId: {
    type: [String, Number],
    required: true,
  },
});
const emit = defineEmits(["submit-comment"]);

// Estado local del modal
const commentText = ref("");
const rating = ref(0); // 0 = sin calificar

const setRating = (star) => {
  rating.value = star;
};

const submit = () => {
  if (commentText.value.trim() === "") return;

  emit("submit-comment", {
    text: commentText.value,
    rating: rating.value === 0 ? null : rating.value, // Enviar null si no calificó
  });

  // Limpiar el modal
  commentText.value = "";
  rating.value = 0;
  // El data-bs-dismiss="modal" en el botón se encargará de cerrarlo
};
</script>

<template>
  <div
    class="modal fade"
    :id="`commentModal-${postId}`"
    tabindex="-1"
    aria-labelledby="modalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Agregar Comentario</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Tu apodo:</label>
            <input
              type="text"
              class="form-control"
              value="Interno Anonimo"
              disabled
            />
          </div>

          <MaterialTextArea
            id="commentText"
            v-model="commentText"
            placeholder="Escribe tu comentario..."
            rows="4"
          />

          <div class="mt-3">
            <label class="form-label d-block"
              >Califica esta publicación (opcional):</label
            >
            <div class="star-rating">
              <span
                v-for="star in 5"
                :key="star"
                class="star"
                :class="{ filled: star <= rating }"
                @click="setRating(star)"
              >
                <i class="material-icons">{{
                  star <= rating ? "star" : "star_outline"
                }}</i>
              </span>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <MaterialButton
            variant="outline"
            color="secondary"
            data-bs-dismiss="modal"
          >
            Cerrar
          </MaterialButton>
          <MaterialButton
            variant="gradient"
            color="success"
            @click="submit"
            data-bs-dismiss="modal"
          >
            Publicar
          </MaterialButton>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Estilos para las estrellas */
.star-rating .star {
  cursor: pointer;
  color: #ffc107; /* Amarillo de estrella */
  font-size: 2rem;
  transition: all 0.2s;
}

.star-rating .star:hover {
  transform: scale(1.1);
}

.star-rating .star .material-icons {
  font-size: 2.5rem;
}
</style>
