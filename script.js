const modal = document.getElementById("modal");
const btn = document.getElementById("abrirModal");
const fechar = document.querySelector(".fechar");

btn.onclick = function() {
    modal.style.display = "block";
}

fechar.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


