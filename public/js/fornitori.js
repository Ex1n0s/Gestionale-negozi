let ivaFornitoreModificato;

async function caricaFornitori() {
    const res = await fetch("/api/manager/fornitori",{
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
            cardDeck.innerHTML += creaCardFornitori(result[i]);
        }
    }
}

document.getElementById("inserisci").addEventListener("click", async function(e) {
    e.preventDefault();
    const fornitore = {
        iva: document.getElementById("iva").value,
        indirizzo: document.getElementById("indirizzo").value
    }
    const res = await fetch("/api/manager/fornitori",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(fornitore)
    });
    const result = await res.json();
    if(res.ok){
        alert(result.messaggio);
        caricaFornitori();
        svuotaForm();
        nascondiForm();
    } else {
        alert(result.messaggio);
    }
});

document.getElementById("salva").addEventListener("click", async function(e) {
    e.preventDefault();
    const fornitore = {
        iva: document.getElementById("iva").value,
        indirizzo: document.getElementById("indirizzo").value
    }
    const res = await fetch("/api/manager/fornitori/"+ivaFornitoreModificato,{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(fornitore)
    });
    const result = await res.json();
    if(res.ok){
        alert(result.messaggio);
        caricaFornitori();
        svuotaForm();
        nascondiForm();
    } else {
        alert(result.messaggio);
    }
    
});

async function riempiForm(iva) {
    ivaFornitoreModificato = iva;
    const res = await fetch("/api/manager/fornitori/"+iva,{
        method: "GET",
        headers: {
           "Content-type": "application/json"
        }
    });
    if(res.ok){
        const fornitore = await res.json();
        document.getElementById("iva").value = fornitore.iva;
        document.getElementById("indirizzo").value = fornitore.indirizzo;
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
        const iva = e.target.closest(".card").id;
        const azione = e.target.getAttribute("azione");

        if(azione === "chiudi"){
            setStatoFornitore(iva,"false");
        } else if (azione === "modifica"){
            riempiForm(iva);
        } else if (azione === "apri"){
            setStatoFornitore(iva,"true");
        } else if(azione === "gestisci"){
            window.location.href = "/manager/fornitore/"+iva;
        }
    }
});

function svuotaForm(){
    document.getElementById("iva").value = "";
    document.getElementById("indirizzo").value = "";
}

document.getElementById("aggiungi").addEventListener("click",function(e){
    const inserisci = document.getElementById("inserisci");
    inserisci.style.display = "inline-block";
    const salva = document.getElementById("salva");
    salva.style.display = "none";
    mostraForm();
});

async function setStatoFornitore(iva,stato){
    const body = {
        attivo : stato
    }
    const res = await fetch("/api/manager/fornitori/"+iva,{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(body)
    });
    if(res.ok){
        caricaFornitori();
    } else {
        const risposta = await res.json();
        alert(risposta.messaggio);
    }
} 

function creaCardFornitori(fornitore){
    bottone = '<button type="button" class="card-button elimina" azione="chiudi" >Chiudi</button>';
    stato = "Aperto"
    if(!fornitore.attivo){
        bottone = '<button type="button" class="card-button" azione="apri" >Apri</button>';
        stato + "Chiuso";
    }
    return `
    <div class="card" id="${fornitore.iva}">
        <h3 class="card-header">${fornitore.indirizzo}</h3>
        <div class="card-body">
            <h3 class="card-title">Iva</h3>
            <p class="card-text">${fornitore.iva}</p>
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