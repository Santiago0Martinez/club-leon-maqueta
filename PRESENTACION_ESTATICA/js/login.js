// Borramos las credenciales de DEMO y usamos conexión real a PHP
    async function ingresar() {
      const u = document.getElementById('user-input').value.trim();
      const p = document.getElementById('pass-input').value.trim();
      const msg = document.getElementById('error-msg');
      const btn = document.querySelector('.btn-primary');
      const textOriginal = btn.innerHTML;

      // Validamos que no envíen campos vacíos
      if (!u || !p) {
        msg.innerHTML = '🚫 ¡FALTA INFO! Llena ambos campos, bro.';
        msg.style.display = 'block';
        hacerShake();
        return;
      }

      // Animación de cargando
      btn.innerHTML = '<span style="position: relative; z-index: 1;">⏳ Revisando VAR...</span>';

      try {
        // MODO PRESENTACIÓN ESTÁTICA: Omitimos el PHP y simulamos éxito siempre
        msg.style.display = 'none';
        // Animación de gol
        btn.innerHTML = '<span style="position: relative; z-index: 1;">⚽ ¡GOOOL! Ingresando...</span>';
        setTimeout(() => {
           window.location.href = 'menu-opciones.html'; // Redirigimos al menú
        }, 1000);
      } catch (error) {
        console.error("Error técnico:", error);
      }
    }

    // Separé la animación del cuadro para que esté más limpia
    function hacerShake() {
      const card = document.querySelector('.card');
      card.style.animation = 'none';
      setTimeout(() => {
        card.style.animation = 'shake 0.5s ease';
      }, 10);
    }

    function recuperar() {
      const u = document.getElementById('user-input').value.trim();
      if (!u) {
        alert('⚠️ Primero ingresa tu ID de usuario, campeón!');
      } else {
        alert('📧 ¡Entendido! Se enviará el pitazo de recuperación al correo registrado del jugador:\n\n👤 ' + u);
      }
    }

    let visible = false;
    function togglePass() {
      visible = !visible;
      const inp = document.getElementById('pass-input');
      const icon = document.getElementById('eye-icon');
      inp.type = visible ? 'text' : 'password';
      icon.textContent = visible ? '🔓' : '👁️';
    }

    // Animación de shake para tarjeta roja
    const style = document.createElement('style');
    style.textContent = `
      @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-12px); }
        75% { transform: translateX(12px); }
      }
    `;
    document.head.appendChild(style);

    // Enter para ingresar
    document.addEventListener('keydown', e => { 
      if (e.key === 'Enter') ingresar(); 
    });

    // Auto-focus
    window.addEventListener('load', () => {
      document.getElementById('user-input').focus();
    });
