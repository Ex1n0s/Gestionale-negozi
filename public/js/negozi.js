let codiceNegozioModificato;

async function caricaNegozi() {
    const res = await fetch("/api/manager/negozi",{
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
            cardDeck.innerHTML += creaCardNegozi(result[i]);
        }
    }
}

document.getElementById("inserisci").addEventListener("click", async function(e) {
    e.preventDefault();
    const negozio = {
        codice: document.getElementById("codice").value,
        indirizzo: document.getElementById("indirizzo").value,
        responsabile: document.getElementById("responsabile").value
    }
    const res = await fetch("/api/manager/negozi",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(negozio)
    });
    const result = await res.json();
    if(res.ok){
        alert(result.messaggio);
        caricaNegozi();
        svuotaForm();
        nascondiForm();
    } else {
        alert(result.messaggio);
    }
});

document.getElementById("salva").addEventListener("click", async function(e) {
    e.preventDefault();
    const negozio = {
        codice: document.getElementById("codice").value,
        indirizzo: document.getElementById("indirizzo").value,
        responsabile: document.getElementById("responsabile").value,
    }
    const res = await fetch("/api/manager/negozi/"+codiceNegozioModificato,{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(negozio)
    });
    const result = await res.json();
    if(res.ok){
        alert(result.messaggio);
        caricaNegozi();
        svuotaForm();
        nascondiForm();
    } else {
        alert(result.messaggio);
    }
    
});

async function riempiForm(codice) {
    codiceNegozioModificato = codice;
    const res = await fetch("/api/manager/negozi/"+codice,{
        method: "GET",
        headers: {
           "Content-type": "application/json"
        }
    });
    if(res.ok){
        const negozio = await res.json();
        document.getElementById("codice").value = negozio.codice;
        document.getElementById("responsabile").value = negozio.responsabile;
        document.getElementById("indirizzo").value = negozio.indirizzo;
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

        if(azione === "chiudi"){
            setStatoNegozio(codice,"false");
        } else if (azione === "modifica"){
            riempiForm(codice);
        } else if (azione === "apri"){
            setStatoNegozio(codice,"true");
        } else if(azione === "gestisci"){
            window.location.href = "/manager/negozio/"+codice;
        }
    }
});

function svuotaForm(){
    document.getElementById("codice").value = "";
    document.getElementById("responsabile").value = "";
    document.getElementById("indirizzo").value = "";
}

document.getElementById("aggiungi").addEventListener("click",function(e){
    const inserisci = document.getElementById("inserisci");
    inserisci.style.display = "inline-block";
    const salva = document.getElementById("salva");
    salva.style.display = "none";
    mostraForm();
});

async function setStatoNegozio(codice,stato){
    const body = {
        attivo : stato
    }
    const res = await fetch("/api/manager/negozi/"+codice,{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(body)
    });
    if(res.ok){
        caricaNegozi();
    } else {
        const risposta = await res.json();
        alert(risposta.messaggio);
    }
} 

function creaCardNegozi(negozio){
    bottone = '<button type="button" class="card-button elimina" azione="chiudi" >Chiudi</button>';
    stato = "Aperto"
    if(!negozio.attivo){
        bottone = '<button type="button" class="card-button" azione="apri" >Apri</button>';
        stato + "Chiuso";
    }
    return `
    <div class="card" id="${negozio.codice}">
        <h3 class="card-header">${negozio.indirizzo}</h3>
        <div class="card-body">
            <h3 class="card-title">Responsabile</h3>
            <p class="card-text">${negozio.responsabile}</p>
        </div>
        <div class="card-body">
            <h3 class="card-title">Codice</h3>
            <p class="card-text">${negozio.codice}</p>
        </div>
        <div class="card-body">
            <h3 class="card-title">Stato</h3>
            <p class="card-text">${stato}</p>
        </div>
        <div class="card-body">
            <button type="button" class="card-button" azione="gestisci">Gestisci</button>
            <button type="button" class="card-button" azione="modifica">Modifica</button>
            ${bottone}
        </div>
    </div>
  `;
}
