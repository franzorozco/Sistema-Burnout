<script setup>
import MaterialBadge from "../../../components/MaterialBadge.vue";

defineProps({
  data: {
    type: Array,
    required: true,
    heading: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      required: true,
    },
    items: {
      type: Array,
      required: true,
      image: {
        type: String,
        required: true,
      },
      title: {
        type: String,
        required: true,
      },
      subtitle: {
        type: String,
        required: true,
      },
    },
  },
  col1: {
    type: String,
    default: "col-lg-3",
  },
  col2: {
    type: String,
    default: "col-lg-9",
  },
});
</script>
<script>
export default {
  inheritAttrs: false,
};
</script>
<template>
  <section class="my8 py6">
    <div class="container">
      <div class="row">
        <div class="row justify-content-center text-center my-sm-5">
          <div class="col-lg-8">
            <!-- Imagen tipo banner -->
            <img
              src="https://images.pexels.com/photos/23495768/pexels-photo-23495768.jpeg"
              alt="Banner"
              class="img-fluid mb-3 floating-banner"
              style="
                width: 100%;
                height: 5cm;
                object-fit: cover;
                border-radius: 8px;
              "
            />
            <!-- Material Badge -->
            <MaterialBadge color="success" class="mb-3">
              Un paso más cerca de tu bienestar
            </MaterialBadge>

            <h2 class="text-dark mb-0">
              Estamos aquí para ayudarte <br />
              <br />
              Conoce a Laiso
            </h2>
            <p class="lead">
              Laiso es nuestro asistente virtual diseñado para ofrecer apoyo
              emocional y recursos sobre salud mental. <br />
              Siempre disponible cuando lo necesites.
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="container mt-sm-5 mt-3">
      <div
        v-for="({ heading, description, items }, index) in data"
        :class="`row ${index != 0 && index != -1 ? 'pt-lg-6' : ''}`"
        :key="heading"
      >
        <div :class="`${col1 ?? 'col-lg-3'}`">
          <div
            class="position-sticky pb-lg-5 pb-3 mt-lg-0 mt-5 ps-2"
            style="top: 100px"
          >
            <h3>{{ heading }}</h3>
            <h6 class="text-secondary font-weight-normal pe-3">
              {{ description }}
            </h6>
          </div>
        </div>
        <div :class="`${col2 ?? 'col-lg-9'}`">
          <div :class="`row ${index != 0 ? 'mt-3' : ''}`">
            <div
              class="col-md-4 mt-md-0"
              v-for="{ image, title, subtitle, route, pro } in items"
              :key="title"
            >
              <ExampleCard
                class="min-height-160 shadow-lg mt-4"
                :image="image"
                :title="title"
                :subtitle="subtitle"
                :route="route"
                :pro="pro"
              />
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <div class="container mt-sm-2 mt-3">
      <div class="row justify-content-center">
        <!-- Tarjeta 1 -->
        <div class="col-md-5 mb-4">
          <div class="flip-card">
            <div class="flip-card-inner">
              <!-- Lado frontal -->
              <div class="flip-card-front">
                <img
                  src="https://images.pexels.com/photos/5327921/pexels-photo-5327921.jpeg"
                  alt="Tarjeta 1"
                  class="img-fluid"
                  style="
                    width: 100%;
                    height: 300px;
                    object-fit: cover;
                    border-radius: 10px;
                  "
                />
              </div>
              <!-- Lado trasero -->
              <div
                class="flip-card-back d-flex flex-column justify-content-center align-items-center"
              >
                <h3 class="text-white">Disponible Cuando lo necesites</h3>
                <p class="text-white">
                  Nuestro chatbot está siempre listo para brindarte apoyo
                  emocional y recursos sobre salud mental.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="col-md-5 mb-4">
          <div class="flip-card">
            <div class="flip-card-inner">
              <!-- Lado frontal -->
              <div class="flip-card-front">
                <img
                  src="https://images.pexels.com/photos/5386485/pexels-photo-5386485.jpeg"
                  alt="Tarjeta 2"
                  class="img-fluid"
                  style="
                    width: 100%;
                    height: 300px;
                    object-fit: cover;
                    border-radius: 10px;
                  "
                />
              </div>
              <!-- Lado trasero -->
              <div
                class="flip-card-back d-flex flex-column justify-content-center align-items-center"
              >
                <h3 class="text-white">No solo es un asistente</h3>
                <p class="text-white">
                  Laiso es tu compañero en el camino hacia una mejor salud
                  mental, brindándote apoyo y recursos cuando más los necesitas.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.floating-banner {
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.floating-banner:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
}
.flip-card {
  background: transparent;
  perspective: 1000px;
}
.flip-card-inner {
  position: relative;
  width: 100%;
  height: 300px;
  transition: transform 0.8s;
  transform-style: preserve-3d;
}
.flip-card:hover .flip-card-inner {
  transform: rotateY(180deg);
}
.flip-card-front,
.flip-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 10px;
  backface-visibility: hidden;
}
.flip-card-front {
  background-color: #fff;
}
.flip-card-back {
  background: linear-gradient(135deg, #b3fac3, #218838);
  color: white;
  transform: rotateY(180deg);
  padding: 20px;
  text-align: center;
}
</style>
<!-- <template>
  <section class="my-5 py-5">
    <div class="container">
      <div class="row">
        <div class="row justify-content-center text-center my-sm-5">
          <div class="col-lg-6">
            <MaterialBadge color="success" class="mb-3"
              >Un paso más cerca de tu bienestar</MaterialBadge
            >
            <h2 class="text-dark mb-0">Estamos aquí para ayudarte</h2>
            <p class="lead">
              Descubre nuestras herramientas y recursos diseñados para apoyarte
              en tu camino hacia una mejor salud mental.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container mt-sm-5 mt-3">
      <div
        v-for="({ heading, description, items }, index) in data"
        :class="`row ${index != 0 && index != -1 ? 'pt-lg-6' : ''}`"
        :key="heading"
      >
        <div :class="`${col1 ?? 'col-lg-3'}`">
          <div
            class="position-sticky pb-lg-5 pb-3 mt-lg-0 mt-5 ps-2"
            style="top: 100px"
          >
            <h3>{{ heading }}</h3>
            <h6 class="text-secondary font-weight-normal pe-3">
              {{ description }}
            </h6>
          </div>
        </div>
        <div :class="`${col2 ?? 'col-lg-9'}`">
          <div :class="`row ${index != 0 ? 'mt-3' : ''}`">
            <div
              class="col-md-4 mt-md-0"
              v-for="{ image, title, subtitle, route, pro } in items"
              :key="title"
            >
              <ExampleCard
                class="min-height-160 shadow-lg mt-4"
                :image="image"
                :title="title"
                :subtitle="subtitle"
                :route="route"
                :pro="pro"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
 -->
