<script setup>
import { ref, onMounted, onUnmounted } from "vue";

// --- Importaciones de Componentes ---
import NavbarDefault from "../../../examples/navbars/NavbarDefault.vue";
import FooterDefault from "../../../examples/footers/FooterDefault.vue";
import Header from "../../../examples/Header.vue";
import BlogPostCard from "./components/BlogPostCard.vue";
import MaterialTextArea from "../../../components/MaterialTextArea.vue";
import MaterialButton from "../../../components/MaterialButton.vue";

// --- Estado Reactivo (Simulación de Base de Datos) ---

// Ref para el texto de la nueva publicación
const newPostText = ref("");

// Lista de publicaciones (esto vendría de tu backend)
const posts = ref([
  {
    id: 1,
    author: "Interno Anonimo #1",
    content:
      "Largo día en la guardia. A veces siento que no doy más. ¿Alguien más se siente así? ¿Cómo lo manejan?",
    comments: [
      {
        id: 1,
        author: "Interno Anonimo",
        text: "Ánimo. Todos pasamos por eso. Intenta descansar bien en tu día libre.",
        rating: 4,
      },
    ],
  },
  {
    id: 2,
    author: "Interno Anonimo #2",
    content:
      "Hoy un paciente me agradeció y me dijo que le había ayudado mucho. Son esos pequeños momentos los que hacen que todo valga la pena.",
    comments: [],
  },
  {
    id: 3,
    author: "Interno Anonimo #3",
    content: "¿Algún consejo para manejar el estrés antes de los exámenes?",
    comments: [],
  },
  {
    id: 4,
    author: "Interno Anonimo #4",
    content:
      "Recordatorio: está bien no estar bien. Busquen ayuda si la necesitan. Hablarlo, aunque sea anónimamente, alivia.",
    comments: [
      {
        id: 2,
        author: "Interno Anonimo",
        text: "Totalmente de acuerdo.",
        rating: 5,
      },
      {
        id: 3,
        author: "Interno Anonimo",
        text: "Gracias por esto.",
        rating: 5,
      },
    ],
  },
]);

// --- Funciones ---

// Función para añadir una nueva publicación
const addPost = () => {
  if (newPostText.value.trim() === "") return;

  const newPostId = posts.value.length + 1;
  posts.value.unshift({
    id: newPostId,
    author: `Interno Anonimo #${newPostId}`,
    content: newPostText.value,
    comments: [],
  });
  newPostText.value = "";
};

// Función para añadir un comentario (recibido desde el componente hijo)
const addCommentToPost = (commentData) => {
  const post = posts.value.find((p) => p.id === commentData.postId);
  if (post) {
    post.comments.push({
      id: new Date().getTime(), // ID único para el comentario
      author: "Interno Anonimo", // Todos los comentarios son anónimos
      text: commentData.text,
      rating: commentData.rating,
    });
  }
};

// --- Manejo del Navbar ---
const body = document.getElementsByTagName("body")[0];
onMounted(() => {
  body.classList.add("blog-page"); // Puedes usar esto para estilos específicos
  body.classList.add("bg-gray-200"); // Fondo gris claro
});
onUnmounted(() => {
  body.classList.remove("blog-page");
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
        backgroundImage:
          'url(https://source.unsplash.com/random/1600x900/?hospital,calm)',
      }"
      loading="lazy"
    >
      <span class="mask bg-gradient-success opacity-6"></span>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 text-center mx-auto">
            <h1 class="text-white">Comunidad de Bienestar</h1>
            <p class="text-white">
              Un espacio seguro y anónimo para compartir experiencias.
            </p>
          </div>
        </div>
      </div>
    </div>
  </Header>

  <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6 mb-4">
    <section class="container py-5">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div class="card shadow-lg">
            <div class="card-header">
              <h5 class="mb-0">¿Qué estás pensando?</h5>
              <p class="text-sm mb-0">Tu publicación será 100% anónima.</p>
            </div>
            <div class="card-body">
              <MaterialTextArea
                id="newPost"
                v-model="newPostText"
                placeholder="Escribe tu experiencia, pide un consejo o comparte un buen momento..."
                rows="4"
              />
              <div class="d-flex justify-content-end mt-3">
                <MaterialButton
                  variant="gradient"
                  color="success"
                  @click="addPost"
                >
                  Publicar Anónimamente
                </MaterialButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="container py-3">
      <div class="row">
        <div
          v-for="post in posts"
          :key="post.id"
          class="col-lg-3 col-md-6 mb-4"
        >
          <BlogPostCard :post="post" @add-comment="addCommentToPost" />
        </div>
      </div>
    </section>
  </div>

  <FooterDefault />
</template>
