document.getElementById("acquista").addEventListener("click",async function(e){
    e.preventDefault();
    const select = document.getElementById("sconti");
    body = {
        sconto_percentuale: select.options[select.selectedIndex].value
    }
    const res = await fetch("/api/cliente/acquista",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body:JSON.stringify(body)
    });
    const result = await res.json();
    alert(result.messaggio);
});

document.getElementsByClassName("card-deck")[0].addEventListener("click",function(e){
    if(e.target.classList.contains("icona")){
        e.preventDefault();
        const prodottoCarrello = e.target.closest(".card").id;
        const azione = e.target.getAttribute("azione");

        if(azione === "decrementa"){
            updateCarrello(prodottoCarrello,-1);
        } else if (azione === "incrementa"){
            updateCarrello(prodottoCarrello,1);
        } else if (azione === "elimina"){
            deleteElementoCarrello(prodottoCarrello)
        }
    }
});

async function updateCarrello(prodottoCarrello,quantita){
    body = {
        quantita:quantita
    }
    const res = await fetch("/api/cliente/carrello/"+prodottoCarrello,{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body:JSON.stringify(body)
    });
    if(res.ok){
        location.reload();
    } else {
        const result = await res.json();
        alert(result.messaggio);
    }
    
}

async function deleteElementoCarrello(prodottoCarrello){
    const res = await fetch("/api/cliente/carrello/"+prodottoCarrello,{
        method: "DELETE",
        headers: {
           "Content-type": "application/json"
        }
    });
    if(res.ok){
        location.reload();
    } else {
        const result = await res.json();
        alert(result.messaggio);
    }
    
}