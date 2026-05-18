<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import MaterialBadge from "@/components/MaterialBadge.vue";
import Swal from 'sweetalert2';

const interactions = ref([]);
const filteredInteractions = ref([]);
const loading = ref(true);
const searchQuery = ref('');

const filterTable = () => {
  const query = searchQuery.value.toLowerCase();
  filteredInteractions.value = interactions.value.filter(interaction => {
    const studentName = interaction.user ? String(interaction.user.name).toLowerCase() : 'usuario anónimo';
    const message = interaction.input_text ? String(interaction.input_text).toLowerCase() : '';
    const risk = interaction.detected_risk ? String(interaction.detected_risk).toLowerCase() : '';
    return studentName.includes(query) || message.includes(query) || risk.includes(query);
  });
};

onMounted(async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await axios.get("/api/chatbot-interactions", {
      headers: { Authorization: `Bearer ${token}` }
    });
    interactions.value = res.data.data; // Paginación
    filteredInteractions.value = res.data.data;
  } catch (error) {
    console.error("Error cargando interacciones:", error);
    Swal.fire('Error', 'No se pudo cargar el historial del Chatbot', 'error');
  } finally {
    loading.value = false;
  }
});

const getRiskColor = (risk) => {
  switch(risk) {
    case 'riesgo_alto':
    case 'riesgo_extremo': return 'danger';
    case 'riesgo_moderado': return 'warning';
    case 'riesgo_leve': return 'info';
    default: return 'success';
  }
};
</script>

<template>
  <div class="row fade-in">
    <div class="col-12">
      <div class="card mb-4 shadow-lg border-0 premium-table-card">
        <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="font-weight-bolder text-dark mb-0">Historial de Laiso</h5>
            <p class="text-sm text-secondary mb-0">
              Monitoreo en tiempo real de interacciones y riesgos.
            </p>
          </div>
          <div class="pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline bg-white border-radius-md" style="width: 250px;">
              <input type="text" class="form-control" placeholder="Buscar estudiante o riesgo..." v-model="searchQuery" @input="filterTable">
            </div>
          </div>
        </div>
        <div class="card-body px-0 pt-3 pb-2">
          <div v-if="loading" class="text-center p-5">
            <div class="spinner-border text-success" role="status"></div>
          </div>
          <div v-else class="table-responsive p-0" style="max-height: 65vh; overflow-y: auto;">
            <table class="table align-items-center mb-0 table-hover premium-table">
              <thead class="bg-light">
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estudiante</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mensaje Original</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Respuesta Laiso</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Riesgo Detectado</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="interaction in filteredInteractions" :key="interaction.id" class="table-row">
                  <td>
                    <div class="d-flex px-3 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm font-weight-bold">{{ interaction.user ? interaction.user.name : 'Usuario Anónimo' }}</h6>
                        <p class="text-xs text-secondary mb-0">{{ interaction.user ? interaction.user.email : 'Sin correo' }}</p>
                      </div>
                    </div>
                  </td>
                  <td style="max-width: 250px; white-space: normal;">
                    <p class="text-xs text-dark mb-0 font-weight-bold">"{{ interaction.input_text }}"</p>
                  </td>
                  <td style="max-width: 300px; white-space: normal;">
                    <p class="text-xs text-secondary mb-0">{{ interaction.response_text }}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <MaterialBadge :color="getRiskColor(interaction.detected_risk)">
                      {{ interaction.detected_risk ? String(interaction.detected_risk).replace('_', ' ').toUpperCase() : 'NO DEFINIDO' }}
                    </MaterialBadge>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ new Date(interaction.created_at).toLocaleString() }}
                    </span>
                  </td>
                </tr>
                <tr v-if="filteredInteractions.length === 0">
                  <td colspan="5" class="text-center p-5">
                    <i class="material-icons text-secondary fs-1 mb-3">search_off</i>
                    <h6 class="text-secondary">No se encontraron interacciones.</h6>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.fade-in {
  animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}

.premium-table-card {
  background: rgba(255, 255, 255, 0.9) !important;
  backdrop-filter: blur(10px);
  border-radius: 20px;
}

.premium-table tbody tr {
  transition: all 0.3s ease;
  cursor: pointer;
}

.premium-table tbody tr:hover {
  background-color: rgba(76, 175, 80, 0.05);
  transform: scale(1.01);
  box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  border-radius: 10px;
}

.premium-table td {
  border-bottom: 1px solid rgba(0,0,0,0.03);
}
</style>
