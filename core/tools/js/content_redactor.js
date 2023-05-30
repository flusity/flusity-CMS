

function underlineText() {
    document.execCommand('underline', false, null);
}

function boldText() {
    document.execCommand('bold', false, null);
}

function italicText() {
    document.execCommand('italic', false, null);
}


function underlineText() {
    var textarea = document.getElementById("post_content");
    var selectedText = document.getSelection().toString();
    var text = textarea.value;
    var newText = text.replace(selectedText, '<u>' + selectedText + '</u>');
    textarea.value = newText;
}

function boldText() {
    wrapText('post_content', '<b>', '</b>');
}

function italicText() {
    wrapText('post_content', '<i>', '</i>');
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