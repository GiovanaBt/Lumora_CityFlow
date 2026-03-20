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
        btnAbrir.onclick = function() {
            modal.style.display = "block";
        }
    }

    // Fechar modal no botão X
    if (btnFechar) {
        btnFechar.onclick = fecharModal;
    }

    // Fechar clicando fora da área branca do modal
    window.onclick = function(event) {
        if (modal && event.target == modal) {
            fecharModal();
        }
    }

    /* ========================================
       CAROUSEL (BANNER INICIAL)
    ======================================== */
    const slides = document.querySelectorAll(".carousel-slide");
    const nextBtn = document.querySelector(".next");
    const prevBtn = document.querySelector(".prev");

    // O código do carrossel só roda se os elementos existirem na página (ex: index.php)
    if (slides.length > 0 && nextBtn && prevBtn) {
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
    const nome = document.getElementById('nome').value;
    const desc = document.querySelector('.description-textarea').value;
    const cidade = document.getElementById('cidade').value;
    const data = document.querySelector('input[name="data_inicio_evento"]').value;

    // Cria um alerta simples ou um Modal personalizado
    // Aqui um exemplo rápido via alert, mas o ideal é popular um Modal HTML
    alert(`PRÉ-VISUALIZAÇÃO DO EVENTO:\n\nNome: ${nome}\nCidade: ${cidade}\nData: ${data}\nDescrição: ${desc}`);
    
    // Se quiser algo mais avançado, você pode fazer o seguinte:
    // window.open('previa.php?nome='+nome+'&cidade='+cidade, '_blank');
}