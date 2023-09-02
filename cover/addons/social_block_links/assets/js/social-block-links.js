
/* 
* Indicates in the JS files where to present the libraries in the document.
* Important! indicate where to broadcast the head or footer, necessarily between the comments
*/
/*footer*/

document.addEventListener('DOMContentLoaded', function() {
    // Select all icons
    var icons = document.querySelectorAll('.social-link-icon-item a');

    icons.forEach(function(icon) {
        icon.addEventListener('mouseover', function() {
            // Add an effect when mouse is over the icon
            this.style.transform = 'scale(1.2)';
        });
        
        icon.addEventListener('mouseout', function() {
            // Remove the effect when mouse is out
            this.style.transform = 'scale(1)';
        });
    });
});
