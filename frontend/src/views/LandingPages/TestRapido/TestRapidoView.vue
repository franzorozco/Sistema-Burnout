<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { Modal } from "bootstrap";
import axios from "axios";

// --- Componentes ---
import NavbarDefault from "../../../examples/navbars/NavbarDefault.vue";
import FooterDefault from "../../../examples/footers/FooterDefault.vue";
import Header from "../../../examples/Header.vue";
import MaterialButton from "../../../components/MaterialButton.vue";
import TestResultModal from "./components/TestResultModal.vue";

// --- Lógica del Test ---
const API_URL = "http://127.0.0.1:8000/api";

// Estado del cuestionario (se carga dinámicamente desde la BD)
const questionnaire = ref(null);
const questions = ref([]);
const likertOptions = ref([]);
const loadingTest = ref(true);
const loadError = ref(false);

// Estado para las respuestas
const answers = ref({});

// Estado para los resultados
const score = ref(0);
const resultStatus = ref("");
const resultEmoji = ref("");

// Calcular puntaje máximo dinámicamente según la cantidad de preguntas
const maxScore = computed(() => questions.value.length * 5);

// Verificación de Formulario Completo
const isComplete = computed(() => {
  return questions.value.length > 0 && Object.keys(answers.value).length === questions.value.length;
});

// Cargar cuestionario fijado desde la API
const loadPinnedTest = async () => {
  loadingTest.value = true;
  loadError.value = false;
  try {
    const res = await axios.get(`${API_URL}/questionnaires/pinned`);
    const data = res.data.data;
    questionnaire.value = data;
    questions.value = (data.items || []).map((item) => ({
      id: item.id,
      text: item.question_text,
      order: item.item_order,
    }));
    // Extraer opciones Likert del primer item (son iguales para todos)
    if (data.items && data.items.length > 0 && data.items[0].choices) {
      likertOptions.value = data.items[0].choices
        .sort((a, b) => a.choice_order - b.choice_order)
        .map((c) => ({ label: c.label, value: parseInt(c.value) }));
    } else {
      // Fallback por si no hay choices
      likertOptions.value = [
        { label: "Nunca", value: 1 },
        { label: "Casi Nunca", value: 2 },
        { label: "A Veces", value: 3 },
        { label: "Casi Siempre", value: 4 },
        { label: "Siempre", value: 5 },
      ];
    }
  } catch (error) {
    console.error("Error cargando el test:", error);
    loadError.value = true;
  } finally {
    loadingTest.value = false;
  }
};

// Función para resetear el formulario
const resetForm = () => {
  answers.value = {};
  score.value = 0;
  window.scrollTo(0, 0);
};

// Variable para guardar la instancia del Modal
let modalInstance = null;
const resultModalRef = ref(null);

// Función de Envío
const submitTest = async () => {
  if (!isComplete.value) return;

  // Calcular Puntaje
  let totalScore = 0;
  for (const qId in answers.value) {
    totalScore += answers.value[qId];
  }
  score.value = totalScore;

  // Determinar Resultado dinámicamente basado en el puntaje máximo
  const pctScore = totalScore / maxScore.value;
  if (pctScore <= 0.4) {
    resultStatus.value = "Te encuentras Bien";
    resultEmoji.value = "😃";
  } else if (pctScore <= 0.7) {
    resultStatus.value = "Atención: Signos de Estrés";
    resultEmoji.value = "😐";
  } else {
    resultStatus.value = "Prioridad: Busca Apoyo";
    resultEmoji.value = "😥";
  }

  // Preparar Payload para Laravel
  const payload = {
    questionnaire_id: questionnaire.value.id,
    student_profile_id: null,
    user_id: null,
    summary_score: score.value,
    raw: answers.value,
  };

  try {
    await axios.post(`${API_URL}/questionnaire-responses`, payload);
  } catch (error) {
    console.error("Error al guardar:", error.response?.data || error.message);
  }

  // Mostrar Modal de Resultados
  if (modalInstance) {
    modalInstance.show();
  }
};

// --- Manejo de la página ---
const body = document.getElementsByTagName("body")[0];

onMounted(async () => {
  body.classList.add("test-page");
  body.classList.add("bg-gray-200");

  // Cargar preguntas dinámicamente
  await loadPinnedTest();

  resultModalRef.value = document.getElementById("resultModal");
  if (resultModalRef.value) {
    modalInstance = new Modal(resultModalRef.value);
    resultModalRef.value.addEventListener("hidden.bs.modal", resetForm);
  }
});

onUnmounted(() => {
  body.classList.remove("test-page");
  body.classList.remove("bg-gray-200");

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
