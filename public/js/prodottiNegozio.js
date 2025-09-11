let codiceNegozio;

document.addEventListener("DOMContentLoaded",function(){
    codiceNegozio = document.getElementById("container").getAttribute("codice");
});


document.getElementsByClassName("card-deck")[0].addEventListener("click", function(e){
    if(e.target.classList.contains("card-button")){
        e.preventDefault();
        const codiceProdotto = e.target.closest(".card").id;
        const azione = e.target.getAttribute("azione");

        if(azione === "aggiungi"){
            aggiungiAlCarrello(codiceProdotto);
        }
    }
});

async function aggiungiAlCarrello(codiceProdotto){
    const card = document.getElementById(codiceProdotto);
    const inputs = card.querySelectorAll(".card-input");
    body = {
        codice_prodotto: codiceProdotto,
        codice_negozio: codiceNegozio,
        quantita: inputs[0].value
    }
    console.log(inputs[0].value);
    const res = await fetch("/api/cliente/carrello",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body:JSON.stringify(body)
    });
    const result = await res.json();
    alert(result.messaggio);
}