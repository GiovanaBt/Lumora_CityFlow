/* =========================
   MODAL LOGIN
========================= */
const modal = document.getElementById("modal");
const btnAbrir = document.getElementById("abrirModal");
const btnFechar = document.querySelector(".fechar");

function fecharModal() {
    if (modal) {
        modal.style.display = "none";
        const erroMsg = document.querySelector(".erro-login");
        if (erroMsg) erroMsg.remove();
    }
}

/* Abrir modal */
if (btnAbrir && modal) {
    btnAbrir.onclick = function() {
        modal.style.display = "block";
    }
}

/* Fechar modal no X */
if (btnFechar) {
    btnFechar.onclick = fecharModal;
}

/* Fechar clicando fora */
window.onclick = function(event) {
    if (modal && event.target == modal) {
        fecharModal();
    }
}

/* =========================
   CAROUSEL
========================= */
const slides = document.querySelectorAll(".carousel-slide");
const nextBtn = document.querySelector(".next");
const prevBtn = document.querySelector(".prev");

// O código do carrossel só roda se houver slides e botões na página
if (slides.length > 0 && nextBtn && prevBtn) {
    let index = 0;

    function atualizarCarousel() {
        slides.forEach(slide => {
            slide.classList.remove("active", "prev", "next");
        });

        slides[index].classList.add("active");

        let prevIndex = (index - 1 < 0) ? slides.length - 1 : index - 1;
        let nextIndex = (index + 1 >= slides.length) ? 0 : index + 1;

        slides[prevIndex].classList.add("prev");
        slides[nextIndex].classList.add("next");
    }

    function proximo() {
        index = (index + 1 >= slides.length) ? 0 : index + 1;
        atualizarCarousel();
    }

    function anterior() {
        index = (index - 1 < 0) ? slides.length - 1 : index - 1;
        atualizarCarousel();
    }

    nextBtn.addEventListener("click", proximo);
    prevBtn.addEventListener("click", anterior);

    /* autoplay */
    setInterval(proximo, 5000);

    /* iniciar carousel */
    atualizarCarousel();
}