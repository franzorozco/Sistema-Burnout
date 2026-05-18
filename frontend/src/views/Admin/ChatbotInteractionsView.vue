<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import MaterialBadge from "@/components/MaterialBadge.vue";
import Swal from 'sweetalert2';

const interactions = ref([]);
const loading = ref(true);

onMounted(async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await axios.get("/api/chatbot-interactions", {
      headers: { Authorization: `Bearer ${token}` }
    });
    interactions.value = res.data.data; // Paginación
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
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm border-0">
        <div class="card-header pb-0 bg-white">
          <h6>Historial de Conversaciones (Laiso)</h6>
          <p class="text-sm text-secondary">
            Aquí puedes monitorear de qué hablan los estudiantes con el asistente virtual para detectar factores de burnout.
          </p>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div v-if="loading" class="text-center p-5">
            <div class="spinner-border text-success" role="status"></div>
          </div>
          <div v-else class="table-responsive p-0" style="max-height: 70vh; overflow-y: auto;">
            <table class="table align-items-center mb-0 table-hover">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estudiante</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mensaje Original</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Respuesta Laiso</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Riesgo Detectado</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="interaction in interactions" :key="interaction.id">
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
                <tr v-if="interactions.length === 0">
                  <td colspan="5" class="text-center p-4">No hay interacciones registradas aún.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
