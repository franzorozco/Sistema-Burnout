<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

const stats = ref({
  interactionsCount: 0,
  highRiskCount: 0,
});

onMounted(async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await axios.get("/api/chatbot-interactions", {
      headers: { Authorization: `Bearer ${token}` }
    });
    // Simular estadísticas por ahora
    const interactions = res.data.data || [];
    stats.value.interactionsCount = interactions.length;
    stats.value.highRiskCount = interactions.filter(i => String(i.detected_risk).includes('alto') || String(i.detected_risk).includes('extremo')).length;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
  <div class="row">
    <!-- Stat Card 1 -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card shadow-sm border-0">
        <div class="card-header p-3 pt-2 bg-white">
          <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">forum</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Interacciones Totales</p>
            <h4 class="mb-0">{{ stats.interactionsCount }}</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3 bg-white">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>que la semana pasada</p>
        </div>
      </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card shadow-sm border-0">
        <div class="card-header p-3 pt-2 bg-white">
          <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">warning</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Alertas de Riesgo</p>
            <h4 class="mb-0">{{ stats.highRiskCount }}</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3 bg-white">
          <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">Atención </span>requerida</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card z-index-2 shadow-sm border-0">
        <div class="card-header p-3 pt-2 bg-white">
          <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">info</i>
          </div>
          <div class="text-start pt-1 ms-5 ps-3">
            <p class="text-sm mb-0 text-capitalize">Bienvenido al Panel de Control</p>
            <h4 class="mb-0">Sistema contra el Burnout</h4>
          </div>
        </div>
        <div class="card-body p-3">
          <p class="text-sm">
            Desde este panel, los administradores y psicólogos pueden monitorear el bienestar de los estudiantes.
            Utiliza el menú lateral para navegar entre el Historial del Chatbot, el Directorio de Doctores y más.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
