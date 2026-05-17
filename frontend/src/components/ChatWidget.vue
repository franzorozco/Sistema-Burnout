<template>
  <div class="chat-widget">
    <!-- Botón Flotante -->
    <button 
      class="chat-btn" 
      @click="toggleChat" 
      :class="{ 'is-active': isOpen }"
    >
      <i class="fas fa-comment-dots" v-if="!isOpen"></i>
      <i class="fas fa-times" v-else></i>
    </button>

    <!-- Ventana del Chat -->
    <div class="chat-window" v-if="isOpen">
      <div class="chat-header">
        <div class="d-flex align-items-center" style="display:flex; align-items:center;">
          <div class="avatar-bot me-2" style="margin-right: 10px;">
            <i class="fas fa-robot"></i>
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
import { ref, nextTick } from 'vue';
import axios from 'axios';

const isOpen = ref(false);
const newMessage = ref('');
const messages = ref([
  { role: 'bot', text: '¡Hola! Soy Laiso. Estoy aquí para escucharte y ayudarte. ¿Cómo te has sentido hoy con tus materias y rotaciones?' }
]);
const isLoading = ref(false);
const chatBody = ref(null);

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
  width: 65px;
  height: 65px;
  border-radius: 50%;
  background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
  color: white;
  border: none;
  box-shadow: 0 10px 25px rgba(124, 58, 237, 0.4);
  font-size: 26px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  display: flex;
  align-items: center;
  justify-content: center;
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
