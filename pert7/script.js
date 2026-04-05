// const tombol = document.getElementById('tombol');
// tombol.onclick = function() {
//     alert('tombol diklik');
// }

// const form = document.querySelector('form');
// form.addEventListener('submit', function(event) {
//     event.preventDefault();
//     const name = document.querySelector('name').value;
//     alert('Nama yang dimasukkan: ' + name);
// });

// function ubah() {
//     document.getElementById("judul").textContent = "Judul telah diubah";

//     document.getElementById("paragraf").innerHTML = "Paragraf telah diubah dengan <strong>HTML</strong>";
// }
// function ubahStyle() {
//     const element = document.getElementById("judul");
//     element.style.color = "red";
//     element.style.fontSize = "24px";
//     element.style.fontWeight = "bold";
// }

function cekAngka(){
    let x = document.getElementById("angka").value;
    let hasil;

    if (isNaN(x)|| x < 1 || x > 10) {
        hasil = "Input tidak valid.";
    } else {
        hasil = "Input valid.";
    }
    document.getElementById("hasil").textContent = hasil;
}