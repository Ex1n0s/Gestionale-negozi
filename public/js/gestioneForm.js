document.getElementById("x").addEventListener("click",function(e){
    svuotaForm();
    nascondiForm();
});

function mostraForm(){
    const form = document.getElementsByClassName("form")[0];
    const blur = document.getElementsByClassName("blur")[0];
    form.classList.remove("nascosto");
    blur.classList.remove("nascosto");
    form.classList.add("visibile");
    blur.classList.add("visibile");
}

function nascondiForm(){
    const form = document.getElementsByClassName("form")[0];
    const blur = document.getElementsByClassName("blur")[0];
    form.classList.remove("visibile");
    blur.classList.remove("visibile");
    form.classList.add("nascosto");
    blur.classList.add("nascosto");
}

