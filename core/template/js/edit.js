
window.onload = function() {
    var dropdownBtns = document.querySelectorAll(".add-link");
    dropdownBtns.forEach(function(btn) {
        var dropdownMenu = btn.nextElementSibling;
        btn.addEventListener("click", function() {
            if (dropdownMenu.style.display === "none") {
                dropdownMenu.style.display = "block";
            } else {
                dropdownMenu.style.display = "none";
            }
        });
    });

   
}

document.querySelectorAll(".addons-button").forEach(function(button) {
    button.addEventListener("click", function() {
        var addonsMenu = button.nextElementSibling;
        if (addonsMenu.style.display === "none") {
            addonsMenu.style.display = "block";
        } else {
            addonsMenu.style.display = "none";
        }
    });
});


/* document.getElementById("addons-button").addEventListener("click", function() {
    var addonsMenu = document.getElementById("addons-menu");
    if (addonsMenu.style.display === "none") {
        addonsMenu.style.display = "block";
    } else {
        addonsMenu.style.display = "none";
    }
}); */

document.querySelectorAll('.myDropdown').forEach(function(dropdown) {
    dropdown.addEventListener('mouseleave', function() {
        this.querySelector('.myDropdown-menu').style.display = 'none';
    });
});