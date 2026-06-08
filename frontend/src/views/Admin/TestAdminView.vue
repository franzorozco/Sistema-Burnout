<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

const API = "http://127.0.0.1:8000/api";

const questionnaire = ref(null);
const items = ref([]);
const stats = ref({ total: 0, avg_score: 0, distribution: { bien: 0, atencion: 0, prioridad: 0 }, responses: [] });
const loading = ref(true);
const loadingStats = ref(true);
const activeTab = ref("questions"); // questions | stats | responses

const getToken = () => localStorage.getItem("token");

// ==================== LOAD DATA ====================
const loadQuestionnaire = async () => {
  loading.value = true;
  try {
    const token = getToken();
    // First try to get all questionnaires and find the pinned one
    const res = await axios.get(`${API}/questionnaires`, {
      headers: { Authorization: `Bearer ${token}` },
    });
    const all = res.data.data || [];
    const pinned = all.find((q) => q.is_pinned);
    if (pinned) {
      const detail = await axios.get(`${API}/questionnaires/${pinned.id}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      questionnaire.value = detail.data.data;
      items.value = questionnaire.value.items || [];
    } else if (all.length > 0) {
      const detail = await axios.get(`${API}/questionnaires/${all[0].id}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      questionnaire.value = detail.data.data;
      items.value = questionnaire.value.items || [];
    }
  } catch (error) {
    console.error("Error cargando cuestionario:", error);
  } finally {
    loading.value = false;
  }
};

const loadStats = async () => {
  if (!questionnaire.value) return;
  loadingStats.value = true;
  try {
    const token = getToken();
    const res = await axios.get(`${API}/questionnaire-responses-stats/${questionnaire.value.id}`, {
      headers: { Authorization: `Bearer ${token}` },
    });
    stats.value = res.data;
  } catch (error) {
    console.error("Error cargando estadísticas:", error);
  } finally {
    loadingStats.value = false;
  }
};

onMounted(async () => {
  await loadQuestionnaire();
  if (questionnaire.value) {
    loadStats();
  }
});

// ==================== QUESTIONS CRUD ====================
const showQuestionModal = ref(false);
const editingQuestion = ref({
  id: null,
  question_text: "",
  response_type: "likert",
  choices: []
});

const defaultLikert = [
  { label: "Nunca", value: "1" },
  { label: "Casi Nunca", value: "2" },
  { label: "A Veces", value: "3" },
  { label: "Casi Siempre", value: "4" },
  { label: "Siempre", value: "5" },
];

const openAddQuestionModal = () => {
  editingQuestion.value = {
    id: null,
    question_text: "",
    response_type: "likert",
    choices: [...defaultLikert]
  };
  showQuestionModal.value = true;
};

const openEditQuestionModal = (item) => {
  editingQuestion.value = {
    id: item.id,
    question_text: item.question_text,
    response_type: item.response_type,
    choices: item.choices ? item.choices.map(c => ({ label: c.label, value: c.value })) : []
  };
  showQuestionModal.value = true;
};

const closeQuestionModal = () => {
  showQuestionModal.value = false;
};

const addChoice = () => {
  editingQuestion.value.choices.push({ label: "", value: "" });
};

const removeChoice = (index) => {
  editingQuestion.value.choices.splice(index, 1);
};

const saveQuestion = async () => {
  if (!editingQuestion.value.question_text.trim()) {
    Swal.fire("Error", "La pregunta no puede estar vacía", "error");
    return;
  }
  
  if (['likert', 'opcion'].includes(editingQuestion.value.response_type) && editingQuestion.value.choices.length === 0) {
    Swal.fire("Error", "Debe agregar al menos una opción", "error");
    return;
  }

  const token = getToken();
  try {
    const payload = {
      question_text: editingQuestion.value.question_text,
      response_type: editingQuestion.value.response_type,
      choices: ['likert', 'opcion'].includes(editingQuestion.value.response_type) ? editingQuestion.value.choices : []
    };

    if (editingQuestion.value.id) {
      await axios.put(`${API}/questionnaires/${questionnaire.value.id}/items/${editingQuestion.value.id}`, payload, { headers: { Authorization: `Bearer ${token}` } });
      Swal.fire({ icon: "success", title: "Pregunta actualizada", timer: 1500, showConfirmButton: false });
    } else {
      await axios.post(`${API}/questionnaires/${questionnaire.value.id}/items`, payload, { headers: { Authorization: `Bearer ${token}` } });
      Swal.fire({ icon: "success", title: "Pregunta agregada", timer: 1500, showConfirmButton: false });
    }
    
    await loadQuestionnaire();
    closeQuestionModal();
  } catch (e) {
    Swal.fire("Error", "No se pudo guardar la pregunta", "error");
  }
};

const deleteQuestion = async (item) => {
  const result = await Swal.fire({
    title: "¿Eliminar esta pregunta?",
    text: item.question_text,
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
    confirmButtonColor: "#e53935",
  });
  if (!result.isConfirmed) return;
  try {
    const token = getToken();
    await axios.delete(`${API}/questionnaires/${questionnaire.value.id}/items/${item.id}`, {
      headers: { Authorization: `Bearer ${token}` },
    });
    await loadQuestionnaire();
    Swal.fire({ icon: "success", title: "Pregunta eliminada", timer: 1500, showConfirmButton: false });
  } catch (e) {
    Swal.fire("Error", "No se pudo eliminar", "error");
  }
};

const editTitle = async () => {
  const { value: formValues } = await Swal.fire({
    title: "Editar Cuestionario",
    html: `
      <input id="swal-title" class="swal2-input" value="${questionnaire.value.title}" placeholder="Título">
      <textarea id="swal-desc" class="swal2-textarea" placeholder="Descripción">${questionnaire.value.description || ""}</textarea>
    `,
    showCancelButton: true,
    confirmButtonText: "Guardar",
    cancelButtonText: "Cancelar",
    confirmButtonColor: "#0077b6",
    preConfirm: () => ({
      title: document.getElementById("swal-title").value,
      description: document.getElementById("swal-desc").value,
    }),
  });
  if (!formValues) return;
  try {
    const token = getToken();
    await axios.put(`${API}/questionnaires/${questionnaire.value.id}`, formValues, {
      headers: { Authorization: `Bearer ${token}` },
    });
    await loadQuestionnaire();
    Swal.fire({ icon: "success", title: "Actualizado", timer: 1500, showConfirmButton: false });
  } catch (e) {
    Swal.fire("Error", "No se pudo actualizar", "error");
  }
};

// Helpers
const getLevel = (score) => {
  if (score <= 20) return { text: "Bien", color: "success", icon: "sentiment_satisfied" };
  if (score <= 35) return { text: "Atención", color: "warning", icon: "sentiment_neutral" };
  return { text: "Prioridad", color: "danger", icon: "sentiment_very_dissatisfied" };
};

const formatDate = (d) => {
  if (!d) return "—";
  return new Date(d).toLocaleString("es-ES", { day: "2-digit", month: "2-digit", year: "numeric", hour: "2-digit", minute: "2-digit" });
};

const totalQuestions = computed(() => items.value.length);
const maxScore = computed(() => totalQuestions.value * 5);
</script>

<template>
  <div class="row fade-in">
    <!-- Header -->
    <div class="col-12 mb-4">
      <div class="card shadow-lg border-0 premium-card overflow-hidden">
        <div class="test-header">
          <div class="header-content d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center">
              <div class="header-icon-wrapper me-3">
                <i class="material-icons" style="font-size: 36px; color: white">quiz</i>
              </div>
              <div>
                <h4 class="text-white mb-1 font-weight-bold">
                  {{ questionnaire ? questionnaire.title : "Gestión del Test" }}
                </h4>
                <p class="text-white-50 mb-0" style="font-size: 14px">
                  {{ questionnaire ? questionnaire.description : "Cargando..." }}
                </p>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
              <span v-if="questionnaire && questionnaire.is_pinned" class="badge bg-white text-primary px-3 py-2" style="font-size: 12px">
                <i class="material-icons me-1" style="font-size: 14px; vertical-align: middle">push_pin</i>
                Fijado en Test Rápido
              </span>
              <button v-if="questionnaire" class="btn btn-sm btn-outline-light mb-0" @click="editTitle">
                <i class="material-icons" style="font-size: 16px; vertical-align: middle">edit</i> Editar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="col-12 text-center p-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="text-secondary mt-3">Cargando cuestionario...</p>
    </div>

    <!-- No Questionnaire -->
    <div v-else-if="!questionnaire" class="col-12">
      <div class="card shadow-lg border-0 premium-card p-5 text-center">
        <i class="material-icons text-secondary mb-3" style="font-size: 64px">quiz</i>
        <h5 class="text-secondary">No hay un cuestionario fijado</h5>
        <p class="text-secondary text-sm">Crea un cuestionario y fíjalo para que aparezca en la página de Test Rápido.</p>
      </div>
    </div>

    <!-- Main Content -->
    <template v-else>
      <!-- Tabs -->
      <div class="col-12 mb-4">
        <div class="card shadow-lg border-0 premium-card">
          <div class="card-body p-2">
            <div class="d-flex gap-2">
              <button class="btn mb-0 flex-fill" :class="activeTab === 'questions' ? 'bg-gradient-primary text-white shadow-primary' : 'btn-outline-secondary'" @click="activeTab = 'questions'">
                <i class="material-icons me-1" style="font-size: 18px; vertical-align: middle">list_alt</i>
                Preguntas ({{ totalQuestions }})
              </button>
              <button class="btn mb-0 flex-fill" :class="activeTab === 'stats' ? 'bg-gradient-primary text-white shadow-primary' : 'btn-outline-secondary'" @click="activeTab = 'stats'; loadStats()">
                <i class="material-icons me-1" style="font-size: 18px; vertical-align: middle">bar_chart</i>
                Estadísticas
              </button>
              <button class="btn mb-0 flex-fill" :class="activeTab === 'responses' ? 'bg-gradient-primary text-white shadow-primary' : 'btn-outline-secondary'" @click="activeTab = 'responses'; loadStats()">
                <i class="material-icons me-1" style="font-size: 18px; vertical-align: middle">assignment</i>
                Respuestas ({{ stats.total }})
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB: Questions -->
      <div class="col-12 mb-4" v-if="activeTab === 'questions'">
        <div class="card shadow-lg border-0 premium-card">
          <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center">
            <div>
              <h5 class="font-weight-bolder text-dark mb-0">
                <i class="material-icons text-primary me-1" style="font-size: 22px; vertical-align: middle">format_list_numbered</i>
                Preguntas del Cuestionario
              </h5>
              <p class="text-sm text-secondary mb-0">Escala Likert 1-5 · Puntaje máximo: {{ maxScore }}</p>
            </div>
            <button class="btn bg-gradient-primary shadow-primary mb-0 hover-scale" @click="openAddQuestionModal">
              <i class="material-icons me-1" style="font-size: 16px; vertical-align: middle">add_circle</i>
              Agregar Pregunta
            </button>
          </div>
          <div class="card-body px-0 pt-3 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0 table-hover premium-table">
                <thead class="bg-light">
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 60px">#</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pregunta</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 100px">Tipo</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 100px">Opciones</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 120px">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in items" :key="item.id" class="table-row">
                    <td class="ps-4">
                      <span class="question-number">{{ item.item_order }}</span>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold text-dark mb-0 pe-3" style="max-width: 500px">
                        {{ item.question_text }}
                      </p>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-light text-dark" style="font-size: 11px">
                        {{ item.response_type === 'likert' ? 'Likert 1-5' : item.response_type }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-sm text-secondary">{{ item.choices ? item.choices.length : 0 }}</span>
                    </td>
                    <td class="text-center">
                      <button class="btn btn-link text-primary p-1 mb-0" @click="openEditQuestionModal(item)" title="Editar">
                        <i class="material-icons" style="font-size: 20px">edit</i>
                      </button>
                      <button class="btn btn-link text-danger p-1 mb-0" @click="deleteQuestion(item)" title="Eliminar">
                        <i class="material-icons" style="font-size: 20px">delete</i>
                      </button>
                    </td>
                  </tr>
                  <tr v-if="items.length === 0">
                    <td colspan="5" class="text-center p-5">
                      <i class="material-icons text-secondary" style="font-size: 48px">help_outline</i>
                      <h6 class="text-secondary mt-2">No hay preguntas. Agrega la primera.</h6>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB: Stats -->
      <template v-if="activeTab === 'stats'">
        <div class="col-xl-3 col-sm-6 mb-4">
          <div class="card shadow-lg border-0 premium-card">
            <div class="card-body p-3">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-gradient-primary me-3">
                  <i class="material-icons text-white">people</i>
                </div>
                <div>
                  <p class="text-sm text-secondary mb-0">Total Respuestas</p>
                  <h4 class="font-weight-bolder mb-0">{{ stats.total }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
          <div class="card shadow-lg border-0 premium-card">
            <div class="card-body p-3">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-gradient-info me-3">
                  <i class="material-icons text-white">analytics</i>
                </div>
                <div>
                  <p class="text-sm text-secondary mb-0">Promedio Score</p>
                  <h4 class="font-weight-bolder mb-0">{{ stats.avg_score }} <small class="text-sm text-secondary">/ {{ maxScore }}</small></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-sm-4 mb-4">
          <div class="card shadow-lg border-0 premium-card">
            <div class="card-body p-3 text-center">
              <i class="material-icons text-success" style="font-size: 28px">sentiment_satisfied</i>
              <h5 class="font-weight-bolder mb-0 mt-1">{{ stats.distribution.bien }}</h5>
              <p class="text-xs text-secondary mb-0">Bien</p>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-sm-4 mb-4">
          <div class="card shadow-lg border-0 premium-card">
            <div class="card-body p-3 text-center">
              <i class="material-icons text-warning" style="font-size: 28px">sentiment_neutral</i>
              <h5 class="font-weight-bolder mb-0 mt-1">{{ stats.distribution.atencion }}</h5>
              <p class="text-xs text-secondary mb-0">Atención</p>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-sm-4 mb-4">
          <div class="card shadow-lg border-0 premium-card">
            <div class="card-body p-3 text-center">
              <i class="material-icons text-danger" style="font-size: 28px">sentiment_very_dissatisfied</i>
              <h5 class="font-weight-bolder mb-0 mt-1">{{ stats.distribution.prioridad }}</h5>
              <p class="text-xs text-secondary mb-0">Prioridad</p>
            </div>
          </div>
        </div>
      </template>

      <!-- TAB: Responses -->
      <div class="col-12 mb-4" v-if="activeTab === 'responses'">
        <div class="card shadow-lg border-0 premium-card">
          <div class="card-header pb-0 bg-transparent border-0">
            <h5 class="font-weight-bolder text-dark mb-0">
              <i class="material-icons text-primary me-1" style="font-size: 22px; vertical-align: middle">assignment</i>
              Historial de Respuestas
            </h5>
            <p class="text-sm text-secondary mb-0">Todas las respuestas recibidas del Test Rápido</p>
          </div>
          <div class="card-body px-0 pt-3 pb-2">
            <div v-if="loadingStats" class="text-center p-4">
              <div class="spinner-border spinner-border-sm text-primary"></div>
            </div>
            <div v-else class="table-responsive p-0" style="max-height: 50vh; overflow-y: auto">
              <table class="table align-items-center mb-0 table-hover premium-table">
                <thead class="bg-light">
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Puntaje</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nivel</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="r in stats.responses" :key="r.id" class="table-row">
                    <td class="ps-4">
                      <span class="text-sm font-weight-bold">#{{ r.id }}</span>
                    </td>
                    <td class="text-center">
                      <span class="text-sm font-weight-bold">{{ r.summary_score }} / {{ maxScore }}</span>
                    </td>
                    <td class="text-center">
                      <span class="badge" :class="`bg-gradient-${getLevel(r.summary_score).color}`" style="font-size: 11px">
                        <i class="material-icons me-1" style="font-size: 13px; vertical-align: middle">{{ getLevel(r.summary_score).icon }}</i>
                        {{ getLevel(r.summary_score).text }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs">{{ formatDate(r.submitted_at) }}</span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs">{{ r.user_id ? `#${r.user_id}` : "Anónimo" }}</span>
                    </td>
                  </tr>
                  <tr v-if="stats.responses.length === 0">
                    <td colspan="5" class="text-center p-5">
                      <i class="material-icons text-secondary" style="font-size: 48px">inbox</i>
                      <h6 class="text-secondary mt-2">Aún no hay respuestas registradas.</h6>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </template>

    <!-- Modal para Agregar/Editar Pregunta -->
    <div v-if="showQuestionModal" class="custom-modal-overlay d-flex align-items-center justify-content-center fade-in">
      <div class="custom-modal-card card shadow-lg border-0 w-100" style="max-width: 600px;">
        <div class="card-header bg-gradient-primary p-3 d-flex justify-content-between align-items-center">
          <h5 class="text-white mb-0">{{ editingQuestion.id ? 'Editar Pregunta' : 'Nueva Pregunta' }}</h5>
          <button class="btn-close btn-close-white" @click="closeQuestionModal"></button>
        </div>
        <div class="card-body p-4" style="max-height: 70vh; overflow-y: auto;">
          <!-- Texto de la pregunta -->
          <div class="mb-3">
            <label class="form-label text-dark font-weight-bold">Texto de la pregunta</label>
            <textarea class="form-control border px-3 py-2" v-model="editingQuestion.question_text" rows="3" placeholder="Escribe aquí la pregunta..."></textarea>
          </div>
          
          <!-- Tipo de respuesta -->
          <div class="mb-3">
            <label class="form-label text-dark font-weight-bold">Tipo de Respuesta</label>
            <select class="form-select border px-3 py-2" v-model="editingQuestion.response_type">
              <option value="likert">Escala Likert (Opciones con puntaje)</option>
              <option value="opcion">Opción Múltiple (Radio buttons)</option>
              <option value="texto">Texto Abierto</option>
              <option value="numero">Número</option>
              <option value="booleano">Booleano (Sí/No)</option>
            </select>
          </div>

          <!-- Opciones dinámicas (solo para likert o opcion) -->
          <div v-if="['likert', 'opcion'].includes(editingQuestion.response_type)">
            <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
              <label class="form-label text-dark font-weight-bold mb-0">Opciones de Respuesta</label>
              <button class="btn btn-sm btn-outline-primary mb-0 py-1 px-2" @click="addChoice">
                <i class="material-icons" style="font-size: 14px; vertical-align: middle;">add</i> Agregar Opción
              </button>
            </div>
            
            <div v-for="(choice, index) in editingQuestion.choices" :key="index" class="d-flex gap-2 mb-2 align-items-center bg-light p-2 rounded">
              <span class="text-secondary font-weight-bold" style="width: 20px;">{{ index + 1 }}.</span>
              <input type="text" class="form-control border px-2 py-1 bg-white" placeholder="Etiqueta (Ej. Casi siempre)" v-model="choice.label">
              <input type="text" class="form-control border px-2 py-1 bg-white" placeholder="Valor (Ej. 4)" v-model="choice.value" style="width: 100px;">
              <button class="btn btn-link text-danger mb-0 p-1" @click="removeChoice(index)">
                <i class="material-icons">delete</i>
              </button>
            </div>
            
            <p v-if="editingQuestion.choices.length === 0" class="text-sm text-danger mt-2">
              Debes agregar al menos una opción.
            </p>
          </div>
        </div>
        <div class="card-footer bg-light p-3 d-flex justify-content-end gap-2">
          <button class="btn btn-outline-secondary mb-0" @click="closeQuestionModal">Cancelar</button>
          <button class="btn bg-gradient-primary mb-0" @click="saveQuestion">Guardar Cambios</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.fade-in { animation: fadeIn 0.6s ease-out; }
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}
.test-header {
  background: linear-gradient(135deg, #0077b6 0%, #00b4d8 40%, #48cae4 100%);
  padding: 28px 30px;
  position: relative; overflow: hidden;
}
.test-header::before {
  content: ''; position: absolute; top: -50%; right: -20%;
  width: 300px; height: 300px; background: rgba(255,255,255,0.08); border-radius: 50%;
}
.header-content { position: relative; z-index: 2; }
.header-icon-wrapper {
  width: 60px; height: 60px; background: rgba(255,255,255,0.15);
  border-radius: 16px; display: flex; align-items: center; justify-content: center;
  backdrop-filter: blur(8px);
}
.premium-card {
  background: rgba(255,255,255,0.9) !important; backdrop-filter: blur(10px); border-radius: 20px;
}
.bg-gradient-primary { background: linear-gradient(135deg, #00b4d8, #0077b6) !important; }
.bg-gradient-info { background: linear-gradient(135deg, #48cae4, #00b4d8) !important; }
.shadow-primary { box-shadow: 0 4px 15px rgba(0,119,182,0.35) !important; }
.text-white-50 { color: rgba(255,255,255,0.65) !important; }
.question-number {
  width: 32px; height: 32px; background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
  border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
  font-weight: 800; font-size: 13px; color: #0077b6;
}
.stat-icon {
  width: 48px; height: 48px; border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
}
.premium-table tbody tr { transition: all 0.3s ease; }
.premium-table tbody tr:hover {
  background-color: rgba(0,180,216,0.05); transform: scale(1.01);
  box-shadow: 0 4px 15px rgba(0,180,216,0.1); border-radius: 10px;
}
.premium-table td { border-bottom: 1px solid rgba(0,0,0,0.03); }
.hover-scale { transition: transform 0.2s; }
.hover-scale:hover { transform: scale(1.05); }

/* Modal Custom Styles */
.custom-modal-overlay {
  position: fixed;
  top: 0; left: 0; width: 100vw; height: 100vh;
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(4px);
  z-index: 1050;
}
.custom-modal-card {
  border-radius: 12px;
  overflow: hidden;
}
.form-select {
  appearance: auto;
}
</style>
