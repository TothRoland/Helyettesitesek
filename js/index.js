document.getElementById("tanarok").addEventListener("click", tanarok);
async function tanarok(){
    let response = await fetch("./php/index.php/osszesTanar");
    let data = await response.json();

    for(let item of data){
        document.getElementById("eredm").innerHTML+='<p id="'+item.id+'">'+item.tanarnev+'</p>';
    }
}

/*document.getElementById("test").addEventListener("click",test);
async function test(){
    let settings = {
        method : "POST",
        body : JSON.stringify({
            "apiKey" : "7856d350-1fda-45f5-822d-e1a2f3f1acf0"
        })
    }
    let response = await fetch("https://cors-anywhere.herokuapp.com/https://kretaglobalmobileapi2.ekreta.hu/api/v3/Institute", settings);
    let data = await response.json();

    console.log(data)
}*/

/*document.getElementById("tanarok").addEventListener("click", osztalyok);
async function osztalyok(){
    for (let i = 9; i < 14; i++){
        for (let j = 0; j < 14; j++)
        let settings = {
            method : "POST",
            body : JSON.stringify({
                "id" : i,
                "osztalynev" : ""
            })
        }
        let response = await fetch("php/index.php/osztalyfeltolt", settings);
        let data = await response.json();
        console.log(data);
    }
}*/