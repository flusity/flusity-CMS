function header1(elementId) {
    wrapText(elementId, '<h1>', '</h1>');
}

function header2(elementId) {
    wrapText(elementId, '<h2>', '</h2>');
}

function header3(elementId) {
    wrapText(elementId, '<h3>', '</h3>');
}

function hypertext(elementId) {
    wrapText(elementId, '<a href="#" target="_blank" title="" alt="">', '</a>');
}

function underlineText(elementId) {
    wrapText(elementId, '<u>', '</u>');
}

function listTextUl(elementId) {
    wrapText(elementId, '<ul>', '</ul>');
}

function listTextLi(elementId) {
    wrapText(elementId, '<li>', '</li>');
}

function quotationMark(elementId) {
    wrapText(elementId, '<q>', '</q>');
}

function markOl(elementId) {
    wrapText(elementId, '<ol>', '</ol>');
}

function markDel(elementId) {
    wrapText(elementId, '<del>', '</del>');
}
function markSub(elementId) {
    wrapText(elementId, '<sub>', '</sub>');
}
function markSup(elementId) {
    wrapText(elementId, '<sup>', '</sup>');
}
function markHr(elementId) {
    wrapText(elementId, '<hr>', '');
}

function boldText(elementId) {
    wrapText(elementId, '<b>', '</b>');
}

function textBreak(elementId) {
    wrapText(elementId, '<br>', '');
}

function markText(elementId) {
    wrapText(elementId, '<mark>', '</mark>');
}

function italicText(elementId) {
    wrapText(elementId, '<i>', '</i>');
}

function paragraphText(elementId) {
    wrapText(elementId, '<p>', '</p>');
}

function previewPost(elementId) {
  var content = document.getElementById(elementId).value;

  var parser = new DOMParser();
  var doc = parser.parseFromString(content, 'text/html');
  var imgElements = doc.getElementsByTagName('img');
  for(var i = 0; i < imgElements.length; i++) {
    var img = imgElements[i];
    var src = img.getAttribute('src');
    if(src && !src.startsWith('http')) {
      img.setAttribute('src', 'http://localhost/' + src);
    }
  }
  content = doc.body.innerHTML;

  document.getElementById('previewModalBody').innerHTML = content;
  var previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
  previewModal.show();
}

function addImage(imageUrl, elementId) {
  var textarea = document.getElementById(elementId);
  var imgTag;
  
  if (imageUrl.indexOf('http://localhost') === 0) {
    var urlParts = imageUrl.split('/');
    var relativeUrl = urlParts.slice(3).join('/');
    imgTag = '<img src="' + relativeUrl + '" title=" " alt=" " width="250px" height="auto" align="left" hspace="15" vspace="15"/>';
  } else {
    imgTag = '<img src="' + imageUrl + '" title=" " alt=" " width="250px" height="auto" align="left" hspace="15" vspace="15"/>';
  }

  var start = textarea.selectionStart;
  var end = textarea.selectionEnd;
  var text = textarea.value;
  var before = text.substring(0, start);
  var after  = text.substring(end, text.length);
  textarea.value = (before + imgTag + '\n' + after);
}




  var page = 0; 

  function selectImage(elementId) {
    $.ajax({
        url: 'get_files.php',
        method: 'GET',
        data: { page: page },
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
              backgroundColor: 'rgba(255, 255, 255, 0.293)',
              color: '#fff',
              height: '100px'
            })
            .on('click', function() {
              var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('imageSelectOffcanvas'));
              offcanvas.hide();
              addImage(image.url, elementId); 
          });
          imageWrapper.append(imageElement);
          imageWrapper.append(buttonElement);
          offcanvasBody.append(imageWrapper);
        });
        var breakElement  =$('<hr>');
        var divStart = $('<div class="hstack gap-3">');
        var divEnd = $('</div>');
        var loadMoreButton = $('<button class="btn file-right"><i class="fas fa-angle-right"></i></button>')
        .on('click', function() {
          page++;  
          selectImage();
        });
        var loadBackButton = $('<button class="btn file-left"><i class="fas fa-angle-left"></i></button>')
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

  function addImageToDynamicField(imageUrl, imageId, targetElementId, previousImageId, previousItemId) {
    var targetElement = document.getElementById(targetElementId);
    if (targetElement === null) {
      console.error("Target element not found.");
      return;
    }
  
    var imgTag;
    if (imageUrl.startsWith('http://localhost')) {
      var relativeUrl = imageUrl.replace('http://localhost', '');
      imgTag = `<img src="${relativeUrl}" width="75px" height="auto"/>`;
    } else {
      imgTag = `<img src="${imageUrl}" width="75px" height="auto"/>`;
    }
  
    var hiddenImageInput = `<input type="hidden" name="image_id[]" value="${imageId || previousImageId}"/>`;
    var hiddenItemInput = `<input type="hidden" name="item_id[]" value="${previousItemId}"/>`; 
  
    targetElement.innerHTML = imgTag + hiddenImageInput + hiddenItemInput; 
  }
  


function selectImageForDynamicField(targetElementId) {
  var targetElement = document.getElementById(targetElementId);
  if (targetElement === null) {
    console.error("Target element not found.");
    return;
  }
  
  var previousImageId = $(targetElement).find('input[name="image_id[]"]').val();
  var previousItemId = $(targetElement).find('input[name="item_id[]"]').val();

  $.ajax({
    url: 'get_files.php',
    method: 'GET',
    data: { page: page },
    dataType: 'json',
    success: function(images) {
      var offcanvasBody = $('#imageSelectOffcanvas .offcanvas-body');
      offcanvasBody.empty();

      images.forEach(function(image) {
        var imageWrapper = $('<div>').css({
          position: 'relative',
          display: 'inline-block',
          margin: '10px'
        });
        
        var imageElement = $('<img>').attr({
          src: image.url,
          width: '100px',
          height: '100px',
          style: 'border-radius: 5px'
        });
        
        var buttonElement = $('<button>Select</button>').css({
          position: 'absolute',
          top: '0',
          bottom: '0',
          left: '0',
          right: '0',
          margin: 'auto',
          backgroundColor: 'rgba(255, 255, 255, 0.293)',
          color: '#fff',
          height: '100px'
        }).on('click', function() {
          var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('imageSelectOffcanvas'));
          offcanvas.hide();
          addImageToDynamicField(image.url, image.id, targetElementId, previousImageId, previousItemId);  
        });
        
        imageWrapper.append(imageElement);
        imageWrapper.append(buttonElement);
        offcanvasBody.append(imageWrapper);
      });

      var breakElement  =$('<hr>');
      var divStart = $('<div class="hstack gap-3">');
      var divEnd = $('</div>');
      var loadMoreButton = $('<button class="btn file-right"><i class="fas fa-angle-right"></i></button>')
      .on('click', function() {
        page++;  
        selectImageForDynamicField(targetElementId);
      });
      var loadBackButton = $('<button class="btn file-left"><i class="fas fa-angle-left"></i></button>')
      .on('click', function() {
        page--;  
        selectImageForDynamicField(targetElementId);
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

/* $(document).on('click', '.selectable-image', function() {
    var imageName = $(this).data('image-name');
    var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('imageSelectOffcanvas'));
    offcanvas.hide();
    addImage(imageName);
  }); */