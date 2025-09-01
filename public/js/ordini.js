document.getElementsByClassName("card-deck")[0].addEventListener("click",function(e){
    if(e.target.classList.contains("card-button")){
        e.preventDefault();
        const numeroOrdine = e.target.closest(".card").id;
        const azione = e.target.getAttribute("azione");

        if(azione === "consegna"){
            setStatoOrdine(numeroOrdine,"consegnato");
        } else if (azione === "annulla"){
            setStatoOrdine(numeroOrdine,"annullato");
        }
    }
});

async function setStatoOrdine(numeroOrdine,stato){

    const body = {
        stato : stato
    }
    const res = await fetch("/api/manager/ordini/"+numeroOrdine,{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(body)
    });
    
    if(res.ok){
        card = document.getElementById(numeroOrdine);
        const elementi = card.querySelectorAll(".card-body");
        if(stato === "consegnato"){
            const oggi = new Date();
            const dataFormattata = oggi.toLocaleDateString('sv-SE');
            elementi[elementi.length - 1].innerHTML = creaCardBody("Data consegna",dataFormattata);
        } else {
            elementi[elementi.length - 1].remove();
        }
        elementi[elementi.length - 2].innerHTML = creaCardBody("Stato",stato);
    } else {
        const risposta = await res.json();
        alert(risposta.messaggio);
    }
}

function creaCardBody(h3,p){
    return `
        <h3 class="card-title">${h3}</h3>
        <p class="card-text">${p}</p>
    `
}

