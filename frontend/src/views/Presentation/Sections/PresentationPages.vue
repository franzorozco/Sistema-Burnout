<script setup>
import ExampleCard from "../Components/ExampleCard.vue";
import MaterialBadge from "../../../components/MaterialBadge.vue";
</script>
<template>
  <section class="my8 py6">
    <div class="container">
      <div class="row">
        <div class="row justify-content-center text-center my-sm-5">
          <div class="col-lg-8">
            <!-- Imagen tipo banner -->
            <img
              src="https://images.pexels.com/photos/4098273/pexels-photo-4098273.jpeg"
              alt="Banner"
              class="img-fluid mb-3 floating-banner"
              style="
                width: 100%;
                height: 5cm;
                object-fit: cover;
                border-radius: 8px;
              "
            />
            <MaterialBadge color="success" class="mb-3"
              >Apoyo a la salud mental</MaterialBadge
            >
            <h2 class=""></h2>
            <p class="lead">
              ChatBot disponible cuando lo necesites <br />
              Artículos y recursos informativos
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-8">
          <div class="row mt-4">
            <div class="col-md-6 mt-md-0 mt-5">
              <ExampleCard
                class="shadow-lg"
                image="https://images.pexels.com/photos/5722164/pexels-photo-5722164.jpeg"
                style="
                  width: 100%;
                  height: 12cm;
                  object-fit: cover;
                  border-radius: 8px;
                "
              />
            </div>
            <div class="col-md-6 mt-md-0 mt-5">
              <ExampleCard
                class="shadow-lg"
                image="https://images.pexels.com/photos/5452201/pexels-photo-5452201.jpeg"
                style="
                  width: 100%;
                  height: 12cm;
                  object-fit: cover;
                  border-radius: 8px;
                "
              />
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-6 mt-md-0 mt-5">
              <ExampleCard
                classes="mt-5"
                image="https://images.pexels.com/photos/4101143/pexels-photo-4101143.jpeg"
              />
            </div>
            <div class="col-md-6 mt-md-0 mt-5">
              <ExampleCard
                classes="shadow-lg"
                image="https://images.pexels.com/photos/7176026/pexels-photo-7176026.jpeg"
              />
            </div>
          </div>
        </div>
        <div class="col-md-3 mx-auto mt-md-0 mt-3">
          <div class="position-sticky" style="top: 100px !important">
            <h3>Explora nuestras herramientas y recursos para tu bienestar</h3>
            <h6 class="text-secondary font-weight-normal">
              Esta es solo una pequeña selección de las múltiples posibilidades
              que tienes. Concédele prioridad a tu bienestar.
            </h6>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
