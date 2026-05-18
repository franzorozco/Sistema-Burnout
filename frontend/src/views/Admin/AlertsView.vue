<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import MaterialBadge from "@/components/MaterialBadge.vue";
import Swal from 'sweetalert2';

const alerts = ref([]);
const filteredAlerts = ref([]);
const loading = ref(true);
const searchQuery = ref('');

const filterTable = () => {
  const query = searchQuery.value.toLowerCase();
  filteredAlerts.value = alerts.value.filter(alert => {
    const name = alert.user ? String(alert.user.name).toLowerCase() : '';
    const risk = alert.risk_level ? String(alert.risk_level).toLowerCase() : '';
    const desc = alert.description ? String(alert.description).toLowerCase() : '';
    return name.includes(query) || risk.includes(query) || desc.includes(query);
  });
};

onMounted(async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await axios.get("/api/alerts", {
      headers: { Authorization: `Bearer ${token}` }
    });
    
    // Ordenar alertas por prioridad de riesgo (Más urgente primero)
    const riskPriority = {
      'riesgo_extremo': 4,
      'riesgo_alto': 3,
      'riesgo_moderado': 2,
      'riesgo_leve': 1
    };
    
    let fetchedAlerts = res.data.data || [];
    fetchedAlerts.sort((a, b) => {
      const riskA = riskPriority[String(a.risk_level).toLowerCase()] || 0;
      const riskB = riskPriority[String(b.risk_level).toLowerCase()] || 0;
      if (riskA !== riskB) {
        return riskB - riskA; // Mayor riesgo arriba
      }
      return new Date(b.created_at) - new Date(a.created_at); // Si empatan, el más nuevo arriba
    });

    alerts.value = fetchedAlerts;
    filteredAlerts.value = fetchedAlerts;
  } catch (error) {
    console.error("Error cargando alertas:", error);
    Swal.fire('Error', 'No se pudieron cargar las alertas', 'error');
  } finally {
    loading.value = false;
  }
});

const getRiskColor = (risk) => {
  if (!risk || String(risk).toLowerCase().includes('no_definido') || String(risk) === 'null') return 'secondary';
  const riskStr = String(risk).toLowerCase();
  if (riskStr.includes('extremo') || riskStr.includes('alto')) return 'danger';
  if (riskStr.includes('moderado')) return 'warning';
  if (riskStr.includes('leve')) return 'info';
  return 'secondary';
};

const getRowClass = (risk) => {
  const color = getRiskColor(risk);
  if (color === 'danger') return 'row-danger';
  if (color === 'warning') return 'row-warning';
  return 'row-normal';
};
</script>

<template>
  <div class="row fade-in">
    <div class="col-12">
      <div class="card mb-4 shadow-lg border-0 premium-table-card">
        <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="font-weight-bolder text-danger mb-0">Alertas de Riesgo <i class="material-icons text-danger ms-1" style="font-size: 20px; vertical-align: middle;">notifications_active</i></h5>
            <p class="text-sm text-secondary mb-0">
              Notificaciones urgentes generadas por el comportamiento de los estudiantes.
            </p>
          </div>
          <div class="pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline bg-white border-radius-md" style="width: 250px;">
              <input type="text" class="form-control" placeholder="Buscar por nombre o nivel..." v-model="searchQuery" @input="filterTable">
            </div>
          </div>
        </div>
        <div class="card-body px-0 pt-3 pb-2">
          <div v-if="loading" class="text-center p-5">
            <div class="spinner-border text-danger" role="status"></div>
          </div>
          <div v-else class="table-responsive p-0" style="max-height: 65vh; overflow-y: auto;">
            <table class="table align-items-center mb-0 table-hover premium-table">
              <thead class="bg-light">
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estudiante Afectado</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nivel de Alerta</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripción</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Detección</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="alert in filteredAlerts" :key="alert.id" :class="['table-row', getRowClass(alert.risk_level)]">
                  <td>
                    <div class="d-flex px-3 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm font-weight-bold">{{ alert.user ? alert.user.name : 'Usuario Desconocido' }}</h6>
                        <p class="text-xs text-secondary mb-0">{{ alert.user ? alert.user.email : 'Sin correo' }}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <MaterialBadge :color="getRiskColor(alert.risk_level)">
                      {{ alert.risk_level ? String(alert.risk_level).replace('_', ' ').toUpperCase() : 'NO DEFINIDO' }}
                    </MaterialBadge>
                  </td>
                  <td style="max-width: 300px; white-space: normal;">
                    <p class="text-xs text-dark mb-0"><i class="material-icons text-danger me-1" style="font-size: 14px; vertical-align: middle;">error_outline</i> {{ alert.description || 'Alerta generada automáticamente por Laiso.' }}</p>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ new Date(alert.created_at).toLocaleString() }}
                    </span>
                  </td>
                  <td class="align-middle text-center">
                    <button class="btn btn-sm btn-outline-danger mb-0">Atender Alerta</button>
                  </td>
                </tr>
                <tr v-if="filteredAlerts.length === 0">
                  <td colspan="5" class="text-center p-5">
                    <i class="material-icons text-success fs-1 mb-3">check_circle</i>
                    <h6 class="text-success">¡Todo está tranquilo! No hay alertas de riesgo.</h6>
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
}

.premium-table tbody tr.row-danger:hover {
  background-color: rgba(244, 67, 54, 0.08);
  transform: scale(1.01);
  box-shadow: 0 4px 15px rgba(244, 67, 54, 0.15);
  border-radius: 10px;
}

.premium-table tbody tr.row-warning:hover {
  background-color: rgba(255, 152, 0, 0.08);
  transform: scale(1.01);
  box-shadow: 0 4px 15px rgba(255, 152, 0, 0.15);
  border-radius: 10px;
}

.premium-table tbody tr.row-normal:hover {
  background-color: rgba(158, 158, 158, 0.08);
  transform: scale(1.01);
  box-shadow: 0 4px 15px rgba(158, 158, 158, 0.1);
  border-radius: 10px;
}

.premium-table td {
  border-bottom: 1px solid rgba(0,0,0,0.03);
}
</style>
