<template>
  <div class="chat-widget">
    <!-- Botón Flotante -->
    <button 
      class="chat-btn" 
      @click="toggleChat" 
      :class="{ 'is-active': isOpen }"
      style="padding: 0; overflow: visible; background: transparent; border: none; box-shadow: none; position: relative;"
    >
      <!-- Burbuja de Saludo Flotante -->
      <div v-if="!isOpen && showGreeting" class="mascot-greeting fade-in-out">
        {{ currentGreeting }}
      </div>
      
      <img v-if="!isOpen" src="/laiso_robot_final.png" style="width: 140px; height: 140px; object-fit: contain; filter: drop-shadow(0 15px 15px rgba(0,0,0,0.3)); animation: greetMascot 4s ease-in-out infinite; transform-origin: bottom center;">
      <div v-else style="width: 65px; height: 65px; border-radius: 50%; background: linear-gradient(135deg, #00BCD4 0%, #2196F3 50%, #9C27B0 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4);">
        <i class="fas fa-times" style="color: white; font-size: 26px;"></i>
      </div>
    </button>

    <!-- Ventana del Chat -->
    <div class="chat-window" v-if="isOpen">
      <div class="chat-header">
        <div class="d-flex align-items-center" style="display:flex; align-items:center;">
          <div class="avatar-bot me-2 bg-transparent" style="margin-right: 10px; width: 55px; height: 55px;">
            <img src="/laiso_logo.png" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
          </div>
          <div>
            <h6 class="mb-0 text-white" style="margin: 0; color: white;">Laiso</h6>
            <small style="color: rgba(255,255,255,0.7);">Asistente contra el Burnout</small>
          </div>
        </div>
      </div>
      
      <div class="chat-body" ref="chatBody">
        <div 
          v-for="(msg, index) in messages" 
          :key="index" 
          :class="['message-wrapper', msg.role === 'user' ? 'user' : 'bot']"
        >
          <div class="message-content">
            {{ msg.text }}
          </div>
        </div>
        
        <div v-if="isLoading" class="message-wrapper bot">
          <div class="message-content typing-indicator">
            <span></span><span></span><span></span>
          </div>
        </div>
      </div>

      <div class="chat-footer">
        <input 
          type="text" 
          v-model="newMessage" 
          @keyup.enter="sendMessage"
          placeholder="Escribe tu mensaje..." 
          class="chat-input"
          :disabled="isLoading"
        />
        <button class="send-btn" @click="sendMessage" :disabled="isLoading || !newMessage.trim()">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, nextTick, onMounted, onUnmounted } from 'vue';
import axios from 'axios';

const isOpen = ref(false);
const newMessage = ref('');
const messages = ref([
  { role: 'bot', text: '¡Hola! Soy Laiso. Estoy aquí para escucharte y ayudarte. ¿Cómo te has sentido hoy con tus materias y rotaciones?' }
]);
const isLoading = ref(false);
const chatBody = ref(null);

const greetings = [
  "¡Hola! ¿Necesitas ayuda? 👋",
  "Estoy aquí para escucharte 😊",
  "¿Cómo te sientes hoy? 💙",
  "Hablemos sobre tu bienestar 🧘"
];
const currentGreeting = ref(greetings[0]);
const showGreeting = ref(true);
let greetingInterval;

onMounted(() => {
  let index = 0;
  greetingInterval = setInterval(() => {
    showGreeting.value = false;
    setTimeout(() => {
      index = (index + 1) % greetings.length;
      currentGreeting.value = greetings[index];
      showGreeting.value = true;
    }, 500); // Pequeña pausa antes de mostrar el nuevo mensaje
  }, 6000); // Cambiar cada 6 segundos
});

onUnmounted(() => {
  clearInterval(greetingInterval);
});

const toggleChat = () => {
  isOpen.value = !isOpen.value;
  if(isOpen.value) {
    scrollToBottom();
  }
};

const scrollToBottom = async () => {
  await nextTick();
  if (chatBody.value) {
    chatBody.value.scrollTop = chatBody.value.scrollHeight;
  }
};

const sendMessage = async () => {
  if (!newMessage.value.trim() || isLoading.value) return;

  const userText = newMessage.value.trim();
  messages.value.push({ role: 'user', text: userText });
  newMessage.value = '';
  isLoading.value = true;
  scrollToBottom();

  try {
    const response = await axios.post('http://127.0.0.1:8001/ask', {
      query: userText,
      session_id: 'sesion_frontend_1',
      user_id: null
    });

    messages.value.push({ role: 'bot', text: response.data.answer });
  } catch (error) {
    console.error('Error al contactar con Laiso:', error);
    messages.value.push({ 
      role: 'bot', 
      text: 'Lo siento, tuve un problema de conexión con el servidor. Verifica que el backend de IA esté encendido.' 
    });
  } finally {
    isLoading.value = false;
    scrollToBottom();
  }
};
</script>

<style scoped>
.chat-widget {
  position: fixed;
  bottom: 30px;
  right: 30px;
  z-index: 9999;
  font-family: 'Inter', system-ui, sans-serif;
}

.chat-btn {
  width: auto;
  height: auto;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  display: flex;
  align-items: center;
  justify-content: center;
  outline: none;
}

.chat-btn:hover {
  transform: scale(1.08) translateY(-5px);
  box-shadow: 0 15px 30px rgba(124, 58, 237, 0.5);
}

.chat-window {
  position: absolute;
  bottom: 85px;
  right: 0;
  width: 360px;
  height: 550px;
  background: #f8fafc;
  border-radius: 20px;
  box-shadow: 0 15px 40px rgba(0,0,0,0.15);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  animation: slideUp 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(30px) scale(0.95); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

.chat-header {
  background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
  padding: 20px;
  color: white;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  z-index: 2;
}

.avatar-bot {
  width: 45px;
  height: 45px;
  background: rgba(255,255,255,0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  backdrop-filter: blur(5px);
}

.chat-body {
  flex: 1;
  padding: 20px;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 15px;
  scroll-behavior: smooth;
}

.message-wrapper {
  display: flex;
  max-width: 85%;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.message-wrapper.user {
  align-self: flex-end;
}

.message-wrapper.bot {
  align-self: flex-start;
}

.message-content {
  padding: 14px 18px;
  border-radius: 18px;
  font-size: 15px;
  line-height: 1.5;
  word-wrap: break-word;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.user .message-content {
  background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
  color: white;
  border-bottom-right-radius: 4px;
}

.bot .message-content {
  background: white;
  color: #334155;
  border: 1px solid #e2e8f0;
  border-bottom-left-radius: 4px;
}

.chat-footer {
  padding: 15px 20px;
  background: white;
  border-top: 1px solid #f1f5f9;
  display: flex;
  gap: 12px;
  z-index: 2;
}

.chat-input {
  flex: 1;
  padding: 12px 18px;
  background: #f1f5f9;
  border: 1px solid transparent;
  border-radius: 25px;
  outline: none;
  font-size: 15px;
  transition: all 0.3s;
}

.chat-input:focus {
  background: white;
  border-color: #6366f1;
  box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.send-btn {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  background: #4f46e5;
  color: white;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
}

.send-btn:hover:not(:disabled) {
  background: #4338ca;
  transform: scale(1.05);
}

.send-btn:active:not(:disabled) {
  transform: scale(0.95);
}

.send-btn:disabled {
  background: #cbd5e1;
  box-shadow: none;
  cursor: not-allowed;
}

/* Typing Indicator */
.typing-indicator {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 16px 20px !important;
}

.typing-indicator span {
  width: 7px;
  height: 7px;
  background: #94a3b8;
  border-radius: 50%;
  animation: bounce 1.4s infinite ease-in-out both;
}

.typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
.typing-indicator span:nth-child(2) { animation-delay: -0.16s; }

@keyframes bounce {
  0%, 80%, 100% { transform: scale(0); opacity: 0.5; }
  40% { transform: scale(1); opacity: 1; }
}

/* Animación de Mascota Saludando */
@keyframes greetMascot {
  0% { transform: translateY(0px) rotate(0deg); }
  20% { transform: translateY(-12px) rotate(-10deg); }
  40% { transform: translateY(-8px) rotate(12deg); }
  60% { transform: translateY(-12px) rotate(-8deg); }
  80% { transform: translateY(-4px) rotate(5deg); }
  100% { transform: translateY(0px) rotate(0deg); }
}

/* Burbuja de saludo flotante */
.mascot-greeting {
  position: absolute;
  top: -45px;
  right: 50px;
  background: white;
  padding: 8px 15px;
  border-radius: 15px;
  border-bottom-right-radius: 0;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  font-size: 13px;
  color: #334155;
  font-weight: 600;
  white-space: nowrap;
  pointer-events: none;
  animation: floatMascot 3.5s ease-in-out infinite;
}

@keyframes floatMascot {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-8px); }
  100% { transform: translateY(0px); }
}

.fade-in-out {
  animation: fadeInOut 5.5s infinite;
}

@keyframes fadeInOut {
  0% { opacity: 0; transform: translateY(10px); }
  10% { opacity: 1; transform: translateY(0); }
  90% { opacity: 1; transform: translateY(0); }
  100% { opacity: 0; transform: translateY(-10px); }
}

/* Scrollbar personalizada */
.chat-body::-webkit-scrollbar {
  width: 6px;
}
.chat-body::-webkit-scrollbar-track {
  background: transparent;
}
.chat-body::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 10px;
}
</style>
