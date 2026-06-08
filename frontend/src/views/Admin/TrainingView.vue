<script setup>
import { ref, computed } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

const RAG_URL = "http://127.0.0.1:8001";

// Estado
const selectedFile = ref(null);
const isDragging = ref(false);
const isUploading = ref(false);
const uploadProgress = ref(0);
const uploadHistory = ref([]);
const ragStatus = ref("checking"); // checking | online | offline

// Verificar estado del RAG Service
const checkRagStatus = async () => {
  ragStatus.value = "checking";
  try {
    await axios.get(`${RAG_URL}/docs`, { timeout: 3000 });
    ragStatus.value = "online";
  } catch {
    try {
      await axios.get(`${RAG_URL}/`, { timeout: 3000 });
      ragStatus.value = "online";
    } catch {
      ragStatus.value = "offline";
    }
  }
};
checkRagStatus();

// Computed
const fileIcon = computed(() => {
  if (!selectedFile.value) return "upload_file";
  const name = selectedFile.value.name.toLowerCase();
  if (name.endsWith(".pdf")) return "picture_as_pdf";
  if (name.endsWith(".txt")) return "description";
  return "insert_drive_file";
});

const fileSize = computed(() => {
  if (!selectedFile.value) return "";
  const bytes = selectedFile.value.size;
  if (bytes < 1024) return bytes + " B";
  if (bytes < 1048576) return (bytes / 1024).toFixed(1) + " KB";
  return (bytes / 1048576).toFixed(2) + " MB";
});

const isValidFile = computed(() => {
  if (!selectedFile.value) return false;
  const name = selectedFile.value.name.toLowerCase();
  return name.endsWith(".pdf") || name.endsWith(".txt");
});

// Drag & Drop
const onDragOver = (e) => {
  e.preventDefault();
  isDragging.value = true;
};
const onDragLeave = () => {
  isDragging.value = false;
};
const onDrop = (e) => {
  e.preventDefault();
  isDragging.value = false;
  if (e.dataTransfer.files.length > 0) {
    handleFile(e.dataTransfer.files[0]);
  }
};

// Selección de archivo
const triggerFileInput = () => {
  document.getElementById("file-input-training").click();
};
const onFileSelected = (e) => {
  if (e.target.files.length > 0) {
    handleFile(e.target.files[0]);
  }
};
const handleFile = (file) => {
  const name = file.name.toLowerCase();
  if (!name.endsWith(".pdf") && !name.endsWith(".txt")) {
    Swal.fire({
      icon: "error",
      title: "Formato no soportado",
      text: "Solo se admiten archivos PDF o TXT.",
      confirmButtonColor: "#0077b6",
    });
    return;
  }
  selectedFile.value = file;
};

const removeFile = () => {
  selectedFile.value = null;
  uploadProgress.value = 0;
};

// Subir y entrenar
const uploadAndTrain = async () => {
  if (!selectedFile.value || isUploading.value) return;

  isUploading.value = true;
  uploadProgress.value = 0;

  const formData = new FormData();
  formData.append("file", selectedFile.value);

  try {
    const response = await axios.post(`${RAG_URL}/ingest`, formData, {
      headers: { "Content-Type": "multipart/form-data" },
      onUploadProgress: (progressEvent) => {
        const pct = Math.round((progressEvent.loaded * 100) / progressEvent.total);
        uploadProgress.value = Math.min(pct, 95);
      },
      timeout: 120000,
    });

    uploadProgress.value = 100;

    // Guardar en historial local
    uploadHistory.value.unshift({
      id: Date.now(),
      name: selectedFile.value.name,
      size: fileSize.value,
      chunks: response.data.chunks_indexed || 0,
      date: new Date().toLocaleString(),
      status: "success",
    });

    await Swal.fire({
      icon: "success",
      title: "¡Entrenamiento Exitoso!",
      html: `
        <div style="text-align: left; margin-top: 10px;">
          <p><b>Archivo:</b> ${selectedFile.value.name}</p>
          <p><b>Fragmentos indexados:</b> ${response.data.chunks_indexed}</p>
          <p style="color: #666; font-size: 13px;">Laiso ya puede usar esta información para responder preguntas.</p>
        </div>
      `,
      confirmButtonColor: "#0077b6",
    });

    selectedFile.value = null;
    uploadProgress.value = 0;
  } catch (error) {
    console.error("Error al entrenar:", error);
    const errorMsg = error.response?.data?.detail || "No se pudo conectar con el servicio de IA. Asegúrate de que el servidor Python esté corriendo en el puerto 8001.";

    uploadHistory.value.unshift({
      id: Date.now(),
      name: selectedFile.value.name,
      size: fileSize.value,
      chunks: 0,
      date: new Date().toLocaleString(),
      status: "error",
    });

    Swal.fire({
      icon: "error",
      title: "Error al entrenar",
      text: errorMsg,
      confirmButtonColor: "#e53935",
    });
  } finally {
    isUploading.value = false;
  }
};

const clearHistory = () => {
  uploadHistory.value = [];
};
</script>

<template>
  <div class="row fade-in">
    <!-- Status Banner -->
    <div class="col-12 mb-4">
      <div class="card shadow-lg border-0 premium-card overflow-hidden">
        <div class="training-header">
          <div class="header-content d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center">
              <div class="header-icon-wrapper me-3">
                <i class="material-icons" style="font-size: 36px; color: white;">model_training</i>
              </div>
              <div>
                <h4 class="text-white mb-1 font-weight-bold">Centro de Entrenamiento de Laiso</h4>
                <p class="text-white-50 mb-0" style="font-size: 14px;">
                  Sube documentos PDF o TXT para alimentar la base de conocimiento del chatbot.
                </p>
              </div>
            </div>
            <div class="d-flex align-items-center mt-2 mt-md-0">
              <div class="status-badge" :class="ragStatus">
                <span class="status-dot"></span>
                <span v-if="ragStatus === 'online'">Servicio IA Activo</span>
                <span v-else-if="ragStatus === 'offline'">Servicio IA Desconectado</span>
                <span v-else>Verificando...</span>
              </div>
              <button class="btn btn-sm btn-outline-light ms-2 mb-0" @click="checkRagStatus" title="Verificar conexión">
                <i class="material-icons" style="font-size: 18px; vertical-align: middle;">refresh</i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Upload Card -->
    <div class="col-lg-7 mb-4">
      <div class="card shadow-lg border-0 premium-card h-100">
        <div class="card-header pb-0 bg-transparent border-0">
          <h5 class="font-weight-bolder text-dark mb-1">
            <i class="material-icons text-primary me-1" style="font-size: 22px; vertical-align: middle;">cloud_upload</i>
            Subir Documento
          </h5>
          <p class="text-sm text-secondary mb-0">
            Arrastra un archivo o haz clic para seleccionarlo.
          </p>
        </div>
        <div class="card-body pt-3">
          <!-- Drop Zone -->
          <div
            class="drop-zone"
            :class="{ 'drop-zone-active': isDragging, 'drop-zone-has-file': selectedFile }"
            @dragover="onDragOver"
            @dragleave="onDragLeave"
            @drop="onDrop"
            @click="!selectedFile && triggerFileInput()"
          >
            <input
              type="file"
              id="file-input-training"
              accept=".pdf,.txt"
              style="display: none;"
              @change="onFileSelected"
            />

            <!-- Sin archivo seleccionado -->
            <div v-if="!selectedFile" class="drop-zone-empty">
              <div class="drop-icon-wrapper">
                <i class="material-icons">cloud_upload</i>
              </div>
              <h6 class="mt-3 mb-1 text-dark font-weight-bold">Arrastra tu archivo aquí</h6>
              <p class="text-secondary text-sm mb-2">o haz clic para explorar</p>
              <div class="file-types">
                <span class="file-type-badge pdf">
                  <i class="material-icons" style="font-size: 14px;">picture_as_pdf</i> PDF
                </span>
                <span class="file-type-badge txt">
                  <i class="material-icons" style="font-size: 14px;">description</i> TXT
                </span>
              </div>
            </div>

            <!-- Archivo seleccionado -->
            <div v-else class="drop-zone-file">
              <div class="file-preview">
                <div class="file-icon-big">
                  <i class="material-icons">{{ fileIcon }}</i>
                </div>
                <div class="file-info">
                  <h6 class="mb-0 text-dark font-weight-bold text-truncate" style="max-width: 250px;">
                    {{ selectedFile.name }}
                  </h6>
                  <span class="text-secondary text-sm">{{ fileSize }}</span>
                  <span v-if="isValidFile" class="badge bg-success ms-2" style="font-size: 10px;">Formato válido</span>
                  <span v-else class="badge bg-danger ms-2" style="font-size: 10px;">Formato inválido</span>
                </div>
                <button class="btn btn-link text-danger p-0 ms-3" @click.stop="removeFile" :disabled="isUploading" title="Quitar archivo">
                  <i class="material-icons" style="font-size: 22px;">close</i>
                </button>
              </div>

              <!-- Progress Bar -->
              <div v-if="isUploading" class="progress-wrapper mt-3">
                <div class="progress" style="height: 8px; border-radius: 10px; background: #e0e0e0;">
                  <div
                    class="progress-bar progress-bar-animated"
                    :style="{ width: uploadProgress + '%' }"
                    :class="uploadProgress === 100 ? 'bg-success' : 'bg-gradient-primary'"
                  ></div>
                </div>
                <div class="d-flex justify-content-between mt-1">
                  <small class="text-secondary">
                    {{ uploadProgress < 95 ? 'Subiendo archivo...' : (uploadProgress === 100 ? '¡Completado!' : 'Procesando con Gemini...') }}
                  </small>
                  <small class="text-primary font-weight-bold">{{ uploadProgress }}%</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="d-flex justify-content-end mt-4 gap-2">
            <button
              class="btn btn-outline-secondary mb-0"
              @click="removeFile"
              :disabled="!selectedFile || isUploading"
            >
              <i class="material-icons me-1" style="font-size: 16px; vertical-align: middle;">clear</i>
              Limpiar
            </button>
            <button
              class="btn bg-gradient-primary shadow-primary mb-0 hover-scale"
              :class="{ 'btn-loading': isUploading }"
              @click="uploadAndTrain"
              :disabled="!isValidFile || isUploading || ragStatus === 'offline'"
            >
              <i v-if="!isUploading" class="material-icons me-1" style="font-size: 16px; vertical-align: middle;">rocket_launch</i>
              <span v-if="!isUploading">Entrenar a Laiso</span>
              <span v-else>
                <span class="spinner-border spinner-border-sm me-1"></span>
                Entrenando...
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Info Panel -->
    <div class="col-lg-5 mb-4">
      <div class="card shadow-lg border-0 premium-card h-100">
        <div class="card-header pb-0 bg-transparent border-0">
          <h5 class="font-weight-bolder text-dark mb-1">
            <i class="material-icons text-info me-1" style="font-size: 22px; vertical-align: middle;">info</i>
            ¿Cómo funciona?
          </h5>
        </div>
        <div class="card-body pt-2">
          <div class="info-steps">
            <div class="info-step">
              <div class="step-number">1</div>
              <div class="step-content">
                <h6 class="mb-1 font-weight-bold">Sube un documento</h6>
                <p class="text-secondary text-sm mb-0">
                  Arrastra o selecciona un archivo PDF o TXT con información sobre burnout, técnicas de relajación, o cualquier material de apoyo.
                </p>
              </div>
            </div>
            <div class="info-step">
              <div class="step-number">2</div>
              <div class="step-content">
                <h6 class="mb-1 font-weight-bold">Procesamiento Inteligente</h6>
                <p class="text-secondary text-sm mb-0">
                  El sistema extrae el texto, lo divide en fragmentos y genera vectores semánticos usando <b>Gemini AI</b>.
                </p>
              </div>
            </div>
            <div class="info-step">
              <div class="step-number">3</div>
              <div class="step-content">
                <h6 class="mb-1 font-weight-bold">Laiso Aprende</h6>
                <p class="text-secondary text-sm mb-0">
                  Los fragmentos se guardan en una base vectorial (ChromaDB). Cuando un estudiante pregunte, Laiso buscará la respuesta en estos documentos.
                </p>
              </div>
            </div>
          </div>

          <div class="alert-box mt-4">
            <div class="d-flex align-items-start">
              <i class="material-icons text-warning me-2" style="font-size: 20px;">warning_amber</i>
              <div>
                <h6 class="mb-1 text-dark" style="font-size: 13px; font-weight: 700;">Importante</h6>
                <p class="text-secondary mb-0" style="font-size: 12px;">
                  Cada vez que subas un nuevo archivo, este <b>reemplaza</b> la base de conocimiento anterior. 
                  Si necesitas que Laiso recuerde múltiples documentos, combínalos en un solo PDF antes de subirlos.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Upload History -->
    <div class="col-12" v-if="uploadHistory.length > 0">
      <div class="card shadow-lg border-0 premium-card">
        <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="font-weight-bolder text-dark mb-0">
              <i class="material-icons text-primary me-1" style="font-size: 22px; vertical-align: middle;">history</i>
              Historial de Entrenamientos
            </h5>
            <p class="text-sm text-secondary mb-0">Registro de esta sesión</p>
          </div>
          <button class="btn btn-sm btn-outline-danger mb-0" @click="clearHistory">
            <i class="material-icons me-1" style="font-size: 14px; vertical-align: middle;">delete_sweep</i>
            Limpiar
          </button>
        </div>
        <div class="card-body px-0 pt-3 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 table-hover premium-table">
              <thead class="bg-light">
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Archivo</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tamaño</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fragmentos</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="entry in uploadHistory" :key="entry.id" class="table-row">
                  <td>
                    <div class="d-flex px-3 py-1 align-items-center">
                      <div class="icon-circle me-3">
                        <i class="material-icons text-primary">{{ entry.name.endsWith('.pdf') ? 'picture_as_pdf' : 'description' }}</i>
                      </div>
                      <h6 class="mb-0 text-sm font-weight-bold">{{ entry.name }}</h6>
                    </div>
                  </td>
                  <td>
                    <span class="text-secondary text-sm">{{ entry.size }}</span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-dark font-weight-bold text-sm">{{ entry.chunks }}</span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs">{{ entry.date }}</span>
                  </td>
                  <td class="align-middle text-center">
                    <span v-if="entry.status === 'success'" class="badge bg-gradient-success" style="font-size: 10px;">
                      <i class="material-icons" style="font-size: 12px; vertical-align: middle;">check_circle</i> Exitoso
                    </span>
                    <span v-else class="badge bg-gradient-danger" style="font-size: 10px;">
                      <i class="material-icons" style="font-size: 12px; vertical-align: middle;">error</i> Error
                    </span>
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

/* Header Banner */
.training-header {
  background: linear-gradient(135deg, #0077b6 0%, #00b4d8 40%, #48cae4 100%);
  padding: 28px 30px;
  position: relative;
  overflow: hidden;
}
.training-header::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 300px;
  height: 300px;
  background: rgba(255, 255, 255, 0.08);
  border-radius: 50%;
}
.training-header::after {
  content: '';
  position: absolute;
  bottom: -60%;
  left: 10%;
  width: 200px;
  height: 200px;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 50%;
}
.header-content {
  position: relative;
  z-index: 2;
}
.header-icon-wrapper {
  width: 60px;
  height: 60px;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(8px);
}

/* Status Badge */
.status-badge {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  backdrop-filter: blur(8px);
}
.status-badge.online {
  background: rgba(76, 175, 80, 0.25);
  color: #c8e6c9;
}
.status-badge.offline {
  background: rgba(244, 67, 54, 0.25);
  color: #ffcdd2;
}
.status-badge.checking {
  background: rgba(255, 193, 7, 0.25);
  color: #fff9c4;
}
.status-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  animation: pulse 2s infinite;
}
.status-badge.online .status-dot { background: #4CAF50; }
.status-badge.offline .status-dot { background: #F44336; }
.status-badge.checking .status-dot { background: #FFC107; }
@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(0.8); }
}

/* Premium Card */
.premium-card {
  background: rgba(255, 255, 255, 0.9) !important;
  backdrop-filter: blur(10px);
  border-radius: 20px;
}

/* Drop Zone */
.drop-zone {
  border: 2px dashed #cbd5e1;
  border-radius: 16px;
  padding: 40px 20px;
  text-align: center;
  transition: all 0.3s ease;
  cursor: pointer;
  background: linear-gradient(135deg, #fafbfc 0%, #f0f4f8 100%);
  position: relative;
  overflow: hidden;
}
.drop-zone:hover {
  border-color: #00b4d8;
  background: linear-gradient(135deg, #f0f9ff 0%, #e0f7fa 100%);
}
.drop-zone-active {
  border-color: #0077b6 !important;
  background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%) !important;
  transform: scale(1.02);
  box-shadow: 0 0 0 4px rgba(0, 180, 216, 0.15);
}
.drop-zone-has-file {
  border-style: solid;
  border-color: #00b4d8;
  cursor: default;
  padding: 25px 20px;
  background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
}

.drop-icon-wrapper {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  transition: transform 0.3s;
}
.drop-icon-wrapper i {
  font-size: 36px;
  color: #0077b6;
}
.drop-zone:hover .drop-icon-wrapper {
  transform: scale(1.1) translateY(-5px);
}

.file-types {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: 10px;
}
.file-type-badge {
  display: flex;
  align-items: center;
  gap: 4px;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}
.file-type-badge.pdf {
  background: #fce4ec;
  color: #c62828;
}
.file-type-badge.txt {
  background: #e3f2fd;
  color: #1565c0;
}

/* File Preview */
.file-preview {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 15px;
}
.file-icon-big {
  width: 56px;
  height: 56px;
  background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.file-icon-big i {
  font-size: 28px;
  color: #0077b6;
}
.file-info {
  text-align: left;
}

/* Progress */
.bg-gradient-primary {
  background: linear-gradient(135deg, #00b4d8, #0077b6) !important;
}
.progress-bar-animated {
  transition: width 0.4s ease;
}

/* Info Steps */
.info-steps {
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.info-step {
  display: flex;
  align-items: flex-start;
  gap: 15px;
}
.step-number {
  width: 36px;
  height: 36px;
  min-width: 36px;
  background: linear-gradient(135deg, #00b4d8, #0077b6);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 14px;
  box-shadow: 0 4px 10px rgba(0, 119, 182, 0.3);
}
.step-content {
  flex: 1;
}

/* Alert Box */
.alert-box {
  background: linear-gradient(135deg, #fff8e1, #fff3cd);
  border: 1px solid #ffe082;
  border-radius: 14px;
  padding: 16px;
}

/* Table */
.premium-table tbody tr {
  transition: all 0.3s ease;
}
.premium-table tbody tr:hover {
  background-color: rgba(0, 180, 216, 0.05);
  transform: scale(1.01);
  box-shadow: 0 4px 15px rgba(0, 180, 216, 0.1);
  border-radius: 10px;
}
.premium-table td {
  border-bottom: 1px solid rgba(0,0,0,0.03);
}
.icon-circle {
  width: 40px;
  height: 40px;
  background-color: #e0f7fa;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Hover Scale */
.hover-scale {
  transition: transform 0.2s;
}
.hover-scale:hover {
  transform: scale(1.05);
}
.btn-loading {
  pointer-events: none;
  opacity: 0.85;
}
.shadow-primary {
  box-shadow: 0 4px 15px rgba(0, 119, 182, 0.35) !important;
}

/* Text White 50 helper */
.text-white-50 {
  color: rgba(255, 255, 255, 0.65) !important;
}
</style>
