<style>
    /* --- NUEVO DISEÑO: Minimalista y Profesional --- */
    .asistente-btn {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 56px;
        height: 56px;
        border-radius: 16px; /* Cuadrado redondeado */
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #0095f6;
        font-size: 1.4rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        z-index: 1000;
        transition: all 0.2s ease;
    }
    
    .asistente-btn:hover {
        transform: translateY(-2px);
        border-color: #0095f6;
    }
    
    .asistente-chat {
        position: fixed;
        bottom: 90px;
        right: 24px;
        width: 360px;
        height: 480px;
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        display: none;
        flex-direction: column;
        z-index: 1000;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5);
    }
    
    .asistente-chat.active {
        display: flex;
    }
    
    .asistente-header {
        background: #0f172a;
        color: white;
        padding: 1rem 1.25rem;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .asistente-mensajes {
        flex: 1;
        overflow-y: auto;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .mensaje-wrapper {
        display: flex;
        gap: 0.5rem;
        max-width: 85%;
    }
    
    .mensaje-wrapper.bot {
        align-self: flex-start;
    }
    
    .mensaje-wrapper.user {
        align-self: flex-end;
        flex-direction: row-reverse;
    }
    
    .avatar {
        width: 24px;
        height: 24px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        flex-shrink: 0;
    }
    
    .avatar.bot {
        background: rgba(0, 149, 246, 0.2);
        color: #0095f6;
    }
    
    .avatar.user {
        background: rgba(255, 255, 255, 0.1);
        color: #a0a0b0;
    }
    
    .mensaje {
        padding: 0.6rem 0.9rem;
        border-radius: 12px;
        font-size: 0.9rem;
        line-height: 1.4;
    }
    
    .mensaje.bot {
        background: rgba(255, 255, 255, 0.05);
        color: #e0e0e0;
        border-top-left-radius: 2px;
    }
    
    .mensaje.user {
        background: #0095f6;
        color: white;
        border-top-right-radius: 2px;
    }
    
    .hora-mensaje {
        font-size: 0.65rem;
        color: #6c757d;
        margin-top: 0.2rem;
        display: block;
    }
    
    /* Indicador de "escribiendo..." */
    .escribiendo {
        display: flex;
        gap: 4px;
        padding: 0.6rem 0.9rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        width: fit-content;
    }
    
    .escribiendo span {
        width: 6px;
        height: 6px;
        background: #6c757d;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out both;
    }
    
    .escribiendo span:nth-child(1) { animation-delay: -0.32s; }
    .escribiendo span:nth-child(2) { animation-delay: -0.16s; }
    
    @keyframes typing {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
    
    /* Botones de sugerencia rápida */
    .sugerencias {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        padding: 0 1.25rem 0.75rem;
    }
    
    .sugerencia-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #a0a0b0;
        padding: 0.3rem 0.6rem;
        border-radius: 20px;
        font-size: 0.7rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .sugerencia-btn:hover {
        background: rgba(0, 149, 246, 0.1);
        border-color: #0095f6;
        color: #0095f6;
    }
    
    .asistente-input {
        display: flex;
        padding: 0.75rem 1.25rem;
        gap: 0.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        background: #0f172a;
    }
    
    .asistente-input input {
        flex: 1;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        color: white;
        font-size: 0.85rem;
    }
    
    .asistente-input input:focus {
        outline: none;
        border-color: #0095f6;
        background: rgba(255, 255, 255, 0.08);
    }
    
    .asistente-input button {
        background: #0095f6;
        border: none;
        border-radius: 8px;
        width: 38px;
        height: 38px;
        color: white;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .asistente-input button:hover {
        background: #0077cc;
    }
</style>

<!-- Botón flotante -->
<button class="asistente-btn" id="asistenteBtn" title="¿Necesitas ayuda?">
    <i class="bi bi-chat-dots"></i>
</button>

<!-- Ventana del chat -->
<div class="asistente-chat" id="asistenteChat">
    <div class="asistente-header">
        <span><i class="bi bi-robot me-2"></i>HardBot</span>
        <button class="btn-close btn-close-white" id="asistenteCerrar"></button>
    </div>
    
    <div class="asistente-mensajes" id="asistenteMensajes">
        <div class="mensaje-wrapper bot">
            <div class="avatar bot"><i class="bi bi-robot"></i></div>
            <div>
                <div class="mensaje bot">¡Hola! Soy HardBot. ¿En qué puedo ayudarte hoy?</div>
                <span class="hora-mensaje" id="horaInicial"></span>
            </div>
        </div>
    </div>
    
    @auth
        <div class="sugerencias">
            <button class="sugerencia-btn" onclick="enviarSugerencia('¿Cuánto cuesta el Ryzen 5 5600X?')">Precio de Ryzen 5</button>
            <button class="sugerencia-btn" onclick="enviarSugerencia('Quiero armar una PC de 1000 dólares')">Armar PC</button>
            <button class="sugerencia-btn" onclick="enviarSugerencia('¿Qué productos tienen?')">Ver productos</button>
        </div>
        
        <form class="asistente-input" id="asistenteForm">
            @csrf
            <input type="text" id="asistentePregunta" placeholder="Escribe tu pregunta..." autocomplete="off" maxlength="200">
            <button type="submit"><i class="bi bi-send"></i></button>
        </form>
    @else
        <div class="p-3 text-center text-muted" style="border-top: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.85rem;">
            <i class="bi bi-lock me-1"></i> Inicia sesión para usar el asistente.
        </div>
    @endauth
</div>

<script>
    // 1. Hacemos la función global para que los botones HTML puedan encontrarla
    window.enviarSugerencia = function(texto) {
        const input = document.getElementById('asistentePregunta');
        if (input) {
            input.value = texto;
            const form = document.getElementById('asistenteForm');
            if (form) {
                // Disparamos el submit manualmente
                form.dispatchEvent(new Event('submit', { cancelable: true }));
            }
        }
    };

    // 2. Función para agregar mensajes al chat
    function agregarMensaje(texto, tipo) {
        const contenedor = document.getElementById('asistenteMensajes');
        if (!contenedor) return;

        const ahora = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        const wrapper = document.createElement('div');
        wrapper.className = `mensaje-wrapper ${tipo}`;
        
        const avatar = document.createElement('div');
        avatar.className = `avatar ${tipo}`;
        avatar.innerHTML = tipo === 'bot' ? '<i class="bi bi-robot"></i>' : '<i class="bi bi-person"></i>';
        
        const contentDiv = document.createElement('div');
        const msgDiv = document.createElement('div');
        msgDiv.className = `mensaje ${tipo}`;
        msgDiv.textContent = texto;
        
        const timeSpan = document.createElement('span');
        timeSpan.className = 'hora-mensaje';
        timeSpan.textContent = ahora;
        
        contentDiv.appendChild(msgDiv);
        contentDiv.appendChild(timeSpan);
        wrapper.appendChild(avatar);
        wrapper.appendChild(contentDiv);
        
        contenedor.appendChild(wrapper);
        contenedor.scrollTop = contenedor.scrollHeight;
    }

    // 3. Indicador de "escribiendo..."
    function mostrarEscribiendo() {
        const contenedor = document.getElementById('asistenteMensajes');
        const div = document.createElement('div');
        div.className = 'mensaje-wrapper bot';
        div.id = 'typingIndicator';
        div.innerHTML = `
            <div class="avatar bot"><i class="bi bi-robot"></i></div>
            <div class="escribiendo"><span></span><span></span><span></span></div>
        `;
        contenedor.appendChild(div);
        contenedor.scrollTop = contenedor.scrollHeight;
    }

    function ocultarEscribiendo() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) indicator.remove();
    }

    // 4. Lógica del chat
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('asistenteChat');
        const btnAsistente = document.getElementById('asistenteBtn');
        const btnCerrar = document.getElementById('asistenteCerrar');
        const asistenteForm = document.getElementById('asistenteForm');

        if (btnAsistente) {
            btnAsistente.addEventListener('click', () => chatContainer.classList.toggle('active'));
        }
        if (btnCerrar) {
            btnCerrar.addEventListener('click', () => chatContainer.classList.remove('active'));
        }

        if (asistenteForm) {
            asistenteForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Evita la recarga
                
                const input = document.getElementById('asistentePregunta');
                const pregunta = input.value.trim();
                
                if (!pregunta) return;
                
                agregarMensaje(pregunta, 'user');
                input.value = '';
                mostrarEscribiendo();
                
                fetch('{{ route("asistente.consulta") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ pregunta: pregunta })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error en el servidor');
                    return response.json();
                })
                .then(data => {
                    ocultarEscribiendo();
                    agregarMensaje(data.respuesta, 'bot');
                })
                .catch(error => {
                    ocultarEscribiendo();
                    agregarMensaje('Error de conexión. Intenta de nuevo.', 'bot');
                    console.error('Error:', error);
                });
            });
        }
    });
</script>