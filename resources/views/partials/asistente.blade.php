<style>
    .asistente-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        border: none;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 149, 246, 0.4);
        cursor: pointer;
        z-index: 1000;
        transition: transform 0.2s;
    }
    
    .asistente-btn:hover {
        transform: scale(1.1);
    }
    
    .asistente-chat {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 350px;
        height: 450px;
        background: rgba(15, 25, 45, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(0, 149, 246, 0.3);
        border-radius: 1.5rem;
        display: none;
        flex-direction: column;
        z-index: 1000;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }
    
    .asistente-chat.active {
        display: flex;
    }
    
    .asistente-header {
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        color: white;
        padding: 1rem;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .asistente-mensajes {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .mensaje {
        padding: 0.6rem 1rem;
        border-radius: 1rem;
        max-width: 80%;
        font-size: 0.85rem;
    }
    
    .mensaje.bot {
        background: rgba(0, 149, 246, 0.15);
        color: #e0e0e0;
        align-self: flex-start;
    }
    
    .mensaje.user {
        background: rgba(0, 149, 246, 0.3);
        color: white;
        align-self: flex-end;
    }
    
    .asistente-input {
        display: flex;
        padding: 0.75rem;
        gap: 0.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .asistente-input input {
        flex: 1;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 2rem;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.85rem;
    }
    
    .asistente-input input:focus {
        outline: none;
        border-color: #0095f6;
    }
    
    .asistente-input button {
        background: #0095f6;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        color: white;
        cursor: pointer;
    }
</style>

<!-- Botón flotante -->
<button class="asistente-btn" id="asistenteBtn" title="¿Necesitas ayuda?">
    <i class="bi bi-chat-dots"></i>
</button>

<!-- Ventana del chat -->
<div class="asistente-chat" id="asistenteChat">
    <div class="asistente-header">
        <span><i class="bi bi-robot me-2"></i>Asistente HardStore</span>
        <button class="btn-close btn-close-white" id="asistenteCerrar"></button>
    </div>
    <div class="asistente-mensajes" id="asistenteMensajes">
        <div class="mensaje bot">¡Hola! Soy tu asistente virtual. ¿En qué puedo ayudarte?</div>
    </div>
    <form class="asistente-input" id="asistenteForm">
        @csrf
        <input type="text" id="asistentePregunta" placeholder="Escribe tu pregunta..." autocomplete="off">
        <button type="submit"><i class="bi bi-send"></i></button>
    </form>
</div>

<script>
    document.getElementById('asistenteBtn').addEventListener('click', function() {
        document.getElementById('asistenteChat').classList.toggle('active');
    });
    
    document.getElementById('asistenteCerrar').addEventListener('click', function() {
        document.getElementById('asistenteChat').classList.remove('active');
    });
    
    document.getElementById('asistenteForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const input = document.getElementById('asistentePregunta');
        const pregunta = input.value.trim();
        if (!pregunta) return;
        
        // Mostrar mensaje del usuario
        agregarMensaje(pregunta, 'user');
        input.value = '';
        
        // Enviar al servidor
        fetch('{{ route("asistente.consulta") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ pregunta: pregunta })
        })
        .then(response => response.json())
        .then(data => {
            agregarMensaje(data.respuesta, 'bot');
        })
        .catch(error => {
            agregarMensaje('Lo siento, hubo un error. Intenta de nuevo.', 'bot');
        });
    });
    
    function agregarMensaje(texto, tipo) {
        const contenedor = document.getElementById('asistenteMensajes');
        const div = document.createElement('div');
        div.className = 'mensaje ' + tipo;
        div.textContent = texto;
        contenedor.appendChild(div);
        contenedor.scrollTop = contenedor.scrollHeight;
    }
</script>