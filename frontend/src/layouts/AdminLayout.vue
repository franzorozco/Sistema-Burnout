<template>
  <div class="g-sidenav-show bg-gray-200" style="min-height: 100vh;">
    <!-- Sidebar / Menú Lateral -->
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
      <div class="sidenav-header p-3 text-center">
        <span class="ms-1 font-weight-bold text-white fs-5">Panel Médico - Laiso</span>
      </div>
      <hr class="horizontal light mt-0 mb-2">
      <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
          <li class="nav-item">
            <RouterLink class="nav-link text-white" to="/admin/dashboard" active-class="bg-gradient-success">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">dashboard</i>
              </div>
              <span class="nav-link-text ms-1">Resumen / Stats</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-white" to="/admin/interactions" active-class="bg-gradient-success">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">forum</i>
              </div>
              <span class="nav-link-text ms-1">Historial del Chatbot</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-white" to="/admin/alerts" active-class="bg-gradient-success">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">warning</i>
              </div>
              <span class="nav-link-text ms-1">Alertas de Riesgo</span>
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link text-white" to="/admin/professionals" active-class="bg-gradient-success">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">medical_services</i>
              </div>
              <span class="nav-link-text ms-1">Directorio Doctores</span>
            </RouterLink>
          </li>
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Cuenta</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#" @click.prevent="logout">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
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
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur">
        <div class="container-fluid py-3 px-3">
          <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder mb-0">Sistema Administrativo</h6>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="navbar-nav justify-content-end ms-auto">
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
/* Espaciado para que el sidebar no tape el contenido principal en pantallas grandes */
@media (min-width: 992px) {
  .sidenav {
    width: 250px !important;
  }
  .main-content {
    margin-left: 260px !important;
  }
}
</style>
