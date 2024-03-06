document.getElementById("regisztracio").addEventListener("click", regisztracio);
async function regisztracio(){
    if(document.getElementById("felhasznalonev").value == "" || document.getElementById("jelszo1").value == "" || document.getElementById("jelszo2").value == "" || document.getElementById("email").value == ""){
        alert("Nem adtad meg felhasználónévét, emailcímét vagy jelszavát!");
        return;
    }
    if(document.getElementById("szerepkor").value == "") {
        alert("Nem adta meg a szerepkörét!");
        return;
    }
    if(document.getElementById("jelszo1").value.length < 8 || document.getElementById("jelszo2").value.length < 8){
        alert("A jelszaónak minimum 8 karaktert kell tartalmaznia!");
        return;
    }
    if(document.getElementById("jelszo1").value != document.getElementById("jelszo2").value){
        alert("A jelszavak nem egyeznek!");
        return;
    }
    if(document.getElementById("email").value.indexOf("@") == -1){
        alert("Nem megfelelő email cím formátum!");
        return;
    }

    let szerepkor;
    if(document.getElementById("diak").checked) {
        szerepkor = "diak";
    } else {
        szerepkor = "tanar";
    }

    let settings = {
        method : "POST",
        body : JSON.stringify({
            "felhasznalonev" : document.getElementById("felhasznalonev").value,
            "email" : document.getElementById("email").value,
            "szerepkor" : szerepkor,
            "szerepkorid" : document.getElementById("szerepkor").value,
            "jelszo1" : document.getElementById("jelszo1").value,
            "jelszo2" : document.getElementById("jelszo2").value
        })
    }
    let response = await fetch("../php/index.php/regisztracio", settings);
    let data = await response.json();
    alert(data.valasz);
}

document.getElementById("diak").addEventListener("change", szerepkor);
document.getElementById("tanar").addEventListener("change", szerepkor);
async function szerepkor(){
    let diaktanar;
    if(document.getElementById("diak").checked) {
        diaktanar = "diak";
    } else {
        diaktanar = "tanar";
    }

    let settings = {
        method : "POST",
        body : JSON.stringify({
            "diaktanar" : diaktanar
        })
    }
    let response = await fetch("../php/index.php/szerepkor", settings);
    let data = await response.json();
    if(data.valasz != "Nincs találat!") {
        document.getElementById("szerepkor").innerHTML = "";
        if(diaktanar == "diak") {
            for(let item of data) {
                document.getElementById("szerepkor").innerHTML += "<option value='"+item.id+"'>"+item.osztalynev+"</option>";
            }
        } else {
            for(let item of data) {
                document.getElementById("szerepkor").innerHTML += "<option value='"+item.id+"'>"+item.tanarnev+"</option>";
            }
        }
        
    }
};

document.getElementById("jelszoHide1").addEventListener("click", hide1);
function hide1(){
    let kepSRC = document.getElementById("hideImage1");
    let jelszoInputType = document.getElementById("jelszo1");
    if(kepSRC.getAttribute('src') == "../images/unhidePassword.png"){
        kepSRC.setAttribute('src', '../images/hidePassword.png');
        jelszoInputType.setAttribute('type', 'password');
    } else{
        kepSRC.setAttribute('src', '../images/unhidePassword.png');
        jelszoInputType.setAttribute('type', 'text');
    }
}
document.getElementById("jelszoHide2").addEventListener("click", hide2);
function hide2(){
    let kepSRC = document.getElementById("hideImage2");
    let jelszoInputType = document.getElementById("jelszo2");
    if(kepSRC.getAttribute('src') == "../images/unhidePassword.png"){
        kepSRC.setAttribute('src', '../images/hidePassword.png');
        jelszoInputType.setAttribute('type', 'password');
    } else{
        kepSRC.setAttribute('src', '../images/unhidePassword.png');
        jelszoInputType.setAttribute('type', 'text');
    }
}