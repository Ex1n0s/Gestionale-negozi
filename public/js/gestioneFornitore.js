let ivaFornitore;

document.addEventListener("DOMContentLoaded",function(){
    ivaFornitore = document.getElementById("container").getAttribute("iva");
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
        }
    }
});


async function salva(codiceProdotto){
    const card = document.getElementById(codiceProdotto);
    const inputs = card.querySelectorAll(".card-input");
    body = {
        prezzo_prodotto: inputs[0].value,
        quantita_disponibile: inputs[1].value
    }

    const res = await fetch("/api/manager/fornitore/"+ivaFornitore+"/prodotti/"+codiceProdotto,{
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
    const res = await fetch("/api/manager/fornitore/"+ivaFornitore+"/prodotti",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body:JSON.stringify(body)
    });
    if(res.ok){
        caricaProdottiFornitore();
    } else {
        const result = await res.json();
        alert(result.messaggio);
    }
})

async function deleteProdotto(codiceProdotto){
    const res = await fetch("/api/manager/fornitore/"+ivaFornitore+"/prodotti/"+codiceProdotto,{
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

async function caricaProdottiFornitore() {
    const res = await fetch("/api/fornitore/"+ivaFornitore+"/prodotti",{
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
            cardDeck.innerHTML += creaCardProdottiFornitore(result[i]);
        }
    }
}

function creaCardProdottiFornitore(prodotto){
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
            <h3 class="card-title">Quantità</h3>
            <input type="text" class="card-input" value="${prodotto.quantita_disponibile}">
        </div>
        <div class="card-body">
            <button type="button" class="card-button" azione="salva">Salva</button>
            <button type="button" class="card-button elimina" azione="elimina">Elimina</button>
        </div>
    </div>
  `;
}