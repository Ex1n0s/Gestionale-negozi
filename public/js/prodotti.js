//document.addEventListener("DOMContentLoaded",caricaProdotti());

let codiceProdottoModificato;

async function caricaProdotti() {
    const res = await fetch("/api/prodotti",{
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
            cardDeck.innerHTML += creaCardProdotti(result[i]);
        }
    }
}

document.getElementById("inserisci").addEventListener("click", async function(e) {
    e.preventDefault();
    const prodotto = {
        codice: document.getElementById("codice").value,
        nome: document.getElementById("nome").value,
        descrizione: document.getElementById("descrizione").value
    }
    const res = await fetch("/api/manager/prodotti",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(prodotto)
    });
    const result = await res.json();
    if(res.ok){
        alert(result.messaggio);
        caricaProdotti();
        svuotaForm();
        nascondiForm();
    } else {
        alert(result.messaggio);
    }
});

document.getElementById("salva").addEventListener("click", async function(e) {
    e.preventDefault();
    const prodotto = {
        codice: document.getElementById("codice").value,
        nome: document.getElementById("nome").value,
        descrizione: document.getElementById("descrizione").value,
    }
    const res = await fetch("/api/manager/prodotti/"+codiceProdottoModificato,{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(prodotto)
    });
    const result = await res.json();
    if(res.ok){
        alert(result.messaggio);
        caricaProdotti();
        svuotaForm();
        nascondiForm();
    } else {
        alert(result.messaggio);
    }
    
});

async function riempiForm(codice) {
    codiceProdottoModificato = codice;
    const res = await fetch("/api/prodotti/"+codice,{
        method: "GET",
        headers: {
           "Content-type": "application/json"
        }
    });
    if(res.ok){
        const prodotto = await res.json();
        document.getElementById("codice").value = prodotto.codice;
        document.getElementById("nome").value = prodotto.nome;
        document.getElementById("descrizione").value = prodotto.descrizione;
        const inserisci = document.getElementById("inserisci");
        inserisci.style.display = "none";
        const salva = document.getElementById("salva");
        salva.style.display = "inline-block";
        mostraForm();
    }
}

document.getElementsByClassName("card-deck")[0].addEventListener("click",function(e){
    if(e.target.classList.contains("card-button")){
        e.preventDefault();
        const codice = e.target.closest(".card").id;
        const azione = e.target.getAttribute("azione");

        if(azione === "elimina"){
            deleteProdotto(codice);
        } else if (azione === "modifica"){
            riempiForm(codice);
        }
    }
});

function svuotaForm(){
    document.getElementById("codice").value = "";
    document.getElementById("nome").value = "";
    document.getElementById("descrizione").value = "";
}

document.getElementById("aggiungi").addEventListener("click",function(e){
    const inserisci = document.getElementById("inserisci");
    inserisci.style.display = "inline-block";
    const salva = document.getElementById("salva");
    salva.style.display = "none";
    mostraForm();
});

async function deleteProdotto(codice){
    const res = await fetch("/api/manager/prodotti/"+codice,{
        method: "DELETE",
        headers: {
           "Content-type": "application/json"
        }
    });
    if(res.ok){
        document.getElementById(codice).remove();
    } else {
        const risposta = await res.json();
        alert(risposta.messaggio);
    }
} 

function creaCardProdotti(prodotto){
    return `
    <div class="card" id="${prodotto.codice}">
        <h3 class="card-header">${prodotto.nome}</h3>
        <div class="card-body">
            <h3 class="card-title">Codice</h3>
            <p class="card-text">${prodotto.codice}</p>
        </div>
        <div class="card-body">
            <h3 class="card-title">Descrizione</h3>
            <p class="card-text">${prodotto.descrizione}</p>
        </div>
        <div class="card-body">
            <button type="button" class="card-button" azione="modifica">Modifica</button>
            <button type="button" class="card-button elimina" azione="elimina" >Elimina</button>
        </div>
    </div>
  `;
}
