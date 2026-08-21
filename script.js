// -----------------------------
// Script principal de PhishGuard
// -----------------------------

document.addEventListener("DOMContentLoaded", () => {
  // --- Modal (abrir/cerrar) ---
  const openModalBtn = document.getElementById("openModal");
  const modal = document.getElementById("modal");
  const closeModalBtn = document.getElementById("closeModal");

  if (openModalBtn && modal && closeModalBtn) {
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("active");
    });

    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("active");
    });

    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.remove("active");
      }
    });
  }

  // --- Simulador de phishing ---
  const correos = [
    { mensaje: "Tu cuenta bancaria ha sido bloqueada. Haz clic aquí para verificar.", phishing: true },
    { mensaje: "Factura de tu servicio de internet disponible en el portal oficial.", phishing: false },
    { mensaje: "¡Ganaste un premio! Ingresa tus datos personales para reclamarlo.", phishing: true },
    { mensaje: "Actualización de software disponible en la página oficial.", phishing: false }
  ];

  let puntos = 0;

  function mostrarCorreo() {
    const correo = correos[Math.floor(Math.random() * correos.length)];
    const correoSimulado = document.getElementById("correoSimulado");
    if (correoSimulado) {
      correoSimulado.innerText = correo.mensaje;
      correoSimulado.dataset.phishing = correo.phishing;
    }
  }

  // Exportar funciones al scope global para que funcionen con onclick
  window.verificarRespuesta = function (respuesta) {
    const correoSimulado = document.getElementById("correoSimulado");
    if (!correoSimulado) return;

    const esPhishing = correoSimulado.dataset.phishing === "true";

    if ((respuesta === "phishing" && esPhishing) || (respuesta === "seguro" && !esPhishing)) {
      puntos++;
      alert("✅ ¡Correcto! Puntos: " + puntos);
    } else {
      alert("⚠️ Incorrecto. Este correo era " + (esPhishing ? "phishing" : "seguro"));
    }
    mostrarCorreo();
  };

  // Inicializar simulador
  mostrarCorreo();

  // --- Verificador de enlaces ---
  window.verificarEnlace = function () {
    const input = document.getElementById("linkInput").value;
    const resultado = document.getElementById("resultadoLink");

    if (!resultado) return;

    if (input.includes("paypal") && !input.includes("paypal.com")) {
      resultado.innerText = "⚠️ Este enlace parece sospechoso (imitación de PayPal).";
      resultado.style.color = "red";
    } else if (input.includes("http://")) {
      resultado.innerText = "⚠️ El enlace no es seguro (usa HTTP en lugar de HTTPS).";
      resultado.style.color = "orange";
    } else if (input.trim() === "") {
      resultado.innerText = "⚠️ Por favor ingresa un enlace.";
      resultado.style.color = "gray";
    } else {
      resultado.innerText = "✅ El enlace parece seguro.";
      resultado.style.color = "green";
    }
  };
});
