<script setup>
import { ref, onMounted, onUnmounted } from "vue";

// --- Importaciones de Componentes ---
import NavbarDefault from "../../../examples/navbars/NavbarDefault.vue";
import FooterDefault from "../../../examples/footers/FooterDefault.vue";
import Header from "../../../examples/Header.vue";
import ArticuloCard from "./components/ArticuloCard.vue";

// --- Datos de los Artículos (Simulación) ---
// Aquí puedes poner los artículos reales.
const articles = ref([
  {
    id: 1,
    image: "https://images.pexels.com/photos/4101143/pexels-photo-4101143.jpeg",
    title: "El Síndrome de Burnout en Profesionales de la Salud",
    description:
      "Un análisis profundo sobre las causas, síntomas y consecuencias del burnout en el personal médico y de enfermería.",
    link: "https://www.medigraphic.com/cgi-bin/new/resumen.cgi?IDARTICULO=95304",
  },
  {
    id: 2,
    image: "https://images.pexels.com/photos/5412153/pexels-photo-5412153.jpeg",
    title: "Técnicas de Mindfulness para Reducir el Estrés",
    description:
      "Descubre cómo 10 minutos de mindfulness al día pueden cambiar drásticamente tu percepción del estrés laboral.",
    link: "https://www.mayoclinic.org/es-es/healthy-lifestyle/consumer-health/in-depth/mindfulness-exercises/art-20046356",
  },
  {
    id: 3,
    image: "https://images.pexels.com/photos/7176288/pexels-photo-7176288.jpeg",
    title: "Equilibrio Trabajo-Vida: Clave para la Salud Mental",
    description:
      "Estrategias para delimitar el horario laboral y fomentar un descanso efectivo, esencial para la recuperación mental.",
    link: "https://www.who.int/es/publications/i/item/9789240043908",
  },
  {
    id: 4,
    image: "https://images.pexels.com/photos/7176297/pexels-photo-7176297.jpeg",
    title: "La Importancia del Apoyo entre Colegas",
    description:
      "Cómo fomentar un ambiente de trabajo colaborativo y de apoyo mutuo puede prevenir el agotamiento individual.",
    link: "https://www.apa.org/monitor/2022/01/special-burnout-pandemic",
  },
  {
    id: 5,
    image: "https://images.pexels.com/photos/5217839/pexels-photo-5217839.jpeg",
    title: "El Impacto del Sueño en el Rendimiento",
    description:
      "No subestimes el poder del descanso. Un análisis sobre la relación directa entre la falta de sueño y el error médico.",
    link: "https://www.ncbi.nlm.nih.gov/pmc/articles/PMC5449130/",
  },
  {
    id: 6,
    image: "https://images.pexels.com/photos/8560663/pexels-photo-8560663.jpeg",
    title: "Nutrición y Estrés: ¿Qué Comer en Turnos Largos?",
    description:
      "Guía rápida de alimentos y snacks saludables para mantener la energía y reducir la ansiedad durante las guardias.",
    link: "https://www.health.harvard.edu/staying-healthy/nutritional-strategies-to-ease-anxiety",
  },
]);

// --- Manejo del Navbar y fondo ---
const body = document.getElementsByTagName("body")[0];
onMounted(() => {
  body.classList.add("articulos-page");
  body.classList.add("bg-gray-200"); // Mismo fondo gris del blog
});
onUnmounted(() => {
  body.classList.remove("articulos-page");
  body.classList.remove("bg-gray-200");
});
</script>

<template>
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <NavbarDefault :sticky="true" />
      </div>
    </div>
  </div>

  <Header>
    <div
      class="page-header min-vh-25"
      :style="{
        paddingTop: '100px',
        backgroundImage:
          'url(https://images.pexels.com/photos/7579320/pexels-photo-7579320.jpeg)',
      }"
      loading="lazy"
    >
      <span class="mask bg-gradient-success opacity-6"></span>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 text-center mx-auto">
            <h1 class="text-white">Artículos de Interés</h1>
            <p class="text-white">
              Recursos y lecturas seleccionadas sobre bienestar y salud mental.
            </p>
          </div>
        </div>
      </div>
    </div>
  </Header>

  <section class="py-4">
    <div class="container">
      <div class="row">
        <div
          v-for="article in articles"
          :key="article.id"
          class="col-lg-4 col-md-6 mb-4 d-flex"
        >
          <ArticuloCard :article="article" />
        </div>
      </div>
    </div>
  </section>

  <FooterDefault />
</template>
