<script setup>
import DefaultReviewCard from "@/examples/cards/reviewCards/DefaultReviewCard.vue";
</script>
<template>
  <section class="py-7">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 mx-auto text-center">
          <h2 class="mb-0">Conoce testimonios de Internos</h2>
          <h2 class="text-gradient text-success mb-3">
            Historias de superación y esperanza
          </h2>
          <p class="lead">
            Muchos internos han encontrado en este espacio un lugar de apoyo y
            comprensión.
          </p>
        </div>
      </div>
      <div class="row mt-6">
        <DefaultReviewCard
          name="Anonimo Interno"
          date="Hace 2 días"
          review='"Este espacio me ha brindado el apoyo que necesitaba para enfrentar mis
                  desafíos emocionales. El chatbot es como un amigo siempre disponible."'
          :rating="5.0"
        />
        <DefaultReviewCard
          class="ms-md-auto"
          color="bg-gradient-success"
          name="Anonimo Interno 2"
          date="Hace 1 semana"
          review='"Este espacio me ha ayudado a encontrar recursos valiosos para
                  mi bienestar emocional. La información es clara y accesible."'
          :rating="5.0"
        />

        <DefaultReviewCard
          name="Anonimo Interno 3"
          date="Hace 3 semanas"
          review='"Laiso ha sido una herramienta fundamental en mi proceso de
                  recuperación. Me siento escuchado y comprendido."'
          :rating="5.0"
        />
      </div>
      <!-- <hr class="horizontal dark my-5" /> -->
      <!-- <div class="row">
        <div class="col-lg-2 col-md-4 col-6 ms-auto">
          <img
            class="w-100 opacity-6"
            src="@/assets/img/logos/gray-logos/logo-apple.svg"
            alt="Logo"
          />
        </div>
        <div class="col-lg-2 col-md-4 col-6">
          <img
            class="w-100 opacity-6"
            src="@/assets/img/logos/gray-logos/logo-facebook.svg"
            alt="Logo"
          />
        </div>
        <div class="col-lg-2 col-md-4 col-6">
          <img
            class="w-100 opacity-6"
            src="@/assets/img/logos/gray-logos/logo-nasa.svg"
            alt="Logo"
          />
        </div>
        <div class="col-lg-2 col-md-4 col-6 ms-lg-0 ms-md-auto">
          <img
            class="w-100 opacity-6"
            src="@/assets/img/logos/gray-logos/logo-vodafone.svg"
            alt="Logo"
          />
        </div>
        <div class="col-lg-2 col-md-4 col-6 me-md-auto mx-md-0 mx-auto">
          <img
            class="w-100 opacity-6"
            src="@/assets/img/logos/gray-logos/logo-digitalocean.svg"
            alt="Logo"
          />
        </div>
      </div> -->
    </div>
  </section>
</template>
