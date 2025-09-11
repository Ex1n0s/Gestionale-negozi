document.getElementById("salva").addEventListener("click", async function(e){
    e.preventDefault();
    const body = {
        password_nuova: document.getElementById("new").value,
        password_corrente: document.getElementById("old").value
    }
    const res = await fetch("/api/utente/password",{
        method: "PUT",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(body)
    });
    const result = await res.json();
    alert(result.messaggio);
});

document.getElementById("logout").addEventListener("click", async function(e){
    e.preventDefault();
    const res = await fetch("/api/utente/logout",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        }
    });
    if(res.ok){
        window.location.href = "/login";
    }
});