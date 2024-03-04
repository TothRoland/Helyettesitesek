document.getElementById("regisztracio").addEventListener("click", regisztracio);
async function regisztracio(){
    if(document.getElementById("felhasznalonev").value == "" || document.getElementById("jelszo").value == "" || document.getElementById("jelszo2").value == "" || document.getElementById("email").value == ""){
        alert("Nem adtad meg felhasználónévét, emailcímét vagy jelszavát!");
        return;
    }
    if(document.getElementById("jelszo").value.length < 8 || document.getElementById("jelszo2").value.length < 8){
        alert("A jelszaónak minimum 8 karaktert kell tartalmaznia!");
        return;
    }
    if(document.getElementById("jelszo").value != document.getElementById("jelszo2").value){
        alert("A jelszavak nem egyeznek!");
        return;
    }
    if(document.getElementById("email").value.indexOf("@") == -1){
        alert("Nem megfelelő email cím formátum!");
        return;
    }

    let settings = {
        method : "POST",
        body : JSON.stringify({
            "felhasznalonev" : document.getElementById("felhasznalonev").value,
            "jelszo" : document.getElementById("jelszo").value,
            "email" : document.getElementById("email").value
        })
    }
    let response = await fetch("../php/index.php/regisztracio", settings);
    let data = await response.json();
    console.log(data);
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