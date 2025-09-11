let codiceNegozio;

document.addEventListener("DOMContentLoaded",function(){
    codiceNegozio = document.getElementById("container").getAttribute("codice");
});

document.getElementsByClassName("card-deck")[0].addEventListener("click",function(e){
    if(e.target.classList.contains("card-button")){
        e.preventDefault();
        const codiceProdotto = e.target.closest(".card").id;
        const azione = e.target.getAttribute("azione");

        if(azione === "salva"){
            salva(codiceProdotto);
        } else if (azione === "elimina"){
            deleteProdotto(codiceProdotto);
        } else if (azione === "ordina"){
            ordina(codiceProdotto);
        }
    }
});

async function ordina(codiceProdotto){
    const card = document.getElementById(codiceProdotto);
    const inputs = card.querySelectorAll(".card-input");
    body = {
        codice_prodotto: codiceProdotto,
        codice_negozio: codiceNegozio,
        quantita_prodotto: inputs[3].value
    }
    const res = await fetch("/api/manager/ordini",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body:JSON.stringify(body)
    });
    
    const result = await res.json();
    alert(result.messaggio);
}

async function salva(codiceProdotto){
    const card = document.getElementById(codiceProdotto);
    const inputs = card.querySelectorAll(".card-input");
    body = {
        prezzo_prodotto: inputs[0].value,
        sconto_percentuale: inputs[1].value,
        quantita_disponibile: inputs[2].value
    }

    const res = await fetch("/api/manager/negozi/"+codiceNegozio+"/prodotti/"+codiceProdotto,{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body:JSON.stringify(body)
    });
    const result = await res.json();
    alert(result.messaggio);
}

document.getElementById("aggiungi").addEventListener("click",async function(e) {
    e.preventDefault();
    const select = document.getElementById("prodotti");
    body = {
        codice_prodotto: select.options[select.selectedIndex].value,
    }
    const res = await fetch("/api/manager/negozi/"+codiceNegozio+"/prodotti",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body:JSON.stringify(body)
    });
    if(res.ok){
        caricaProdottiNegozio();
    } else {
        const result = await res.json();
        alert(result.messaggio);
    }
})

async function deleteProdotto(codiceProdotto){
    const res = await fetch("/api/manager/negozi/"+codiceNegozio+"/prodotti/"+codiceProdotto,{
        method: "DELETE",
        headers: {
           "Content-type": "application/json"
        }
    });
    
    if(res.ok){
        document.getElementById(codiceProdotto).remove();
    } else {
        const risposta = await res.json();
        alert(risposta.messaggio);
    }
} 

async function caricaProdottiNegozio() {
    const res = await fetch("/api/negozi/"+codiceNegozio+"/prodotti",{
        method: "GET",
        headers: {
           "Content-type": "application/json"
        }
    });
    if(res.ok){
        const result = await res.json();
        const cardDeck = document.getElementsByClassName("card-deck")[0];
        cardDeck.innerHTML = "";
        for (let i = result.length - 1; i>=0; i--) {
            cardDeck.innerHTML += creaCardProdottiNegozio(result[i]);
        }
    }
}

function creaCardProdottiNegozio(prodotto){
    return `
    <div class="card" id="${prodotto.codice_prodotto}">
        <h3 class="card-header">${prodotto.nome}</h3>
        <div class="card-body">
            <h3 class="card-title">Descrizione</h3>
            <p class="card-text">${prodotto.descrizione}</p>
        </div>
        <div class="card-body">
            <h3 class="card-title">Prezzo</h3>
            <input type="text" class="card-input" value="${prodotto.prezzo_prodotto}">
        </div>
        <div class="card-body">
            <h3 class="card-title">Sconto</h3>
            <input type="text" class="card-input" value="${prodotto.sconto_percentuale}">
        </div>
        <div class="card-body">
            <h3 class="card-title">Quantità</h3>
            <input type="text" class="card-input" value="${prodotto.quantita_disponibile}">
        </div>
        <div class="card-body">
            <button type="button" class="card-button" azione="ordina">Ordina</button>
            <input type="number" step="1" min ="1" class="card-input" >
        </div>
        <div class="card-body">
            <button type="button" class="card-button" azione="salva">Salva</button>
            <button type="button" class="card-button elimina" azione="elimina">Elimina</button>
        </div>
    </div>
  `;
}