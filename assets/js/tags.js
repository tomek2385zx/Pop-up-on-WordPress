
//Displaying Pop-up window
function popup() {
    var x = document.getElementById("communicator");
    var y = document.getElementById("products");
    if (x.style.display == "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
        y.style.display = "none";
    }
}

//Hide everything
function xhide(){
    var hide = document.getElementById('exit');
    var popup = document.getElementById('przycisk');
    var communicator = document.getElementById("communicator");
    var products = document.getElementById("products");

        hide.style.display = "none";
        popup.style.display = "none";
        communicator.style.display = "none";
        products.style.display = "none";
}
