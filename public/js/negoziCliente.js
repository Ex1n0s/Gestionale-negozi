document.getElementsByClassName("card-deck")[0].addEventListener("click", function(e){
    if(e.target.classList.contains("card-button")){
        e.preventDefault();
        const codice = e.target.closest(".card").id;
        const azione = e.target.getAttribute("azione");

        if(azione === "apri"){
            window.location.href = "/cliente/negozio/"+codice;
        }
    }
});
