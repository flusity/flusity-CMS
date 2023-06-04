function autoDismissError() {
    setTimeout(function() {
        var element = document.getElementById('error_message');
        if (element) {
            element.parentNode.removeChild(element);
        }
    }, 4000); 
}
