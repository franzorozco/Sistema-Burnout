<script setup>
import { RouterLink } from "vue-router";
// Importamos el nuevo logo de Unifranz que guardaste
import logoUnifranz from "@/assets/img/logos/logo-unifranz.png";

// URLs de las redes sociales de Unifranz
const unifranzSocials = {
  facebook: "https://www.facebook.com/unifranz.edu",
  instagram: "https://www.instagram.com/unifranz",
  linkedin: "https://www.linkedin.com/school/unifranz/",
  youtube: "https://www.youtube.com/@UnifranzOficial",
};
</script>
<template>
  <footer class="footer pt-5 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4 ms-auto">
          <div>
            <a href="https://unifranz.edu.bo/" target="_blank">
              <img
                :src="logoUnifranz"
                class="mb-3"
                alt="Logo Unifranz"
                style="max-height: 45px"
              />
            </a>
            <p class="text-sm text-body">
              Innovación y excelencia en la prevención del burnout para
              profesionales de la salud.
            </p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 col-6 mb-4">
          <h6 class="text-sm font-weight-bolder">Navegación</h6>
          <ul class="flex-column ms-n3 nav">
            <li class="nav-item">
              <RouterLink class="nav-link" to="/blog"> Blog </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" to="/test-rapido">
                Test Rapido
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" to="/articulos">
                Articulos
              </RouterLink>
            </li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-3 col-6 mb-4">
          <h6 class="text-sm font-weight-bolder">Redes Sociales</h6>
          <ul class="d-flex flex-row ms-n3 nav">
            <li class="nav-item">
              <a
                class="nav-link pe-1"
                :href="unifranzSocials.facebook"
                target="_blank"
                rel="noopener"
              >
                <i class="fab fa-facebook text-lg"></i>
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link pe-1"
                :href="unifranzSocials.instagram"
                target="_blank"
                rel="noopener"
              >
                <i class="fab fa-instagram text-lg"></i>
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link pe-1"
                :href="unifranzSocials.linkedin"
                target="_blank"
                rel="noopener"
              >
                <i class="fab fa-linkedin text-lg"></i>
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link pe-1"
                :href="unifranzSocials.youtube"
                target="_blank"
                rel="noopener"
              >
                <i class="fab fa-youtube text-lg"></i>
              </a>
            </li>
          </ul>
        </div>

        <div class="col-12 mt-4">
          <div class="text-center">
            <p class="text-dark my-4 text-sm font-weight-normal">
              Todos los derechos reservados. Copyright ©
              {{ new Date().getFullYear() }}
              <a href="https://unifranz.edu.bo/" target="_blank" rel="noopener"
                >Unifranz</a
              >.
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>
