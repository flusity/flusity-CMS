

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

function textBreak() {
    wrapText('post_content', '<br>', '');
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

function addImage(imageUrl) {
    var textarea = document.getElementById('post_content'); // Įrašykite savo textarea ID čia
    var urlParts = imageUrl.split('/');
    var relativeUrl = urlParts.slice(3).join('/');
  
    var imgTag = '<img src="' + relativeUrl + '" width="250px" height="auto" align="left" hspace="15" vspace="15"/>';
    textarea.value += imgTag + '\n';
  }
  var page = 0; 
  function selectImage() {
    $.ajax({
        url: 'get_files.php',
        method: 'GET',
        data: { page: page },  // perduoti puslapio numerį kaip duomenų parametrą
        dataType: 'json',
      success: function(images) {
        var offcanvasBody = $('#imageSelectOffcanvas .offcanvas-body');
        offcanvasBody.empty();
  
        images.forEach(function(image) {
          var imageWrapper = $('<div>')
            .css({
              position: 'relative',
              display: 'inline-block',
              margin: '10px'
            });
          var imageElement = $('<img>')
            .attr('src', image.url)
            .attr('width', '100px')
            .attr('height', '100px')
            .attr('style', 'border-radius: 5px');
          var buttonElement = $('<button>Select</button>')
            .css({
              position: 'absolute',
              top: '0',
              bottom: '0',
              left: '0',
              right: '0',
              margin: 'auto',
              backgroundColor: 'rgba(0, 0, 0, 0.5)',
              color: '#fff',
              height: '100px'
            })
            .on('click', function() {
              var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('imageSelectOffcanvas'));
              offcanvas.hide();
              addImage(image.url);
            });
          imageWrapper.append(imageElement);
          imageWrapper.append(buttonElement);
          offcanvasBody.append(imageWrapper);
        });
        var breakElement  =$('<hr>');
        var divStart = $('<div class="hstack gap-3">');
        var divEnd = $('</div>');
        var loadMoreButton = $('<button>Load More</button>')
        .on('click', function() {
          page++;  
          selectImage();
        });
        var loadBackButton = $('<button>Load Down</button>')
        .on('click', function() {
          page--;  
          selectImage();
        });
        offcanvasBody.append(divStart);
        offcanvasBody.append(breakElement);
        offcanvasBody.append(loadBackButton);
        offcanvasBody.append(loadMoreButton);
        offcanvasBody.append(divEnd);

        var offcanvas = new bootstrap.Offcanvas(document.getElementById('imageSelectOffcanvas'));
        offcanvas.show();
      }
    });
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

$(document).on('click', '.selectable-image', function() {
    var imageName = $(this).data('image-name');
    var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('imageSelectOffcanvas'));
    offcanvas.hide();
    addImage(imageName);
  });
