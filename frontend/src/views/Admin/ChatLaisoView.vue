<script setup>
import { ref, onMounted, nextTick } from 'vue';
import axios from 'axios';

const messages = ref([]);
const inputMessage = ref('');
const isTyping = ref(false);
const chatContainer = ref(null);
const sessionId = ref('admin_session_' + Date.now()); // Simular una sesión única para pruebas

const scrollToBottom = async () => {
  await nextTick();
  if (chatContainer.value) {
    chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
  }
};

const sendMessage = async () => {
  if (!inputMessage.value.trim()) return;

  const userText = inputMessage.value;
  messages.value.push({ role: 'user', text: userText });
  inputMessage.value = '';
  isTyping.value = true;
  scrollToBottom();

  try {
    const user = JSON.parse(localStorage.getItem('user'));
    // Enviar al servicio RAG de Python
    const response = await axios.post('http://127.0.0.1:8001/ask', {
      query: userText,
      session_id: sessionId.value,
      user_id: user ? user.id : null
    });

    messages.value.push({ role: 'bot', text: response.data.answer });
  } catch (error) {
    messages.value.push({ role: 'bot', text: 'Error de conexión con Laiso. Asegúrate de que el motor de IA esté encendido.' });
  } finally {
    isTyping.value = false;
    scrollToBottom();
  }
};

onMounted(() => {
  messages.value.push({ role: 'bot', text: 'Hola, soy Laiso, tu asistente de inteligencia artificial para la salud mental. ¿En qué te puedo ayudar hoy?' });
});
</script>

<template>
  <div class="row fade-in h-100">
    <div class="col-12 h-100 d-flex flex-column">
      <div class="card shadow-lg border-0 premium-chat-card flex-grow-1 d-flex flex-column" style="height: 80vh;">
        <!-- Cabecera del Chat -->
        <div class="card-header pb-0 bg-transparent border-0 d-flex align-items-center" style="border-bottom: 1px solid rgba(0,0,0,0.05) !important; padding-bottom: 15px;">
          <div class="avatar me-3 d-flex align-items-center justify-content-center bg-transparent" style="width: 75px; height: 75px;">
            <img src="/laiso_logo.png" alt="Laiso" style="width: 100%; height: 100%; object-fit: contain;">
          </div>
          <div>
            <h5 class="font-weight-bolder text-info mb-0">Centro de Inteligencia Laiso</h5>
            <p class="text-sm text-secondary mb-0 d-flex align-items-center">
              <span class="status-indicator me-2" style="background-color: #03A9F4; box-shadow: 0 0 8px #03A9F4;"></span> Conectado al motor LLaMA 3.2 y Base de Conocimientos
            </p>
          </div>
        </div>

        <!-- Área de Mensajes -->
        <div class="card-body px-4 pt-4 pb-2 flex-grow-1 overflow-auto" ref="chatContainer" style="background-color: #f8f9fa;">
          <div v-for="(msg, index) in messages" :key="index" class="d-flex w-100 mb-4" :class="msg.role === 'user' ? 'justify-content-end' : 'justify-content-start'">
            
            <!-- Mensaje de Laiso -->
            <div v-if="msg.role === 'bot'" class="d-flex">
              <div class="avatar me-3 d-flex align-items-center justify-content-center bg-transparent" style="width: 55px; height: 55px; margin-top: -10px;">
                <img src="/laiso_logo.png" alt="Laiso" style="width: 100%; height: 100%; object-fit: contain;">
              </div>
              <div class="msg-bubble bot-bubble shadow-sm p-3 border-radius-lg">
                <p class="text-sm mb-0 text-dark">{{ msg.text }}</p>
              </div>
            </div>

            <!-- Mensaje del Usuario -->
            <div v-else class="d-flex">
              <div class="msg-bubble user-bubble shadow-sm p-3 border-radius-lg bg-gradient-dynamic text-white">
                <p class="text-sm mb-0">{{ msg.text }}</p>
              </div>
              <div class="avatar avatar-sm ms-3 bg-gradient-dark shadow-sm d-flex align-items-center justify-content-center" style="border-radius: 50%; min-width: 36px; height: 36px;">
                <i class="material-icons text-white fs-6">person</i>
              </div>
            </div>

          </div>

          <!-- Indicador de Escribiendo -->
          <div v-if="isTyping" class="d-flex w-100 mb-4 justify-content-start fade-in">
            <div class="avatar me-3 d-flex align-items-center justify-content-center bg-transparent" style="width: 55px; height: 55px; margin-top: -10px;">
              <img src="/laiso_logo.png" alt="Laiso" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <div class="msg-bubble bot-bubble shadow-sm p-3 border-radius-lg d-flex align-items-center">
              <div class="typing-dot"></div>
              <div class="typing-dot"></div>
              <div class="typing-dot"></div>
            </div>
          </div>
        </div>

        <!-- Input del Chat -->
        <div class="card-footer bg-white border-0 pt-3 pb-3 px-4" style="border-top: 1px solid rgba(0,0,0,0.05) !important;">
          <form @submit.prevent="sendMessage" class="d-flex align-items-center">
            <div class="input-group input-group-outline w-100 me-3 bg-light" style="border-radius: 20px;">
              <input type="text" class="form-control px-3" placeholder="Escribe tu consulta médica o emocional..." v-model="inputMessage" :disabled="isTyping" style="border-radius: 20px; border: none; background: transparent;">
            </div>
            <button type="submit" class="btn shadow-dynamic mb-0 d-flex align-items-center justify-content-center rounded-circle hover-scale-btn bg-gradient-dynamic" style="width: 45px; height: 45px; padding: 0; transition: transform 0.2s;" :disabled="isTyping || !inputMessage.trim()">
              <i class="material-icons text-white">send</i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.fade-in {
  animation: fadeIn 0.4s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.premium-chat-card {
  background: rgba(255, 255, 255, 0.95) !important;
  backdrop-filter: blur(10px);
  border-radius: 20px;
  overflow: hidden;
}

.msg-bubble {
  max-width: 75%;
  line-height: 1.5;
}

.bot-bubble {
  background-color: #ffffff;
  border-bottom-left-radius: 4px;
}

.user-bubble {
  border-bottom-right-radius: 4px;
}

.status-indicator {
  width: 10px;
  height: 10px;
  background-color: #03A9F4;
  border-radius: 50%;
  display: inline-block;
  box-shadow: 0 0 8px #03A9F4;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { box-shadow: 0 0 0 0 rgba(3, 169, 244, 0.4); }
  70% { box-shadow: 0 0 0 6px rgba(3, 169, 244, 0); }
  100% { box-shadow: 0 0 0 0 rgba(3, 169, 244, 0); }
}

/* Typing animation */
.typing-dot {
  width: 6px;
  height: 6px;
  background-color: #03A9F4;
  border-radius: 50%;
  margin: 0 3px;
  animation: bounce 1.3s linear infinite;
}

.typing-dot:nth-child(2) { animation-delay: -1.1s; }
.typing-dot:nth-child(3) { animation-delay: -0.9s; }

@keyframes bounce {
  0%, 60%, 100% { transform: translateY(0); }
  30% { transform: translateY(-4px); }
}

/* Gradiente Dinámico de Tres Colores */
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

.hover-scale-btn:hover:not(:disabled) {
  transform: scale(1.1) !important;
}
</style>
