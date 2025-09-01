document.getElementsByClassName("card-deck")[0].addEventListener("click",function(e){
    if(e.target.classList.contains("card-button")){
        e.preventDefault();
        const codiceFattura = e.target.closest(".card").id;
        const azione = e.target.getAttribute("azione");
        if(azione === "dettagli"){
           window.location.href = "/cliente/fatture/"+codiceFattura;
        }
    }
});