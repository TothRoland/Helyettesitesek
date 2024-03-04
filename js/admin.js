window.addEventListener("load", load);

async function load() {
    let response = await fetch("../php/index.php/adminverify");
    let data = await response.json();
    if(data.valasz != "Jogosult az oldalhoz!"){
        window.location.href = data.valasz;
    }
}