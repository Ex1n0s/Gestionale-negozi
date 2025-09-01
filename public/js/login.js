
let ruolo = "cliente";

document.getElementById("ruolo").addEventListener("click", function(e){
    e.preventDefault();
    if(ruolo === "cliente"){
        ruolo = "manager";
        e.target.innerHTML = "Manager";
    } else{
        ruolo = "cliente";
        e.target.innerHTML = "Cliente";
    }
});

document.getElementById("login").addEventListener("click", async function (e) {
    e.preventDefault();
    
    const body = {
        cf: document.getElementById("cf").value,
        password: document.getElementById("password").value,
        ruolo: ruolo
    };
    const res = await fetch("/api/login",{
        method: "POST",
        headers: {
           "Content-type": "application/json"
        },
        body: JSON.stringify(body)
    });
    const result = await res.json();
    if(res.ok){
        window.location.href = result.destinazione;
    } else {
        alert(result.messaggio);
    }
});