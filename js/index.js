document.getElementById("bejelentkezes").addEventListener("click", login);
async function login(){
    let settings = {
        method : "POST",
        body : JSON.stringify({
            "jelszo" : document.getElementById("jelszo").value
        })
    }
    let response = await fetch("../php/index.php/login", settings);
    let data = await response.json();
    console.log(data);
}

document.getElementById("jelszoHide").addEventListener("click", hide);
function hide(){
    let kepSRC = document.getElementById("hideImage");
    let jelszoInputType = document.getElementById("jelszo");
    if(kepSRC.getAttribute('src') == "../images/unhidePassword.png"){
        kepSRC.setAttribute('src', '../images/hidePassword.png');
        jelszoInputType.setAttribute('type', 'text');
    } else{
        kepSRC.setAttribute('src', '../images/unhidePassword.png');
        jelszoInputType.setAttribute('type', 'password');
    }
}