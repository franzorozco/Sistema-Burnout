<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Burnout IA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Inter", sans-serif;
    }

    body {
        background: #ffffff;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* ---------------- NAVBAR ---------------- */
    nav {
        width: 100%;
        background: #ffffff;
        padding: 14px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e5e5;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    nav .logo {
        font-size: 20px;
        font-weight: 700;
        color: #2e7d32;
        letter-spacing: 0.5px;
    }

    nav ul {
        list-style: none;
        display: flex;
        gap: 20px;
    }

    nav ul li a {
        text-decoration: none;
        color: #1f1f1f;
        font-size: 15px;
        transition: 0.2s;
        font-weight: 500;
    }

    nav ul li a:hover {
        color: #2e7d32;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        nav {
            padding: 12px 20px;
        }

        nav ul {
            gap: 12px;
        }
    }

    /* ------------------------------------------- */

    /* WRAPPER DEL CHAT (AJUSTADO POR NAVBAR) */
    .chat-container {
        width: 60%;
        max-width: 900px;
        height: calc(100vh - 70px); /* evita que la navbar tape el chat */
        margin-top: 70px;
        display: flex;
        flex-direction: column;
        padding: 20px 0;
    }

    @media (max-width: 768px) {
        .chat-container {
            width: 90%;
        }
    }

    /* CONTENEDOR DEL CHAT */
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 15px 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: #ffffff;
    }

    /* MENSAJES */
    .message {
        width: 100%;
        display: flex;
        justify-content: center;
        opacity: 0;
        animation: fadeIn 0.25s forwards ease-out;
    }

    @keyframes fadeIn { to { opacity: 1; } }

    .bubble {
        max-width: 720px;
        width: 100%;
        font-size: 16px;
        line-height: 1.6;
        color: #2c2c2c;
        padding: 10px 4px;
        border-radius: 8px;
        background: transparent;
    }

    /* Usuario */
    .message.user .bubble {
        text-align: right;
        color: #2e7d32;
        font-weight: 600;
    }

    /* Bot */
    .message.bot .bubble {
        text-align: left;
        color: #1f1f1f;
    }

    .typing {
        font-style: italic;
        color: #777;
        padding: 8px;
        font-size: 14px;
    }

    /* INPUT */
    .chat-input {
        display: flex;
        gap: 12px;
        padding: 15px 0;
        background: #ffffff;
    }

    .chat-input input {
        flex: 1;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #ddd;
        background: white;
        font-size: 16px;
        outline: none;
        transition: 0.2s;
    }

    .chat-input input:focus {
        border-color: #4caf50;
    }

    .chat-input button {
        padding: 14px 24px;
        border-radius: 12px;
        border: none;
        background: #4caf50;
        color: white;
        font-size: 15px;
        cursor: pointer;
        transition: 0.2s;
    }

    .chat-input button:hover {
        background: #3c8b40;
    }
</style> 
</head>
<body>

<!-- ================== NAVBAR ================== -->
<nav>
    <div class="logo">Burnout IA</div>
    <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Chat</a></li>
        <li><a href="#">Guía</a></li>
        <li><a href="#">Contacto</a></li>
    </ul>
</nav>
<!-- ============================================ -->

<div class="chat-container">
    <div class="chat-messages" id="chatMessages"></div>

    <div class="chat-input">
        <input type="text" id="query" placeholder="Escribe tu consulta…">
        <button id="sendBtn">Enviar</button>
    </div>
</div>

<script>
    const chatMessages = document.getElementById('chatMessages');
    const sendBtn = document.getElementById('sendBtn');
    const queryInput = document.getElementById('query');

    function addMessage(text, sender) {
        const normalized = text
            .replace(/\*\*/g, '')
            .replace(/\*/g, '')
            .replace(/\n/g, '<br>');

        const msg = document.createElement('div');
        msg.classList.add('message', sender);

        const bubble = document.createElement('div');
        bubble.classList.add('bubble');
        bubble.innerHTML = normalized;

        msg.appendChild(bubble);
        chatMessages.appendChild(msg);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addTyping() {
        const typing = document.createElement('div');
        typing.classList.add('typing');
        typing.id = 'typingIndicator';
        typing.textContent = "Laiso está escribiendo...";
        chatMessages.appendChild(typing);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeTyping() {
        const typing = document.getElementById('typingIndicator');
        if (typing) typing.remove();
    }

    async function sendQuery() {
        const query = queryInput.value.trim();
        if (!query) return;

        addMessage(query, 'user');
        queryInput.value = '';
        addTyping();

        try {
            const response = await fetch("{{ url('/chat/ask') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ query })
            });

            const raw = await response.text();
            let data;

            try {
                data = JSON.parse(raw);
            } catch {
                removeTyping();
                addMessage("⚠️ Error: el servidor devolvió HTML.", "bot");
                return;
            }

            removeTyping();
            addMessage(data.answer || "⚠️ Respuesta inválida del servidor.", "bot");

        } catch (error) {
            removeTyping();
            addMessage("⚠️ Error al conectar con el servidor.", "bot");
        }
    }

    sendBtn.addEventListener("click", sendQuery);
    queryInput.addEventListener("keypress", e => {
        if (e.key === "Enter") {
            e.preventDefault();
            sendQuery();
        }
    });
</script>

</body>
</html>
