document.getElementById("osztalyok").addEventListener("click", osztalyok);
async function osztalyok(){
    let response = await fetch("./php/index.php/osszesOsztaly");
    let data = await response.json();
    if(data.valasz == null) {
        document.getElementById("eredm").innerHTML = "";
        for(let item of data){
            document.getElementById("eredm").innerHTML+='<a id="'+item.id+'">'+item.osztalynev+'</a>';
        }
    } else {
        document.getElementById("eredm").innerHTML = data.valasz;
    }
}

document.getElementById("tanarok").addEventListener("click", tanarok);
async function tanarok(){
    let response = await fetch("./php/index.php/osszesTanar");
    let data = await response.json();
    if(data.valasz == null) {
        document.getElementById("eredm").innerHTML = "";
        for(let item of data){
            document.getElementById("eredm").innerHTML+='<a id="'+item.id+'">'+item.tanarnev+'</a>';
        }
    } else {
        document.getElementById("eredm").innerHTML = data.valasz;
    }
}