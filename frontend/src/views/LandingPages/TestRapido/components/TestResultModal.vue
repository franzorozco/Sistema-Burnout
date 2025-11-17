<script setup>
import { defineProps } from "vue";
import MaterialButton from "../../../../components/MaterialButton.vue";

// Recibimos los datos calculados desde la vista principal
const props = defineProps({
  score: { type: Number, required: true },
  status: { type: String, required: true },
  emoji: { type: String, required: true },
});
</script>

<template>
  <div
    class="modal fade"
    id="resultModal"
    tabindex="-1"
    aria-labelledby="modalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Tu Resultado</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="text-center py-4">
            <div style="font-size: 6rem; line-height: 1">
              {{ emoji }}
            </div>

            <h3 class="mt-4">{{ status }}</h3>

            <p class="text-body">
              Tu puntaje fue: <strong>{{ score }} / 50</strong>
            </p>
            <p class="text-sm text-muted mt-4">
              *Recuerda que esto no es un diagnóstico médico. Es solo una
              herramienta de autoevaluación. Si te sientes abrumado/a, busca
              apoyo profesional.
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <MaterialButton
            variant="outline"
            color="secondary"
            data-bs-dismiss="modal"
          >
            Cerrar
          </MaterialButton>
        </div>
      </div>
    </div>
  </div>
</template>
