document.addEventListener("DOMContentLoaded", () => {
  // --- Menú usuario ---
  const avatar = document.getElementById("userAvatar");
  const dropdown = document.getElementById("userDropdown");
  const toggleThemeBtn = document.getElementById("toggleTheme");

  if (avatar && dropdown) {
    avatar.addEventListener("click", () => {
      dropdown.classList.toggle("active"); // activa/desactiva el menú
    });

    // Cierra el menú si se hace clic fuera
    window.addEventListener("click", (e) => {
      if (!avatar.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.remove("active");
      }
    });
  }

  // --- Tema oscuro/claro con persistencia ---
  function aplicarTemaGuardado() {
    const tema = localStorage.getItem("tema");
    if (tema === "oscuro") document.body.classList.add("dark");
  }

  if (toggleThemeBtn) {
    toggleThemeBtn.addEventListener("click", () => {
      document.body.classList.toggle("dark");
      localStorage.setItem(
        "tema",
        document.body.classList.contains("dark") ? "oscuro" : "claro"
      );
    });
  }
  aplicarTemaGuardado();

  // --- Modal de registro ---
  const modal = document.getElementById("modal");
  const openModalBtn = document.getElementById("openModal");
  const closeModalBtn = document.getElementById("closeModal");

  if (openModalBtn && modal) {
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("active");
      limpiarFormulario(); // limpio al abrir
    });
  }

  if (closeModalBtn && modal) {
    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("active");
      limpiarFormulario(); // limpio al cerrar
    });
  }

  // Cierra el modal si se hace clic fuera del contenido
  window.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.remove("active");
      limpiarFormulario();
    }
  });

  // Función para limpiar el formulario del modal
  function limpiarFormulario() {
    const form = document.querySelector(".modal-form");
    if (form) form.reset();
  }

  // --- Simulador de phishing ---
  const correos = [
    { mensaje: "Notificación: Su cuenta de Netflix será suspendida si no actualiza el método de pago.", phishing: true },
    { mensaje: "Factura electrónica disponible en el portal oficial de la DIAN.", phishing: false },
    { mensaje: "Alerta de inicio de sesión desde un dispositivo desconocido. Revise su cuenta aquí.", phishing: true },
    { mensaje: "Confirmación de compra en Amazon. Detalles disponibles en su historial.", phishing: false },
    { mensaje: "Su universidad requiere actualizar sus credenciales para mantener acceso al correo institucional.", phishing: true },
    { mensaje: "Recibo de pago de servicios públicos disponible en la plataforma oficial.", phishing: false }
  ];

  let puntosSimulador = 0;
  let intentosSimulador = 0;

  function mostrarCorreo() {
    const correo = correos[Math.floor(Math.random() * correos.length)];
    const correoSimulado = document.getElementById("correoSimulado");
    if (correoSimulado) {
      correoSimulado.innerText = correo.mensaje;
      correoSimulado.dataset.phishing = correo.phishing;
    }
  }

  window.verificarRespuesta = function (respuesta) {
    const correoSimulado = document.getElementById("correoSimulado");
    if (!correoSimulado) return;
    const esPhishing = correoSimulado.dataset.phishing === "true";
    intentosSimulador++;
    if ((respuesta === "phishing" && esPhishing) || (respuesta === "seguro" && !esPhishing)) {
      puntosSimulador++;
      correoSimulado.insertAdjacentHTML("afterend", `<p style="color:green">✅ Correcto. Puntos: ${puntosSimulador}/${intentosSimulador}</p>`);
    } else {
      correoSimulado.insertAdjacentHTML("afterend", `<p style="color:red">⚠️ Incorrecto. Era ${esPhishing ? "phishing" : "seguro"}.</p>`);
    }
    actualizarRanking();
    mostrarCorreo();
  };

  mostrarCorreo();

  // --- Verificador de enlaces ---
  window.verificarEnlace = function () {
    const input = document.getElementById("linkInput").value.trim();
    const resultado = document.getElementById("resultadoLink");

    if (!resultado) return;

    if (input === "") {
      resultado.innerText = "⚠️ Por favor ingresa un enlace.";
      resultado.className = "url-result warning";
    } else if (input.includes("paypal") && !input.includes("paypal.com")) {
      resultado.innerText = "❌ Sospechoso: imitación de PayPal.";
      resultado.className = "url-result danger";
    } else if (input.includes("login") && !input.includes("empresa.com")) {
      resultado.innerText = "❌ Sospechoso: login falso detectado.";
      resultado.className = "url-result danger";
    } else if (input.startsWith("http://")) {
      resultado.innerText = "⚠️ El enlace no es seguro (usa HTTP).";
      resultado.className = "url-result warning";
    } else {
      resultado.innerText = "✅ El enlace parece seguro.";
      resultado.className = "url-result safe";
    }
  };

  // --- Quiz interactivo ---
  const preguntas = [
    {
      pregunta: "Recibes un correo de tu banco pidiendo tu clave. ¿Qué haces?",
      opciones: ["La ingreso en el enlace", "Ignoro y llamo al banco", "Reenvío a mis amigos"],
      correcta: 1,
      explicacion: "Los bancos nunca piden claves por correo. Siempre verifica directamente en la app oficial."
    },
    {
      pregunta: "Un enlace dice ser de PayPal pero es 'paypa1.com'. ¿Qué significa?",
      opciones: ["Es seguro", "Es phishing", "Es una nueva versión"],
      correcta: 1,
      explicacion: "El dominio está alterado. Es un intento de phishing."
    },
    {
      pregunta: "¿Cuál es una buena práctica contra el phishing?",
      opciones: ["Compartir contraseñas", "Usar autenticación de dos factores", "Ignorar actualizaciones"],
      correcta: 1,
      explicacion: "La autenticación de dos factores protege tu cuenta incluso si tu contraseña se ve comprometida."
    }
  ];

  let quizIndex = 0;
  let quizPuntos = 0;

  window.iniciarQuiz = function () {
    quizIndex = 0;
    quizPuntos = 0;
    mostrarPregunta();
  };

  function mostrarPregunta() {
    const quizContainer = document.getElementById("quizContainer");
    if (!quizContainer) return;

    if (quizIndex < preguntas.length) {
      const q = preguntas[quizIndex];
      quizContainer.innerHTML = `
        <p><strong>Pregunta ${quizIndex + 1}:</strong> ${q.pregunta}</p>
        <div class="quiz-options">
          ${q.opciones.map((op, i) => `<button onclick="responder(${i})">${op}</button>`).join("")}
        </div>
        <p>Puntaje: ${quizPuntos}/${quizIndex}</p>
      `;
    } else {
      quizContainer.innerHTML = `
        <p>🎉 Has terminado el quiz.</p>
        <p>Puntaje final: ${quizPuntos}/${preguntas.length}</p>
        <button onclick="iniciarQuiz()" class="btn-primary">Reintentar</button>
      `;
      actualizarRanking();
    }
  }

  window.responder = function (opcion) {
    const q = preguntas[quizIndex];
    const quizContainer = document.getElementById("quizContainer");

    if (opcion === q.correcta) {
      quizPuntos++;
      quizContainer.insertAdjacentHTML("beforeend", `<p class="quiz-feedback correct">✅ Correcto: ${q.explicacion}</p>`);
    } else {
      quizContainer.insertAdjacentHTML("beforeend", `<p class="quiz-feedback incorrect">⚠️ Incorrecto: ${q.explicacion}</p>`);
    }

    quizIndex++;
    setTimeout(mostrarPregunta, 1500);
  };

  // --- Recursos y tips (checklist interactivo) ---
  const checklistItems = document.querySelectorAll(".checklist input");
  checklistItems.forEach(item => {
    item.addEventListener("change", actualizarRanking);
  });

// --- Ranking global ---
function actualizarRanking() {
  const ranking = document.getElementById("rankingGlobal");
  if (!ranking) return;

  // puntos del simulador + quiz + checklist
  const checklistCount = document.querySelectorAll(".checklist input:checked").length;
  const total = puntosSimulador + quizPuntos + checklistCount;

  // Mostrar puntaje total
  ranking.innerText = `Puntos totales: ${total}`;
}

actualizarRanking();
});

