<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Burnout IA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f0f4f7; }
        .chat-container {
            max-width: 600px; margin: 50px auto; background: #fff;
            border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex; flex-direction: column; height: 80vh;
        }
        .chat-messages {
            flex: 1; padding: 20px; overflow-y: auto;
        }
        .message {
            display: flex; margin-bottom: 15px; opacity: 0;
            animation: fadeIn 0.3s forwards;
        }
        @keyframes fadeIn { to { opacity: 1; } }
        .message.user { justify-content: flex-end; }
        .message .bubble {
            max-width: 75%; padding: 12px 18px; border-radius: 20px; line-height: 1.4;
        }
        .message.user .bubble {
            background-color: #0d6efd; color: white; border-bottom-right-radius: 0;
        }
        .message.bot .bubble {
            background-color: #e9ecef; color: #333; border-bottom-left-radius: 0;
        }
        .chat-input {
            padding: 15px; border-top: 1px solid #ddd; display: flex; gap: 10px;
        }
        .typing {
            font-style: italic; color: #888; margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-messages" id="chatMessages"></div>

    <div class="chat-input">
        <input type="text" id="query" class="form-control" placeholder="Escribe tu pregunta sobre burnout..." required>
        <button id="sendBtn" class="btn btn-primary">Enviar</button>
    </div>
</div>

<script>
    const chatMessages = document.getElementById('chatMessages');
    const sendBtn = document.getElementById('sendBtn');
    const queryInput = document.getElementById('query');

    function addMessage(text, sender) {
        const msg = document.createElement('div');
        msg.classList.add('message', sender);

        const bubble = document.createElement('div');
        bubble.classList.add('bubble');
        bubble.textContent = text;

        msg.appendChild(bubble);
        chatMessages.appendChild(msg);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addTyping() {
        const typing = document.createElement('div');
        typing.classList.add('typing');
        typing.id = 'typingIndicator';
        typing.textContent = 'Laiso está escribiendo...';
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
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ query })
        });

        const raw = await response.text();

        let data;
        try {
            data = JSON.parse(raw);
        } catch {
            removeTyping();
            addMessage("⚠️ El servidor devolvió HTML en vez de JSON (error interno).", "bot");
            console.error("HTML RECIBIDO:", raw);
            return;
        }

        removeTyping();
        addMessage(data.answer || "⚠️ No se recibió respuesta válida del RAG.", "bot");

    } catch (error) {
        removeTyping();
        addMessage("Error al conectar con el servidor.", 'bot');
        console.error(error);
    }
}


    sendBtn.addEventListener('click', sendQuery);

    queryInput.addEventListener('keypress', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendQuery();
        }
    });
</script>
</body>
</html>