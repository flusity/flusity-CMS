function toggleDropdown() {
    var options = document.querySelector('.custom-dropdown .options');
    if (options.style.display === 'none' || !options.style.display) {
        options.style.display = 'block';
    } else {
        options.style.display = 'none';
    }
}

var options = document.querySelectorAll('.custom-dropdown .option');
options.forEach(option => {
    option.addEventListener('click', function() {
        window.location.href = this.getAttribute('data-value');
    });
});