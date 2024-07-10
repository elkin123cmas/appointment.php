document.addEventListener('DOMContentLoaded', () => {
  // alert("Script loaded");

  const estilosButton = document.getElementById("estilos");
  const agendaButton = document.getElementById("agenda");
  const resumenButton = document.getElementById("resumen");
  const crearButton = document.getElementById("crear");
  const actualizarButton = document.getElementById("actualizar");
  const borrarButton = document.getElementById("borrar");

  // botones dentro de propiedades
  const crearBorrar1 = document.getElementById("crearBorrar");
  const actualizarBorrar = document.getElementById("actualizarBorrar");
  const borrarBorrar = document.getElementById("borrarBorrar");

  // input type file crear.php
  const fileInput = document.getElementById('fileInput');
  const customLabel = document.querySelector('.custom-file-label');

  // botón de atrás
  const backButton = document.getElementById("back");
  const nextButton = document.getElementById("next");
  const backAgendButton = document.getElementById("backAgend");
  const backAppoun = document.getElementById("back-appoun");

  // blanqueo mensaje creado e input
  const mensajeDiv = document.getElementById('resultado');
  const tituloInput = document.getElementById('titulo');

  // Selecciona todos los enlaces con la clase 'sectionInfo'
  const links = document.querySelectorAll('.sectionInfo');

  // Redirección de secciones
  if (estilosButton) {
    estilosButton.addEventListener("click", () => {
      window.location.href = "appounment.php";
      estilosButton.style.backgroundColor = "white";
    });
  }

  if (agendaButton) {
    agendaButton.addEventListener("click", () => {
      window.location.href = "agend.php";
    });
  }

  if (resumenButton) {
    resumenButton.addEventListener("click", () => {
      window.location.href = "resumen.php";
    });
  }

  // Botón de atrás en la agenda
  if (backButton) {
    backButton.addEventListener("click", () => {
      window.location.href = "appounment.php";
    });
  }
  if (nextButton) {
    nextButton.addEventListener("click", () => {
      window.location.href = "resumen.php";
    });
  }
  if (backAgendButton) {
    backAgendButton.addEventListener("click", () => {
      window.location.href = "agend.php";
    });
  }
  if (backAppoun) {
    backAppoun.addEventListener("click", () => {
      window.location.href = "appounment.php";
    });
  }

  // ADMIN SECCIONES
  if (crearButton) {
    crearButton.addEventListener("click", () => {
      window.location.href = "propiedades/crear.php";
    });
  }
  if (actualizarButton) {
    actualizarButton.addEventListener("click", () => {
      window.location.href = "propiedades/actualizar.php";
    });
  }
  if (borrarButton) {
    borrarButton.addEventListener("click", () => {
      window.location.href = "propiedades/borrar.php";
    });
  }

  if (crearBorrar1) {
    crearBorrar1.addEventListener("click", () => {
      window.location.href = "crear.php";
    });
  }
  if (actualizarBorrar) {
    actualizarBorrar.addEventListener("click", () => {
      window.location.href = "actualizar.php";
    });
  }
  if (borrarBorrar) {
    borrarBorrar.addEventListener("click", () => {
      window.location.href = "borrar.php";
    });
  }

  // input type file crear.php
  if (fileInput) {
    fileInput.addEventListener('change', (event) => {
      const fileName = event.target.files[0] ? event.target.files[0].name : "No se ha seleccionado ningún archivo";
      customLabel.innerHTML = `<i class="fa-solid fa-user icon"></i> ${fileName}`;
    });
  }

  // blanqueo mensaje creado e input
  if (mensajeDiv) {
    setTimeout(function() {
      if (tituloInput) tituloInput.value = '';
      mensajeDiv.style.display = 'none';
      window.location.href = '../index.php';
    }, 3000);
  }

  // lógica para mantener el color del link al hacer clic
  links.forEach(link => {
    link.addEventListener('click', function() {
      // Elimina la clase 'changeActive' de todos los enlaces
      links.forEach(l => l.classList.remove('changeActive'));

      // Añade la clase 'changeActive' al enlace que se ha clicado
      this.classList.add('changeActive');
    });
  });

  // Mantener el estado activo basado en la URL actual
  const currentPath = window.location.pathname;
  links.forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add('changeActive');
    }
  });

  // Añadir la clase 'changeActive' al enlace 'Creados' si estamos en /admin/index.php
  if (currentPath === '/admin/index.php') {
    const creadosLink = document.querySelector('a[href="/admin/propiedades/actualizar.php"]');
    if (creadosLink) {
      creadosLink.classList.add('changeActive');
    }
  }

  // EFFECTS CARD
  const cards = document.querySelectorAll(".gridInternGallery");

  cards.forEach(elemento => {
    const height = elemento.clientHeight;
    const width = elemento.clientWidth;

    elemento.addEventListener('mousemove', (e) => {
      const { layerX, layerY } = e;

      const yRotation = ((layerX - width / 2) / width) * 20;
      const xRotation = ((layerY - height / 2) / height) * 20;

      const string = `perspective(40rem) scale(1.1) rotateX(${xRotation}deg) rotateY(${yRotation}deg)`;

      elemento.style.transform = string;
    });

    elemento.addEventListener('mouseout', () => {
      elemento.style.transform = 'perspective(30rem) scale(1) rotateX(0) rotateY(0)';
    });
    elemento.addEventListener('click', () => {
      const modal = document.getElementById("imageModal");
      const modalImg = document.getElementById("modalImage");
      const img = elemento.querySelector("img");

      modal.style.display = "block";
      modalImg.src = img.src;
    });
  });

  // VENTANA MODAL
  // Cerrar el modal
  const closeModal = document.querySelector(".close");
  if (closeModal) {
    closeModal.addEventListener('click', () => {
      const modal = document.getElementById("imageModal");
      modal.style.display = "none";
    });
  }

  // Cerrar el modal cuando hagamos clic fuera de la imagen
  window.addEventListener('click', (event) => {
    const modal = document.getElementById("imageModal");
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});
