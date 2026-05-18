<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import MaterialBadge from "@/components/MaterialBadge.vue";
import Swal from 'sweetalert2';

const appointments = ref([]);
const filteredAppointments = ref([]);
const students = ref([]);
const professionals = ref([]);
const loading = ref(true);
const searchQuery = ref('');

const filterTable = () => {
  const query = searchQuery.value.toLowerCase();
  filteredAppointments.value = appointments.value.filter(apt => {
    const student = apt.student_profile && apt.student_profile.user ? String(apt.student_profile.user.name).toLowerCase() : '';
    const doctor = apt.professional && apt.professional.user ? String(apt.professional.user.name).toLowerCase() : '';
    const status = apt.status ? String(apt.status).toLowerCase() : '';
    return student.includes(query) || doctor.includes(query) || status.includes(query);
  });
};

const loadAppointments = async () => {
  loading.value = true;
  try {
    const token = localStorage.getItem('token');
    
    // Ejecutar las peticiones en paralelo
    const [aptRes, stdRes, profRes] = await Promise.all([
      axios.get("/api/appointments", { headers: { Authorization: `Bearer ${token}` } }),
      axios.get("/api/students", { headers: { Authorization: `Bearer ${token}` } }),
      axios.get("/api/professionals", { headers: { Authorization: `Bearer ${token}` } })
    ]);
    
    appointments.value = aptRes.data.data;
    filteredAppointments.value = aptRes.data.data;
    students.value = stdRes.data.data;
    professionals.value = profRes.data.data;
  } catch (error) {
    console.error("Error cargando citas:", error);
    Swal.fire('Error', 'No se pudieron cargar las citas', 'error');
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  loadAppointments();
});

const agendarCita = async () => {
  // Construir opciones HTML para los selects
  const studentOptions = students.value.map(s => `<option value="${s.id}">${s.user ? s.user.name : 'ID '+s.id}</option>`).join('');
  const profOptions = professionals.value.map(p => `<option value="${p.id}">${p.user ? p.user.name : 'ID '+p.id}</option>`).join('');

  const { value: formValues } = await Swal.fire({
    title: 'Agendar Nueva Cita',
    html: `
      <div style="text-align: left; margin-bottom: 10px;">
        <label>Paciente:</label>
        <select id="swal-student" class="swal2-select" style="width: 100%; margin: 0; padding: .375rem .75rem;">
          ${studentOptions}
        </select>
      </div>
      <div style="text-align: left; margin-bottom: 10px;">
        <label>Psicólogo/Doctor:</label>
        <select id="swal-prof" class="swal2-select" style="width: 100%; margin: 0; padding: .375rem .75rem;">
          ${profOptions}
        </select>
      </div>
      <div style="text-align: left; margin-bottom: 10px;">
        <label>Fecha y Hora:</label>
        <input type="datetime-local" id="swal-date" class="swal2-input" style="width: 100%; margin: 0;">
      </div>
      <div style="text-align: left;">
        <label>Notas Iniciales (opcional):</label>
        <input type="text" id="swal-notes" class="swal2-input" placeholder="Motivo de consulta..." style="width: 100%; margin: 0;">
      </div>
    `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: 'Agendar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#FF9800',
    preConfirm: () => {
      const studentId = document.getElementById('swal-student').value;
      const profId = document.getElementById('swal-prof').value;
      const date = document.getElementById('swal-date').value;
      const notes = document.getElementById('swal-notes').value;
      
      if (!studentId || !profId || !date) {
        Swal.showValidationMessage('Todos los campos excepto las notas son obligatorios');
        return false;
      }
      return { 
        student_profile_id: studentId, 
        professional_id: profId, 
        scheduled_at: date, 
        notes: notes 
      };
    }
  });

  if (formValues) {
    try {
      const token = localStorage.getItem('token');
      await axios.post('/api/appointments', formValues, {
        headers: { Authorization: `Bearer ${token}` }
      });
      Swal.fire('¡Éxito!', 'Cita médica agendada correctamente', 'success');
      loadAppointments(); // Recargar tabla
    } catch (error) {
      Swal.fire('Error', 'Hubo un problema al agendar la cita', 'error');
    }
  }
};

const getStatusColor = (status) => {
  if (!status) return 'secondary';
  const st = String(status).toLowerCase();
  if (st === 'pendiente') return 'warning';
  if (st === 'confirmado') return 'info';
  if (st === 'completado') return 'success';
  if (st === 'cancelado' || st === 'no_asistio') return 'danger';
  return 'secondary';
};
</script>

<template>
  <div class="row fade-in">
    <div class="col-12">
      <div class="card mb-4 shadow-lg border-0 premium-table-card">
        <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="font-weight-bolder text-warning mb-0">Gestión de Citas Médicas <i class="material-icons text-warning ms-1" style="font-size: 20px; vertical-align: middle;">event_note</i></h5>
            <p class="text-sm text-secondary mb-0">
              Agenda de consultas psicológicas.
            </p>
          </div>
          <div class="pe-md-3 d-flex align-items-center">
            <button class="btn bg-gradient-warning shadow-warning me-3 hover-scale mb-0" @click="agendarCita">
              <i class="material-icons text-white me-1" style="font-size: 14px;">add_alarm</i> Agendar
            </button>
            <div class="input-group input-group-outline bg-white border-radius-md" style="width: 250px;">
              <input type="text" class="form-control" placeholder="Buscar por paciente..." v-model="searchQuery" @input="filterTable">
            </div>
          </div>
        </div>
        <div class="card-body px-0 pt-3 pb-2">
          <div v-if="loading" class="text-center p-5">
            <div class="spinner-border text-warning" role="status"></div>
          </div>
          <div v-else class="table-responsive p-0" style="max-height: 65vh; overflow-y: auto;">
            <table class="table align-items-center mb-0 table-hover premium-table">
              <thead class="bg-light">
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Paciente</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Doctor Asignado</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha y Hora</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="apt in filteredAppointments" :key="apt.id" class="table-row">
                  <td>
                    <div class="d-flex px-3 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm font-weight-bold">{{ apt.student_profile && apt.student_profile.user ? apt.student_profile.user.name : 'Usuario Desconocido' }}</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs text-dark mb-0 font-weight-bold"><i class="material-icons text-secondary me-1" style="font-size: 14px; vertical-align: middle;">medical_services</i> {{ apt.professional && apt.professional.user ? apt.professional.user.name : 'Sin asignar' }}</p>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ new Date(apt.scheduled_at).toLocaleString() }}
                    </span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <MaterialBadge :color="getStatusColor(apt.status)">
                      {{ apt.status ? String(apt.status).toUpperCase() : 'NO DEFINIDO' }}
                    </MaterialBadge>
                  </td>
                  <td class="align-middle text-center">
                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs hover-text-warning mx-2">
                      Gestionar
                    </a>
                  </td>
                </tr>
                <tr v-if="filteredAppointments.length === 0">
                  <td colspan="5" class="text-center p-5">
                    <i class="material-icons text-secondary fs-1 mb-3">event_busy</i>
                    <h6 class="text-secondary">No hay citas registradas.</h6>
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

.premium-table tbody tr:hover {
  background-color: rgba(255, 152, 0, 0.05); /* Efecto naranja */
  transform: scale(1.01);
  box-shadow: 0 4px 15px rgba(255, 152, 0, 0.1);
  border-radius: 10px;
}

.premium-table td {
  border-bottom: 1px solid rgba(0,0,0,0.03);
}

.hover-scale {
  transition: transform 0.2s;
}
.hover-scale:hover {
  transform: scale(1.05);
}

.hover-text-warning:hover {
  color: #FF9800 !important;
}
</style>
