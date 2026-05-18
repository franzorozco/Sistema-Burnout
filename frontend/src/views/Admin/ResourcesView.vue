<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import MaterialBadge from "@/components/MaterialBadge.vue";
import Swal from 'sweetalert2';

const resources = ref([]);
const filteredResources = ref([]);
const loading = ref(true);
const searchQuery = ref('');

const filterTable = () => {
  const query = searchQuery.value.toLowerCase();
  filteredResources.value = resources.value.filter(res => {
    const title = res.title ? String(res.title).toLowerCase() : '';
    const type = res.resource_type ? String(res.resource_type).toLowerCase() : '';
    return title.includes(query) || type.includes(query);
  });
};

const loadResources = async () => {
  loading.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await axios.get("/api/resources", {
      headers: { Authorization: `Bearer ${token}` }
    });
    resources.value = res.data.data;
    filteredResources.value = res.data.data;
  } catch (error) {
    console.error("Error cargando recursos:", error);
    Swal.fire('Error', 'No se pudieron cargar los recursos de apoyo', 'error');
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  loadResources();
});

const uploadMaterial = async () => {
  const { value: formValues } = await Swal.fire({
    title: 'Subir Nuevo Material',
    html: `
      <input id="swal-title" class="swal2-input" placeholder="Título del recurso">
      <input id="swal-desc" class="swal2-input" placeholder="Breve descripción">
      <select id="swal-type" class="swal2-select" style="width: 270px; margin: 1em auto; padding: .375rem .75rem;">
        <option value="documento">Documento / PDF</option>
        <option value="video">Video</option>
        <option value="audio">Audio / Podcast</option>
        <option value="enlace">Enlace Web</option>
      </select>
      <input id="swal-url" class="swal2-input" placeholder="URL (ej: https://...)">
    `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: 'Subir Material',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#E91E63',
    preConfirm: () => {
      const title = document.getElementById('swal-title').value;
      const desc = document.getElementById('swal-desc').value;
      const type = document.getElementById('swal-type').value;
      const url = document.getElementById('swal-url').value;
      
      if (!title || !url) {
        Swal.showValidationMessage('El título y la URL son obligatorios');
        return false;
      }
      return { title, description: desc, resource_type: type, content_url: url };
    }
  });

  if (formValues) {
    try {
      const token = localStorage.getItem('token');
      await axios.post('/api/resources', formValues, {
        headers: { Authorization: `Bearer ${token}` }
      });
      Swal.fire('¡Éxito!', 'Material subido correctamente', 'success');
      loadResources(); // Recargar la tabla
    } catch (error) {
      Swal.fire('Error', 'Hubo un problema al subir el material', 'error');
    }
  }
};

const getTypeIcon = (type) => {
  if (!type) return 'article';
  const t = String(type).toLowerCase();
  if (t === 'video') return 'ondemand_video';
  if (t === 'audio' || t === 'podcast') return 'headphones';
  if (t === 'documento' || t === 'pdf') return 'picture_as_pdf';
  return 'article';
};
</script>

<template>
  <div class="row fade-in">
    <div class="col-12">
      <div class="card mb-4 shadow-lg border-0 premium-table-card">
        <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="font-weight-bolder text-primary mb-0">Material de Apoyo <i class="material-icons text-primary ms-1" style="font-size: 20px; vertical-align: middle;">library_books</i></h5>
            <p class="text-sm text-secondary mb-0">
              Recursos de relajación y psicología para estudiantes.
            </p>
          </div>
          <div class="pe-md-3 d-flex align-items-center">
            <button class="btn bg-gradient-primary shadow-primary me-3 hover-scale mb-0" @click="uploadMaterial">
              <i class="material-icons text-white me-1" style="font-size: 14px;">upload_file</i> Subir Material
            </button>
            <div class="input-group input-group-outline bg-white border-radius-md" style="width: 250px;">
              <input type="text" class="form-control" placeholder="Buscar título o tipo..." v-model="searchQuery" @input="filterTable">
            </div>
          </div>
        </div>
        <div class="card-body px-0 pt-3 pb-2">
          <div v-if="loading" class="text-center p-5">
            <div class="spinner-border text-primary" role="status"></div>
          </div>
          <div v-else class="table-responsive p-0" style="max-height: 65vh; overflow-y: auto;">
            <table class="table align-items-center mb-0 table-hover premium-table">
              <thead class="bg-light">
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Título del Recurso</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipo</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Enlace</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Creación</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="resource in filteredResources" :key="resource.id" class="table-row">
                  <td>
                    <div class="d-flex px-3 py-1">
                      <div>
                        <div class="icon-circle me-3">
                          <i class="material-icons text-primary">{{ getTypeIcon(resource.resource_type) }}</i>
                        </div>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm font-weight-bold">{{ resource.title || 'Recurso sin título' }}</h6>
                        <p class="text-xs text-secondary mb-0 text-truncate" style="max-width: 200px;">{{ resource.description || 'Sin descripción' }}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <MaterialBadge color="light" class="text-dark">
                      {{ resource.resource_type ? String(resource.resource_type).toUpperCase() : 'DOCUMENTO' }}
                    </MaterialBadge>
                  </td>
                  <td class="align-middle text-center">
                    <a :href="resource.content_url" target="_blank" class="text-primary text-xs font-weight-bold" v-if="resource.content_url">
                      Abrir Recurso <i class="material-icons text-xs" style="vertical-align: middle;">open_in_new</i>
                    </a>
                    <span v-else class="text-secondary text-xs">Sin enlace</span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ new Date(resource.created_at).toLocaleDateString() }}
                    </span>
                  </td>
                  <td class="align-middle text-center">
                    <a href="javascript:;" class="text-danger font-weight-bold text-xs hover-text-danger mx-2">
                      <i class="material-icons text-sm" style="vertical-align: middle;">delete</i>
                    </a>
                  </td>
                </tr>
                <tr v-if="filteredResources.length === 0">
                  <td colspan="5" class="text-center p-5">
                    <i class="material-icons text-secondary fs-1 mb-3">folder_open</i>
                    <h6 class="text-secondary">No hay recursos de apoyo subidos.</h6>
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
  background-color: rgba(33, 150, 243, 0.05); /* Efecto azul claro (primary) */
  transform: scale(1.01);
  box-shadow: 0 4px 15px rgba(33, 150, 243, 0.1);
  border-radius: 10px;
}

.premium-table td {
  border-bottom: 1px solid rgba(0,0,0,0.03);
}

.icon-circle {
  width: 40px;
  height: 40px;
  background-color: #E3F2FD;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hover-scale {
  transition: transform 0.2s;
}
.hover-scale:hover {
  transform: scale(1.05);
}

.hover-text-danger:hover {
  color: #F44336 !important;
}
</style>
