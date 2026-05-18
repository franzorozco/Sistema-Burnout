<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import MaterialBadge from "@/components/MaterialBadge.vue";
import Swal from 'sweetalert2';

const professionals = ref([]);
const filteredProfessionals = ref([]);
const loading = ref(true);
const searchQuery = ref('');

const filterTable = () => {
  const query = searchQuery.value.toLowerCase();
  filteredProfessionals.value = professionals.value.filter(prof => {
    const name = prof.user ? String(prof.user.name).toLowerCase() : '';
    const email = prof.user ? String(prof.user.email).toLowerCase() : '';
    const specialty = prof.specialty ? String(prof.specialty).toLowerCase() : '';
    return name.includes(query) || email.includes(query) || specialty.includes(query);
  });
};

onMounted(async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await axios.get("/api/professionals", {
      headers: { Authorization: `Bearer ${token}` }
    });
    professionals.value = res.data.data;
    filteredProfessionals.value = res.data.data;
  } catch (error) {
    console.error("Error cargando doctores:", error);
    Swal.fire('Error', 'No se pudo cargar la lista de doctores', 'error');
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
            <h5 class="font-weight-bolder text-dark mb-0">Directorio de Doctores</h5>
            <p class="text-sm text-secondary mb-0">
              Psicólogos y psiquiatras registrados en el sistema.
            </p>
          </div>
          <div class="pe-md-3 d-flex align-items-center">
            <button class="btn bg-gradient-success shadow-success me-3 hover-scale mb-0">
              <i class="material-icons text-white me-1" style="font-size: 14px;">add</i> Nuevo
            </button>
            <div class="input-group input-group-outline bg-white border-radius-md" style="width: 250px;">
              <input type="text" class="form-control" placeholder="Buscar por nombre o especialidad..." v-model="searchQuery" @input="filterTable">
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Doctor</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Especialidad</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Experiencia</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="prof in filteredProfessionals" :key="prof.id" class="table-row">
                  <td>
                    <div class="d-flex px-3 py-1">
                      <div>
                        <img :src="`https://ui-avatars.com/api/?name=${prof.user ? prof.user.name : 'Doc'}&background=e8f5e9&color=2E7D32`" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm font-weight-bold">{{ prof.user ? prof.user.name : 'Usuario Desconocido' }}</h6>
                        <p class="text-xs text-secondary mb-0">{{ prof.user ? prof.user.email : 'Sin correo' }}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs text-dark mb-0 font-weight-bold">{{ prof.specialty || 'Psicología General' }}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-secondary text-xs font-weight-bold">{{ prof.years_experience || 0 }} años</span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <MaterialBadge :color="prof.user && prof.user.is_active ? 'success' : 'secondary'">
                      {{ prof.user && prof.user.is_active ? 'Activo' : 'Inactivo' }}
                    </MaterialBadge>
                  </td>
                  <td class="align-middle text-center">
                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs hover-text-success mx-2" data-toggle="tooltip" data-original-title="Edit user">
                      Editar
                    </a>
                    <a href="javascript:;" class="text-danger font-weight-bold text-xs hover-text-danger mx-2" data-toggle="tooltip" data-original-title="Delete user">
                      Eliminar
                    </a>
                  </td>
                </tr>
                <tr v-if="filteredProfessionals.length === 0">
                  <td colspan="5" class="text-center p-5">
                    <i class="material-icons text-secondary fs-1 mb-3">search_off</i>
                    <h6 class="text-secondary">No se encontraron doctores registrados.</h6>
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

.hover-scale {
  transition: transform 0.2s;
}
.hover-scale:hover {
  transform: scale(1.05);
}

.hover-text-success:hover {
  color: #4CAF50 !important;
}
.hover-text-danger:hover {
  color: #F44336 !important;
}
</style>
