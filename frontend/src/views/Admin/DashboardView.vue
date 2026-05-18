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
  <div class="row fade-in">
    <!-- Stat Card 1 -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card shadow-sm border-0 premium-card">
        <div class="card-header p-3 pt-2 bg-transparent">
          <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute floating-icon">
            <i class="material-icons opacity-10">forum</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Interacciones Totales</p>
            <h4 class="mb-0 text-dark">{{ stats.interactionsCount }}</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3 bg-transparent">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>que la semana pasada</p>
        </div>
      </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card shadow-sm border-0 premium-card">
        <div class="card-header p-3 pt-2 bg-transparent">
          <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute floating-icon">
            <i class="material-icons opacity-10">warning</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Alertas de Riesgo</p>
            <h4 class="mb-0 text-dark">{{ stats.highRiskCount }}</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3 bg-transparent">
          <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">Atención </span>requerida</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5 fade-in-delay">
    <div class="col-lg-12">
      <div class="card z-index-2 shadow-sm border-0 premium-welcome-card overflow-hidden position-relative">
        <!-- Decoraciones de fondo -->
        <div class="position-absolute w-100 h-100 top-0 start-0 welcome-bg"></div>
        <div class="card-header p-4 pt-4 bg-transparent position-relative z-index-2">
          <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute floating-icon">
            <i class="material-icons opacity-10">health_and_safety</i>
          </div>
          <div class="text-start pt-2 ms-5 ps-3">
            <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Bienvenido al Panel de Control</p>
            <h3 class="mb-0 text-dark gradient-text">Sistema contra el Burnout</h3>
          </div>
        </div>
        <div class="card-body p-4 position-relative z-index-2">
          <p class="text-md text-dark">
            Desde este panel, los administradores y psicólogos pueden monitorear el bienestar de los estudiantes.
            Utiliza el menú lateral para navegar entre el Historial del Chatbot, el Directorio de Doctores y más.
          </p>
          <button class="btn bg-gradient-success mt-3 shadow-success hover-scale">Ver Reporte Detallado</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.fade-in {
  animation: fadeIn 0.8s ease-out;
}
.fade-in-delay {
  animation: fadeIn 1.2s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.premium-card {
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  background: rgba(255, 255, 255, 0.7) !important;
  backdrop-filter: blur(10px);
  border-radius: 15px;
}
.premium-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.floating-icon {
  transition: transform 0.3s;
}
.premium-card:hover .floating-icon {
  transform: scale(1.15) rotate(-5deg);
}

.premium-welcome-card {
  background: rgba(255, 255, 255, 0.85);
  border-radius: 20px;
  backdrop-filter: blur(10px);
}

.welcome-bg {
  background: radial-gradient(circle at top right, rgba(76,175,80,0.1), transparent 50%),
              radial-gradient(circle at bottom left, rgba(33,150,243,0.1), transparent 50%);
  pointer-events: none;
}

.gradient-text {
  background: linear-gradient(45deg, #2E7D32, #4CAF50);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
}

.hover-scale {
  transition: transform 0.2s;
}
.hover-scale:hover {
  transform: scale(1.05);
}
</style>
