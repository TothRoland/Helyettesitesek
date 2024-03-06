document.getElementById("bejelentkezes").addEventListener("click", bejelentkezes);
async function bejelentkezes(){
    if(document.getElementById("felhasznalonev").value == "" || document.getElementById("jelszo").value == ""){
        alert("Nem adtad meg felhasználónévét vagy jelszavát!");
        return;
    }

    let settings = {
        method : "POST",
        body : JSON.stringify({
            "felhasznalonev" : document.getElementById("felhasznalonev").value,
            "jelszo" : document.getElementById("jelszo").value
        })
    }
    let response = await fetch("../php/index.php/bejelentkezes", settings);
    let data = await response.json();
    alert(data.valasz);
}

document.getElementById("jelszoHide").addEventListener("click", hide);
function hide(){
    let kepSRC = document.getElementById("hideImage");
    let jelszoInputType = document.getElementById("jelszo");
    if(kepSRC.getAttribute('src') == "../images/unhidePassword.png"){
        kepSRC.setAttribute('src', '../images/hidePassword.png');
        jelszoInputType.setAttribute('type', 'password');
    } else{
        kepSRC.setAttribute('src', '../images/unhidePassword.png');
        jelszoInputType.setAttribute('type', 'text');
    }
}