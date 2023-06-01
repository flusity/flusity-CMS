


let contentArea = document.getElementById('post_content');
let displayArea = document.getElementById('display_area');




contentArea.addEventListener('input', function() {
    displayArea.innerHTML = contentArea.value;
});


function header1() {
    wrapText('post_content', '<h1>', '</h1>');
}

function header2() {
    wrapText('post_content', '<h2>', '</h2>');
}

function header3() {
    wrapText('post_content', '<h3>', '</h3>');
}

function hypertext() {
    wrapText('post_content', '<a href="#" target="_blank">', '</a>');
}

function underlineText() {
    wrapText('post_content', '<u>', '</u>');
}

function listTextUl() {
    wrapText('post_content', '<ul>', '</ul>');
}

function listTextLi() {
    wrapText('post_content', '<li>', '</li>');
}

function quotationMark() {
    wrapText('post_content', '<q>', '</q>');
}

function markOl() {
    wrapText('post_content', '<ol>', '</ol>');
}

function markDel() {
    wrapText('post_content', '<del>', '</del>');
}
function markSub() {
    wrapText('post_content', '<sub>', '</sub>');
}
function markSup() {
    wrapText('post_content', '<sup>', '</sup>');
}
function markHr() {
    wrapText('post_content', '<hr>', '');
}

function boldText() {
    wrapText('post_content', '<b>', '</b>');
}

function markText() {
    wrapText('post_content', '<mark>', '</mark>');
}

function italicText() {
    wrapText('post_content', '<i>', '</i>');
}

function paragraphText() {
    wrapText('post_content', '<p>', '</p>');
}

  function selectImage() {
    var offcanvas = new bootstrap.Offcanvas(document.getElementById('imageSelectOffcanvas'));
    offcanvas.show();
  }
 
function wrapText(elementId, openTag, closeTag) {
    var textarea = document.getElementById(elementId);
    if ('selectionStart' in textarea) {
        var len = textarea.value.length;
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var selectedText = textarea.value.substring(start, end);
        var replacement = openTag + selectedText + closeTag;
        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end, len);
    } else {
        textarea.value += openTag + closeTag;
    }
}

