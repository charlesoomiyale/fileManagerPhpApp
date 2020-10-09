
var openPhotoSwipe = function(images) {
    //console.log('function images', images);
    var pswpElement = document.querySelectorAll('.pswp')[0];
    var photoImage = images.split(",");
    // console.log(photoImage);

    // build image items array
    var items = [];

    $.each(photoImage, function(index, imageDetails){
        console.log(imageDetails);
        var imageDet = String(imageDetails);
        var imageRecord = imageDet.split('|');
        var imageLoc = imageRecord[0];
        var imageCap = imageRecord[1];
        //console.log(imageLoc);
        var imageObj = {src: imageLoc, w: 0, h: 0, title: imageCap}
        //console.log(imageObj);
        items.push(imageObj);
    });
    
    // define options (if needed)
    var options = {
             // history & focus options are disabled on CodePen        
        index: 0
        
    };
    
    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);

    gallery.listen('gettingData', function(index, item) {
        if (item.w < 1 || item.h < 1) { // unknown size
        var img = new Image(); 
        img.onload = function() { // will get size after load
            // console.log(this.width);
        item.w = this.width; // set image width
        item.h = this.height; // set image height
           gallery.invalidateCurrItems(); // reinit Items
           gallery.updateSize(true); // reinit Items
        }
    img.src = item.src; // let's download image
    }
});

    gallery.init();
};


$(document).ready(function() {

    $("#viewEventGallery").on('click', function(){
        var postImages = $("#postimages").val();
        //console.log(postImages);
        openPhotoSwipe(postImages);
    });
});