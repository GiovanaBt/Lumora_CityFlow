/* =========================
   MODAL LOGIN
========================= */
/* =========================
   MODAL LOGIN
========================= */
/* =========================
   MODAL LOGIN
========================= */
const modal = document.getElementById("modal");
const btnAbrir = document.getElementById("abrirModal");
const btnFechar = document.querySelector(".fechar");

// Função para fechar e REMOVER a mensagem de erro
function fecharELimparModal() {
    modal.style.display = "none";

    // Procura o elemento de erro e remove ele do HTML
    const erroMensagem = document.querySelector(".erro-login");
    if (erroMensagem) {
        erroMensagem.remove(); 
    }
}

/* Abrir modal ao clicar em entrar */
if (btnAbrir) {
    btnAbrir.onclick = function() {
        modal.style.display = "block";
    }
}

/* Fechar no botão "X" */
if (btnFechar) {
    btnFechar.onclick = fecharELimparModal;
}

/* Fechar ao clicar fora do modal */
window.onclick = function(event) {
    if (event.target == modal) {
        fecharELimparModal();
    }
}

/* =========================
   CAROUSEL
========================= */

const slides = document.querySelectorAll(".carousel-slide");
const nextBtn = document.querySelector(".next");
const prevBtn = document.querySelector(".prev");

let index = 0;

/* atualizar slides */
function atualizarCarousel() {

    slides.forEach(slide => {
        slide.classList.remove("active", "prev", "next");
    });

    slides[index].classList.add("active");

    let prevIndex = index - 1;
    let nextIndex = index + 1;

    if (prevIndex < 0) {
        prevIndex = slides.length - 1;
    }

    if (nextIndex >= slides.length) {
        nextIndex = 0;
    }

    slides[prevIndex].classList.add("prev");
    slides[nextIndex].classList.add("next");
}

/* próximo slide */
function proximo() {

    index++;

    if (index >= slides.length) {
        index = 0;
    }

    atualizarCarousel();
}

/* slide anterior */
function anterior() {

    index--;

    if (index < 0) {
        index = slides.length - 1;
    }

    atualizarCarousel();
}

/* eventos das setas */
nextBtn.addEventListener("click", proximo);
prevBtn.addEventListener("click", anterior);

/* autoplay */
setInterval(proximo, 5000);

/* iniciar carousel */
atualizarCarousel();