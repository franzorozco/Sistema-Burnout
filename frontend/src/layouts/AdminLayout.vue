<template>
  <div class="app-background g-sidenav-show" :class="{ 'g-sidenav-pinned': sidebarOpen }" style="min-height: 100vh;">
    <!-- Sidebar / Menú Lateral con Glassmorphism -->
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-4 fixed-start ms-4 glass-sidebar" :class="{ 'show-sidebar': sidebarOpen }" id="sidenav-main">
      <div class="sidenav-header text-center p-3 mt-2 position-relative" style="height: auto;">
        <i class="material-icons p-2 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" @click="toggleSidebar" aria-hidden="true">close</i>
        <div class="brand-icon mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
          <i class="material-icons text-dark" style="font-size: 40px;">health_and_safety</i>
        </div>
        <span class="font-weight-bold text-dark fs-5" style="letter-spacing: 0.5px;">Gestión Bienestar</span>
      </div>
      <hr class="horizontal dark mt-0 mb-4 mx-4">
      <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main" style="overflow-y: auto; height: calc(100vh - 180px);">
        <ul class="navbar-nav mb-5">
          <li class="nav-item">
            <RouterLink class="nav-link text-dark menu-item-animate" to="/admin/dashboard" active-class="bg-gradient-dynamic text-white shadow-dynamic active-link">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">dashboard</i>
              </div>
              <span class="nav-link-text ms-1">Resumen / Stats</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-dark menu-item-animate" to="/admin/interactions" active-class="bg-gradient-dynamic text-white shadow-dynamic active-link">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">forum</i>
              </div>
              <span class="nav-link-text ms-1">Historial del Chatbot</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-dark menu-item-animate" to="/admin/alerts" active-class="bg-gradient-dynamic text-white shadow-dynamic active-link">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">warning</i>
              </div>
              <span class="nav-link-text ms-1">Alertas de Riesgo</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-dark menu-item-animate" to="/admin/professionals" active-class="bg-gradient-dynamic text-white shadow-dynamic active-link">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">medical_services</i>
              </div>
              <span class="nav-link-text ms-1">Directorio Doctores</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-dark menu-item-animate" to="/admin/students" active-class="bg-gradient-dynamic text-white shadow-dynamic active-link">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">school</i>
              </div>
              <span class="nav-link-text ms-1">Estudiantes en Riesgo</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-dark menu-item-animate" to="/admin/appointments" active-class="bg-gradient-dynamic text-white shadow-dynamic active-link">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">event_available</i>
              </div>
              <span class="nav-link-text ms-1">Citas Médicas</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-dark menu-item-animate" to="/admin/resources" active-class="bg-gradient-dynamic text-white shadow-dynamic active-link">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">library_books</i>
              </div>
              <span class="nav-link-text ms-1">Material de Apoyo</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-dark menu-item-animate" to="/admin/chat-laiso" active-class="bg-gradient-dynamic text-white shadow-dynamic active-link">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">psychology</i>
              </div>
              <span class="nav-link-text ms-1 font-weight-bold">Centro de Inteligencia</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-dark menu-item-animate" to="/admin/training" active-class="bg-gradient-dynamic text-white shadow-dynamic active-link">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">model_training</i>
              </div>
              <span class="nav-link-text ms-1 font-weight-bold">Entrenar Chatbot</span>
            </RouterLink>
          </li>
          <li class="nav-item mt-4">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-secondary font-weight-bolder opacity-8">Cuenta</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark hover-glow" href="#" @click.prevent="logout">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center icon-wrapper">
                <i class="material-icons opacity-10">logout</i>
              </div>
              <span class="nav-link-text ms-1">Cerrar Sesión</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <!-- Main Content / Contenedor Principal -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ps-5 ms-5">
      <!-- Navbar Superior -->
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl mt-3 glass-navbar" id="navbarBlur">
        <div class="container-fluid py-2 px-3">
          <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder mb-0 text-dark">Sistema Administrativo</h6>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-between align-items-center" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
              <!-- Aquí podría ir una barra de búsqueda global -->
            </div>
            <ul class="navbar-nav justify-content-end ms-auto">
              <li class="nav-item d-xl-none ps-3 d-flex align-items-center me-3">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav" @click="toggleSidebar">
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-dark"></i>
                    <i class="sidenav-toggler-line bg-dark"></i>
                    <i class="sidenav-toggler-line bg-dark"></i>
                  </div>
                </a>
              </li>
              <li class="nav-item d-flex align-items-center">
                <span class="nav-link text-body font-weight-bold px-0 cursor-pointer">
                  <i class="fa fa-user me-sm-1"></i>
                  <span class="d-sm-inline d-none ms-1">{{ userName }} ({{ role }})</span>
                </span>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      
      <!-- AQUÍ SE RENDERIZA EL CRUD ACTIVO -->
      <div class="container-fluid py-4">
        <router-view></router-view>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';

const userName = ref('');
const role = ref('');
const sidebarOpen = ref(false);

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};

onMounted(() => {
  const user = JSON.parse(localStorage.getItem('user'));
  const userRole = localStorage.getItem('role');
  
  if (user) {
    userName.value = user.name;
    role.value = userRole === 'admin' ? 'Administrador' : (userRole === 'professional' ? 'Psicólogo' : 'Estudiante');
  } else {
    // Si no está logueado, lo botamos
    window.location.href = '/pages/landing-pages/basic';
  }
});

const logout = () => {
  Swal.fire({
    title: '¿Cerrar sesión?',
    text: "Tendrás que volver a ingresar tus credenciales.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#4CAF50',
    cancelButtonColor: '#F44336',
    confirmButtonText: 'Sí, salir'
  }).then((result) => {
    if (result.isConfirmed) {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      localStorage.removeItem('role');
      window.location.href = '/pages/landing-pages/basic';
    }
  });
};
</script>

<style scoped>
/* Fondo animado premium */
.app-background {
  background: linear-gradient(-45deg, #e0f7fa, #ffffff, #e8f5e9, #f1f8e9);
  background-size: 400% 400%;
  animation: gradientBG 15s ease infinite;
}

@keyframes gradientBG {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Glassmorphism Sidebar */
.glass-sidebar {
  background: rgba(255, 255, 255, 0.85) !important;
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.3) !important;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07) !important;
  z-index: 1000;
}

/* Glassmorphism Navbar */
.glass-navbar {
  background: rgba(255, 255, 255, 0.6) !important;
  backdrop-filter: blur(10px);
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}

/* Hover Effects on Menu */
.nav-link {
  transition: all 0.3s ease;
  border-radius: 10px;
  margin: 0.5rem 1rem;
  padding: 0.75rem 1rem;
  display: flex;
  align-items: center;
}
.nav-link.text-dark {
  color: #344767 !important;
}
.nav-link.text-dark .icon-wrapper i {
  color: #344767 !important;
}
/* Gradiente Dinámico de Tres Colores (Cian, Azul Profundo, Púrpura Cálido) */
.bg-gradient-dynamic {
  background: linear-gradient(135deg, #00BCD4 0%, #2196F3 50%, #9C27B0 100%);
  background-size: 200% 200%;
  animation: gradientShift 5s ease infinite;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.shadow-dynamic {
  box-shadow: 0 4px 15px 0 rgba(33, 150, 243, 0.4) !important;
}

/* Animaciones de micro-interacción para el menú */
.menu-item-animate {
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  border-radius: 12px;
  margin-bottom: 5px;
}

.menu-item-animate:hover:not(.active-link) {
  transform: translateX(8px) scale(1.02);
  background: rgba(33, 150, 243, 0.08);
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.menu-item-animate:hover:not(.active-link) .nav-link-text,
.menu-item-animate:hover:not(.active-link) .icon-wrapper i {
  color: #1976D2 !important; /* Azul vibrante al hacer hover */
}

/* Cuando está activo (cuadro animado), forzamos iconos y texto a blanco */
.active-link,
.active-link .nav-link-text,
.active-link .icon-wrapper i {
  color: #ffffff !important;
}

.active-link:hover {
  transform: scale(1.03);
}

.icon-wrapper {
  transition: transform 0.3s;
}
.nav-link:hover .icon-wrapper {
  transform: scale(1.1) rotate(5deg);
}

.brand-icon {
  width: 50px;
  height: 50px;
  background: #e8f5e9;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 10px rgba(76,175,80,0.2);
}

/* Toggler de Hamburguesa */
.sidenav-toggler-inner .sidenav-toggler-line {
  background: #344767;
  display: block;
  height: 2px;
  width: 18px;
  margin-bottom: 3px;
  transition: all 0.2s cubic-bezier(0.25, 0.1, 0.25, 1);
}

/* Espaciado responsivo y comportamiento Sidebar en Celulares */
@media (max-width: 991.98px) {
  .sidenav {
    transform: translateX(-300px);
    transition: transform 0.3s ease-in-out;
  }
  .sidenav.show-sidebar {
    transform: translateX(0);
  }
  .main-content {
    margin-left: 0 !important;
    padding-left: 0 !important;
  }
}

@media (min-width: 992px) {
  .sidenav {
    width: 250px !important;
    transform: translateX(0) !important;
  }
  .main-content {
    margin-left: 270px !important;
  }
}
</style>
