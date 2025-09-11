
let cfClienteModificato;

async function caricaClienti() {
    const res = await fetch("/api/manager/clienti",{
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
            cardDeck.innerHTML += creaCardCliente(result[i]);
        }
    }
}

document.getElementById("inserisci").addEventListener("click", async function(e) {
    e.preventDefault();
    const cliente = {
        cf: document.getElementById("cf").value,
        password: document.getElementById("password").value,
        email: document.getElementById("email").value,
        nome: document.getElementById("nome").value,
        cognome: document.getElementById("cognome").value
    }
    const res = await fetch("/api/manager/clienti",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(cliente)
    });
    if(res.ok){
        const result = await res.json();
        alert(result.messaggio);
        caricaClienti();
        svuotaForm();
        nascondiForm();
    } else {
        const result = await res.json();
        alert(result.messaggio);
    }
});

document.getElementById("salva").addEventListener("click", async function(e) {
    e.preventDefault();
    const cliente = {
        cf: document.getElementById("cf").value,
        email: document.getElementById("email").value,
        nome: document.getElementById("nome").value,
        cognome: document.getElementById("cognome").value
    }
    const res = await fetch("/api/manager/clienti/"+cfClienteModificato,{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(cliente)
    });
    const result = await res.json();
    if(res.ok){
        alert(result.messaggio);
        caricaClienti();
        svuotaForm();
        nascondiForm();
    } else {
        alert(result.messaggio);
    }
    
});

document.getElementsByClassName("card-deck")[0].addEventListener("click",function(e){
    if(e.target.classList.contains("card-button")){
        e.preventDefault();
        const cf = e.target.closest(".card").id;
        const azione = e.target.getAttribute("azione");
        if(azione === "elimina"){
            deleteCliente(cf);
        } else if (azione === "modifica"){
            riempiForm(cf);
        }
    }
});

function svuotaForm(){
    document.getElementById("cf").value = "";
    document.getElementById("email").value = "";
    document.getElementById("nome").value = "";
    document.getElementById("cognome").value = "";
    document.getElementById("password").value = "";
}

async function riempiForm(cf) {
    cfClienteModificato = cf;
    const res = await fetch("/api/manager/clienti/"+cf,{
        method: "GET",
        headers: {
           "Content-type": "application/json"
        }
    });
    if(res.ok){
        const cliente = await res.json();
        document.getElementById("cf").value = cliente.cf;
        document.getElementById("email").value = cliente.email;
        document.getElementById("nome").value = cliente.nome;
        document.getElementById("cognome").value = cliente.cognome;
        const password = document.getElementById("password").closest(".form-group");
        password.style.display = "none";
        const inserisci = document.getElementById("inserisci");
        inserisci.style.display = "none";
        const salva = document.getElementById("salva");
        salva.style.display = "inline-block";
        mostraForm();
    }
}



document.getElementById("aggiungi").addEventListener("click",function(e){
    const password = document.getElementById("password").closest(".form-group");
    password.style.display = "inline-block";
    const inserisci = document.getElementById("inserisci");
    inserisci.style.display = "inline-block";
    const salva = document.getElementById("salva");
    salva.style.display = "none";
    mostraForm();
});

async function deleteCliente(cf){
    const res = await fetch("/api/manager/clienti/"+cf,{
        method: "DELETE",
        headers: {
           "Content-type": "application/json"
        }
    });
    
    if(res.ok){
        document.getElementById(cf).remove();
    } else {
        const risposta = await res.json();
        alert(risposta.messaggio);
    }
} 

function creaCardCliente(cliente){
    return `
    <div class="card" id="${cliente.cf}">
        <h3 class="card-header">${cliente.nome + " " + cliente.cognome}</h3>
        <div class="card-body">
            <h3 class="card-title">Codice fiscale</h3>
            <p class="card-text">${cliente.cf}</p>
        </div>
        <div class="card-body">
            <h3 class="card-title">Email</h3>
            <p class="card-text">${cliente.email}</p>
        </div>
        <div class="card-body">
            <button type="button" class="card-button" azione="modifica">Modifica</button>
            <button type="button" class="card-button elimina" azione="elimina" >Elimina</button>
        </div>
    </div>
  `;
}

