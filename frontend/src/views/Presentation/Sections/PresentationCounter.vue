<script setup>
import DefaultCounterCard from "../../../examples/cards/counterCards/DefaultCounterCard.vue";
</script>

<template>
  <section class="pt-3 pb-4" id="count-stats">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 z-index-2 border-radius-xl mx-auto py-3">
          <div class="row">
            <div class="col-md-4 position-relative">
              <DefaultCounterCard
                color="success"
                title="Guias de apoyo"
                description="Contamos con profesionales capacitados para brindarte la ayuda que necesitas"
                :count="10"
                suffix="+"
                :duration="4000"
                divider="vertical"
              />
            </div>
            <div class="col-md-4 position-relative">
              <DefaultCounterCard
                color="success"
                title="Articulos"
                description="Explora nuestros artículos y recursos para obtener información valiosa sobre salud mental y bienestar"
                :count="30"
                suffix="+"
                :duration="3000"
                divider="vertical"
              />
            </div>
            <div class="col-md-4 position-relative">
              <DefaultCounterCard
                class="mt-3"
                icon="dashboard"
                title="Conoce nuestra Plataforma"
                description="Esta plataforma está diseñada para ser fácil de usar y accesible desde cualquier dispositivo, brindándote la ayuda que necesitas en cualquier momento y lugar."
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
