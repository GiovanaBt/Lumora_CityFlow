document.addEventListener("DOMContentLoaded", () => {

    /* ========================================
       MODAL LOGIN
    ======================================== */
    const modal = document.getElementById("modal");
    const btnAbrir = document.getElementById("abrirModal");
    const btnFechar = document.querySelector(".fechar");

    function fecharModal() {
        if (modal) {
            modal.style.display = "none";
            // Remove mensagens de erro de login caso existam
            const erroMsg = document.querySelector(".erro-login");
            if (erroMsg) erroMsg.remove();
        }
    }

    // Abrir modal
    if (btnAbrir && modal) {
        btnAbrir.onclick = function () {
            modal.style.display = "flex";
        }
    }

    // Fechar modal no botão X
    if (btnFechar) {
        btnFechar.onclick = fecharModal;
    }

    // Fechar clicando fora da área branca do modal
    window.addEventListener("click", function (event) {
        if (modal && event.target == modal) {
            fecharModal();
        }
    });

    /* ========================================
       MENU MOBILE RESPONSIVO (HAMBURGUER)
    ======================================== */
    const hamburguer = document.getElementById("hamburguer");
    const nav = document.querySelector("header nav");

    if (hamburguer && nav) {
        hamburguer.addEventListener("click", (e) => {
            e.stopPropagation();
            nav.classList.toggle("ativo");
            const icon = hamburguer.querySelector("i");
            if (icon) {
                if (nav.classList.contains("ativo")) {
                    icon.classList.remove("fa-bars");
                    icon.classList.add("fa-xmark");
                } else {
                    icon.classList.remove("fa-xmark");
                    icon.classList.add("fa-bars");
                }
            }
        });

        // Fechar ao clicar fora do nav no mobile
        document.addEventListener("click", (e) => {
            if (nav.classList.contains("ativo") && !nav.contains(e.target) && !hamburguer.contains(e.target)) {
                nav.classList.remove("ativo");
                const icon = hamburguer.querySelector("i");
                if (icon) {
                    icon.classList.remove("fa-xmark");
                    icon.classList.add("fa-bars");
                }
            }
        });

        // Fechar ao clicar em algum link interno
        nav.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                if (window.innerWidth <= 900) {
                    nav.classList.remove("ativo");
                    const icon = hamburguer.querySelector("i");
                    if (icon) {
                        icon.classList.remove("fa-xmark");
                        icon.classList.add("fa-bars");
                    }
                }
            });
        });

        // Fechar se redimensionar a tela para Desktop
        window.addEventListener("resize", () => {
            if (window.innerWidth > 900 && nav.classList.contains("ativo")) {
                nav.classList.remove("ativo");
                const icon = hamburguer.querySelector("i");
                if (icon) {
                    icon.classList.remove("fa-xmark");
                    icon.classList.add("fa-bars");
                }
            }
        });
    }

    /* ========================================
       CAROUSEL (BANNER INICIAL)
    ======================================== */
    const slides = document.querySelectorAll(".carousel-slide");
    const nextBtn = document.querySelector(".next");
    const prevBtn = document.querySelector(".prev");

    // O código do carrossel só roda se os elementos existirem e não tiver sido iniciado por script inline
    if (!window.indexCarouselLoaded && slides.length > 0 && nextBtn && prevBtn) {
        let index = 0;

        function atualizarCarousel() {
            // Limpa as classes de todos os slides
            slides.forEach(slide => {
                slide.classList.remove("active", "prev", "next");
            });

            // Define o slide atual
            slides[index].classList.add("active");

            // Calcula os vizinhos para o efeito de transição
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

        // Eventos de clique
        nextBtn.addEventListener("click", proximo);
        prevBtn.addEventListener("click", anterior);

        // Autoplay - muda a cada 5 segundos
        setInterval(proximo, 5000);

        // Iniciar estado visual do carousel
        atualizarCarousel();
    }

});

function preVisualizar() {
    // Pega os dados do formulário
    const nomeEl = document.getElementById('nome');
    const nome = nomeEl ? nomeEl.value : '';
    const descEl = document.querySelector('.description-textarea');
    const desc = descEl ? descEl.value : '';
    const cidadeEl = document.getElementById('cidade');
    const cidade = cidadeEl ? cidadeEl.value : '';
    const dataEl = document.querySelector('input[name="data_inicio_evento"]');
    const data = dataEl ? dataEl.value : '';

    alert(`PRÉ-VISUALIZAÇÃO DO EVENTO:\n\nNome: ${nome}\nCidade: ${cidade}\nData: ${data}\nDescrição: ${desc}`);
}

function mostrarPrevia(input) {
    const preview = document.getElementById('image-preview');
    const texto = document.getElementById('upload-text');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Mostra a imagem selecionada
            }
            if (texto) {
                texto.style.display = 'none'; // Esconde a frase "Clique ou arraste"
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}
