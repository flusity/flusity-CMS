/* 
* Indicates in the JS files where to present the libraries in the document.
* Important! indicate where to broadcast the head or footer, necessarily between the comments
*/
/*head*/

function updateCalendar(month, year) {
    $.ajax({
        type: 'GET',
        url: '../../cover/addons/event_callendar/callendar.php',
        data: { 'month': month, 'year': year },
        success: function(data) {
           
            $('#calendar-container').html(data);
           
            attachEventListeners();
        }
        
    });
}
