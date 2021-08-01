

var Place = function () {

    var init = function () {
        
       
        readImage('image');
        for (let i = 0; i < 12; i++) {
                readImageMulti('image_' + i + '');
                readImageMulti('image_' + i + '');
        }
    };


  
   var readImage= function (input) {

        $(document).on('click', "." + input, function () {
            $("#" + input).trigger('click');
        });
        $(document).on('change', "#" + input, function () {
            //alert($(this)[0].files.length);
            for (var i = 0; i < $(this)[0].files.length; i++) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.' + input + '_box').html('<img style="height:80px;width:150px;" id="image_upload_preview" class="' + input + '" src="' + e.target.result + '" alt="your image" />');
                }
             
                reader.readAsDataURL($(this)[0].files[i]);
            }
        });
   }
   var readImageMulti= function (x) {

    $(document).on('click', "." + x, function () {
        $("#" + x).trigger('click');
    });

    $(document).on('change', "#" + x, function () {
        //console.log($(this));
        for (var i = 0; i < $(this)[0].files.length; i++) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.' + x + '_box').html('<img style="height:80px;width:100px;" id="image_upload_preview" class="' + x + '" src="' + e.target.result + '" alt="your image" />');
            }
            reader.readAsDataURL($(this)[0].files[i]);
        }

    });



}
 var readImageMultiWithRemove = function (y) {

    $(document).on('click', "." + y, function () {
        $("#" + y).trigger('click');
    });

    $(document).on('change', "#" + y, function () {

        for (var i = 0; i < $(this)[0].files.length; i++) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.' + y + '_box').html('<a href="javascript:;" style="position: absolute; top: 10%; right:0; left: 0; bottom: 0; width:25px; height:25px;" onclick = "My.deleteImage(this);return false;"><img style="width:25px; height:25px;" src="' + config.url + '/delete-btn.png" /></a><img style="height:80px;width:100px;" id="image_upload_preview" class="" src="' + e.target.result + '" alt="your image" />');
            }
            reader.readAsDataURL($(this)[0].files[i]);
        }

    });
}


 

    return {
        init: function () {
            init();
        }
    };

}();
jQuery(document).ready(function () {
    Place.init();
});