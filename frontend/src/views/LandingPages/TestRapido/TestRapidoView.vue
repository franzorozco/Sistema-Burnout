<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { Modal } from "bootstrap"; // Importante para lanzar el Pop-up

// --- Componentes ---
import NavbarDefault from "../../../examples/navbars/NavbarDefault.vue";
import FooterDefault from "../../../examples/footers/FooterDefault.vue";
import Header from "../../../examples/Header.vue";
import MaterialButton from "../../../components/MaterialButton.vue";
import TestResultModal from "./components/TestResultModal.vue";

// --- Lógica del Test ---

// 1. Definición de Preguntas
const questions = ref([
  { id: 1, text: "Me siento emocionalmente agotado/a por mi trabajo/estudio." },
  { id: 2, text: "Siento que me he vuelto más cínico/a o insensible." },
  { id: 3, text: "Me cuesta relajarme después de un día de trabajo/estudio." },
  { id: 4, text: "Siento que no estoy logrando nada valioso." },
  { id: 5, text: "Me irrito fácilmente con colegas, pacientes o profesores." },
  { id: 6, text: "Tengo dificultades para concentrarme." },
  { id: 7, text: "Siento falta de energía para empezar el día." },
  {
    id: 8,
    text: "Me siento desvinculado/a de actividades que antes disfrutaba.",
  },
  { id: 9, text: "Siento que mis esfuerzos no son reconocidos." },
  { id: 10, text: "Tengo problemas para dormir debido al estrés." },
]);

const likertOptions = ref([
  { label: "Nunca", value: 1 },
  { label: "Casi Nunca", value: 2 },
  { label: "A Veces", value: 3 },
  { label: "Casi Siempre", value: 4 },
  { label: "Siempre", value: 5 },
]);

// 2. Estado para las respuestas (El JSON 'raw' de tu DB)
const answers = ref({});

// 3. Estado para los resultados (El Pop-up)
const score = ref(0);
const resultStatus = ref("");
const resultEmoji = ref("");

// 4. Verificación de Formulario Completo
const isComplete = computed(() => {
  return Object.keys(answers.value).length === questions.value.length;
});

// <-- NUEVO: Función para resetear el formulario
const resetForm = () => {
  answers.value = {};
  score.value = 0;
  // Opcional: Desplaza la ventana al inicio
  window.scrollTo(0, 0);
};

// <-- NUEVO: Variable para guardar la instancia del Modal
let modalInstance = null;
const resultModalRef = ref(null); // Ref para el elemento del DOM

// 5. Función de Envío
const submitTest = async () => {
  if (!isComplete.value) return;

  // 5.1. Calcular Puntaje (summary_score)
  let totalScore = 0;
  for (const qId in answers.value) {
    totalScore += answers.value[qId];
  }
  score.value = totalScore;

  // 5.2. Determinar Resultado (Carita y Estado)
  if (totalScore <= 20) {
    resultStatus.value = "Te encuentras Bien";
    resultEmoji.value = "😃";
  } else if (totalScore <= 35) {
    resultStatus.value = "Atención: Signos de Estrés";
    resultEmoji.value = "😐";
  } else {
    resultStatus.value = "Prioridad: Busca Apoyo";
    resultEmoji.value = "😥";
  }

  // 5.3. Preparar el Payload para Laravel
  const payload = {
    questionnaire_id: 1, // ID del Test (debe existir en la tabla 'questionnaires')
    student_profile_id: null,
    user_id: null,
    summary_score: score.value,
    raw: answers.value,
  };

  // --- ⚠️ CONEXIÓN AL BACKEND ⚠️ ---
  console.log("Payload listo para enviar a Laravel:", payload);

  // import axios from "axios";
  // try {
  //   // Reemplaza esto con la URL de tu API de Laravel
  //   const API_URL = "http://tu-backend.com/api/questionnaire-responses";
  //   const response = await axios.post(API_URL, payload);
  //   console.log("Respuesta guardada:", response.data);
  //
  // } catch (error) {
  //   console.error("Error al guardar la respuesta:", error);
  // }
  // --- FIN DE LA CONEXIÓN ---

  // 5.4. Mostrar el Pop-up de Resultados
  // <-- NUEVO: Usamos la instancia guardada
  if (modalInstance) {
    modalInstance.show();
  }
};

// --- Manejo de la página ---
const body = document.getElementsByTagName("body")[0];

onMounted(() => {
  body.classList.add("test-page");
  body.classList.add("bg-gray-200");

  // <-- NUEVO: Preparamos el Modal y el listener
  resultModalRef.value = document.getElementById("resultModal");
  if (resultModalRef.value) {
    // Guardamos la instancia del modal
    modalInstance = new Modal(resultModalRef.value);

    // Añadimos un listener para el evento 'hidden.bs.modal'
    // Este evento se dispara CUANDO el modal TERMINA de cerrarse
    resultModalRef.value.addEventListener("hidden.bs.modal", resetForm);
  }
});

onUnmounted(() => {
  body.classList.remove("test-page");
  body.classList.remove("bg-gray-200");

  // <-- NUEVO: Limpiamos el listener al salir de la página
  if (resultModalRef.value) {
    resultModalRef.value.removeEventListener("hidden.bs.modal", resetForm);
  }
});
</script>

<template>
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <NavbarDefault :sticky="true" />
      </div>
    </div>
  </div>

  <Header>
    <div
      class="page-header min-vh-25"
      :style="{
        paddingTop: '100px',
        backgroundImage:
          'url(https://images.pexels.com/photos/5336953/pexels-photo-5336953.jpeg)',
      }"
      loading="lazy"
    >
      <span class="mask bg-gradient-success opacity-6"></span>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 text-center mx-auto">
            <h1 class="text-white">Test Rápido de Bienestar</h1>
            <p class="text-white">
              Evalúa tu nivel de estrés actual. (100% anónimo)
            </p>
          </div>
        </div>
      </div>
    </div>
  </Header>

  <section class="py-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <form role="form" id="test-form" @submit.prevent="submitTest">
            <div
              v-for="(question, index) in questions"
              :key="question.id"
              class="card shadow-sm mb-4"
            >
              <div class="card-body">
                <p class="mb-3 text-dark font-weight-bolder">
                  {{ index + 1 }}. {{ question.text }}
                </p>

                <div
                  class="d-flex justify-content-between flex-wrap"
                  role="group"
                >
                  <div
                    v-for="option in likertOptions"
                    :key="option.value"
                    class="form-check form-check-inline mx-2"
                  >
                    <input
                      class="form-check-input"
                      type="radio"
                      :name="`q${question.id}`"
                      :id="`q${question.id}_${option.value}`"
                      :value="option.value"
                      v-model.number="answers[question.id]"
                      required
                    />
                    <label
                      class="form-check-label"
                      :for="`q${question.id}_${option.value}`"
                    >
                      {{ option.label }}
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div classG="text-center mt-4">
              <MaterialButton
                type="submit"
                variant="gradient"
                color="success"
                size="lg"
                class="w-100"
                :disabled="!isComplete"
              >
                Ver Mi Resultado
              </MaterialButton>
              <p v-if="!isComplete" class="text-muted text-sm text-center mt-2">
                *Por favor, responde todas las preguntas para continuar.
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <FooterDefault />

  <TestResultModal :score="score" :status="resultStatus" :emoji="resultEmoji" />
</template>

<style scoped>
/* Estilos para que los radio buttons se vean bien en móviles */
.form-check-inline {
  margin-bottom: 0.5rem;
}
</style>
