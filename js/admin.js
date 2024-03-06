window.addEventListener("load", load);
async function load() {
    let response = await fetch("../php/index.php/adminverify");
    window.location.href = await response.json().valasz;
    if(response.status != 200) {
        window.location.href = await response.json().valasz;
    }
    let data = await response.json();
    console.log(data.valasz);
}

document.getElementById("file").addEventListener("change", feltoltes);
async function feltoltes() {
    let formData = new FormData();
    formData.append("file", file.files[0]);
    let response = await fetch("../php/index.php/feltoltes", {
        method: "POST",
        body: formData
    });
    let data = await response.json();
    console.log(data.valasz);
}