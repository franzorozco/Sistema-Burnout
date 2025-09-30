<script setup>
import RotatingCard from "../../../examples/cards/rotatingCards/RotatingCard.vue";
import RotatingCardFront from "../../../examples/cards/rotatingCards/RotatingCardFront.vue";
import RotatingCardBack from "../../../examples/cards/rotatingCards/RotatingCardBack.vue";
import DefaultInfoCard from "../../../examples/cards/infoCards/DefaultInfoCard.vue";
</script>
<template>
  <section class="my-5 py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-4 ms-auto me-auto p-lg-4 mt-lg-0 mt-4">
          <RotatingCard>
            <RotatingCardFront
              image="https://images.pexels.com/photos/5217850/pexels-photo-5217850.jpeg"
              icon="smart_toy"
              title="Laiso <br /> Será tu mejor compañero"
              description="Interactúa con nuestro chatbot para recibir apoyo emocional y recursos sobre salud mental, siempre disponible cuando lo necesites."
            />

            <RotatingCardBack
              image="https://images.pexels.com/photos/4098340/pexels-photo-4098340.jpeg"
              title="Leer más"
              description="Aqui puedes tener acceso a más información sobre nuestros servicios y cómo podemos ayudarte a mejorar tu bienestar mental."
              :action="[
                {
                  route: './/sections/page-sections/hero-sections.html',
                  label: 'Ver más',
                },
              ]"
            />
          </RotatingCard>
        </div>
        <div class="col-lg-6 ms-auto">
          <div class="row justify-content-start">
            <DefaultInfoCard
              icon="article"
              title="Articulos y Recursos"
              description="Puedes explorar una variedad de artículos y recursos informativos sobre salud mental, bienestar emocional y estrategias para manejar el estrés."
            />
            <DefaultInfoCard
              icon="smart_toy"
              title="Chat Bot de Apoyo"
              description="Un asistente virtual diseñado para ofrecer apoyo emocional y recursos sobre salud mental."
            />
          </div>
          <div class="row justify-content-start mt-5">
            <DefaultInfoCard
              class="mt-3"
              icon="medical_services"
              title="Encuentra Ayuda Profesional"
              description="Aquí puedes encontrar profesionales de la salud mental que pueden ayudarte en tu proceso de bienestar."
            />
            <DefaultInfoCard
              class="mt-3"
              icon="dashboard"
              title="Conoce nuestra Plataforma"
              description="Esta plataforma está diseñada para ser fácil de usar y accesible desde cualquier dispositivo, brindándote la ayuda que necesitas en cualquier momento y lugar."
            />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
