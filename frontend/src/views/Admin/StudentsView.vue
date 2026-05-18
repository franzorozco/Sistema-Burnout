<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import MaterialBadge from "@/components/MaterialBadge.vue";
import Swal from 'sweetalert2';

const students = ref([]);
const filteredStudents = ref([]);
const loading = ref(true);
const searchQuery = ref('');

const filterTable = () => {
  const query = searchQuery.value.toLowerCase();
  filteredStudents.value = students.value.filter(student => {
    const name = student.user ? String(student.user.name).toLowerCase() : '';
    const email = student.user ? String(student.user.email).toLowerCase() : '';
    const matricula = student.enrollment_number ? String(student.enrollment_number).toLowerCase() : '';
    const semester = student.current_semester ? String(student.current_semester).toLowerCase() : '';
    return name.includes(query) || email.includes(query) || matricula.includes(query) || semester.includes(query);
  });
};

onMounted(async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await axios.get("/api/students", {
      headers: { Authorization: `Bearer ${token}` }
    });
    students.value = res.data.data;
    filteredStudents.value = res.data.data;
  } catch (error) {
    console.error("Error cargando estudiantes:", error);
    Swal.fire('Error', 'No se pudo cargar la lista de estudiantes', 'error');
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="row fade-in">
    <div class="col-12">
      <div class="card mb-4 shadow-lg border-0 premium-table-card">
        <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="font-weight-bolder text-info mb-0">Gestión de Estudiantes</h5>
            <p class="text-sm text-secondary mb-0">
              Alumnos matriculados bajo monitoreo de salud mental.
            </p>
          </div>
          <div class="pe-md-3 d-flex align-items-center">
            <button class="btn bg-gradient-info shadow-info me-3 hover-scale mb-0">
              <i class="material-icons text-white me-1" style="font-size: 14px;">person_add</i> Registrar
            </button>
            <div class="input-group input-group-outline bg-white border-radius-md" style="width: 280px;">
              <input type="text" class="form-control" placeholder="Buscar por nombre, semestre..." v-model="searchQuery" @input="filterTable">
            </div>
          </div>
        </div>
        <div class="card-body px-0 pt-3 pb-2">
          <div v-if="loading" class="text-center p-5">
            <div class="spinner-border text-info" role="status"></div>
          </div>
          <div v-else class="table-responsive p-0" style="max-height: 65vh; overflow-y: auto;">
            <table class="table align-items-center mb-0 table-hover premium-table">
              <thead class="bg-light">
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estudiante</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Matrícula</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Semestre Actual</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Consentimiento Informado</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="student in filteredStudents" :key="student.id" class="table-row">
                  <td>
                    <div class="d-flex px-3 py-1">
                      <div>
                        <img :src="`https://ui-avatars.com/api/?name=${student.user ? student.user.name : 'St'}&background=e1f5fe&color=0288D1`" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm font-weight-bold">{{ student.user ? student.user.name : 'Usuario Desconocido' }}</h6>
                        <p class="text-xs text-secondary mb-0">{{ student.user ? student.user.email : 'Sin correo' }}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs text-dark mb-0 font-weight-bold">{{ student.enrollment_number || 'N/A' }}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-secondary text-xs font-weight-bold">{{ student.current_semester || 'N/A' }} Semestre</span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <MaterialBadge :color="student.has_informed_consent ? 'success' : 'warning'">
                      {{ student.has_informed_consent ? 'Firmado' : 'Pendiente' }}
                    </MaterialBadge>
                  </td>
                  <td class="align-middle text-center">
                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs hover-text-info mx-2" data-toggle="tooltip" data-original-title="Ver historial">
                      Ver Historial
                    </a>
                  </td>
                </tr>
                <tr v-if="filteredStudents.length === 0">
                  <td colspan="5" class="text-center p-5">
                    <i class="material-icons text-secondary fs-1 mb-3">search_off</i>
                    <h6 class="text-secondary">No se encontraron estudiantes.</h6>
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
  background-color: rgba(3, 169, 244, 0.05); /* Efecto azul para estudiantes */
  transform: scale(1.01);
  box-shadow: 0 4px 15px rgba(3, 169, 244, 0.1);
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

.hover-text-info:hover {
  color: #03A9F4 !important;
}
</style>
