

$.fn.checkLoginSession = function () {
    var locUrl = window.location.pathname;
    var accessAdmin = localStorage.getItem('admin');
    var adminName = localStorage.getItem('name');
    var isAdmin = localStorage.getItem('isAdmin');
    var fileAdmin = localStorage.getItem('file');
    var newsAdmin = localStorage.getItem('news');
    var accessKey = localStorage.getItem('accessKey');
    var expiresTime = localStorage.getItem('expiresIn');
    var whenSet = localStorage.getItem('whenSet');
    var loc = locUrl.substring(locUrl.lastIndexOf('/') + 1 );
    var dashMain = 'dashboard/';

    var thenMoment = moment(whenSet,'x');
    var laterMoment = moment(expiresTime,'x').valueOf();

    var timeDiff = moment().isBefore(laterMoment);

    if (!timeDiff && accessKey != null) {
        localStorage.clear();
        window.location.replace("./../index.html");
    }else{
        var updateAccess = moment().add(1, 'h');
        var updateSession = updateAccess.valueOf();
        var updateWhenSet = moment().valueOf();
        if (accessKey != null ) {
            localStorage.setItem("admin",accessAdmin);
            localStorage.setItem("accessKey", accessKey);
            localStorage.setItem("whenSet", updateWhenSet );
            localStorage.setItem("expiresIn", updateSession);
        }
    }

    // check variable !!(arr.indexOf("val")+1)

    if (loc == 'index.html' && ( accessKey != null)) {
        accessKey = null;
        window.location.replace("./dashboard/home.php");
    }
    var dashBoardFiles = ["home.php", "filemanager.php", "newsandevent.php", "profile.php"];

    if (dashBoardFiles.includes(loc) && ( accessKey == null)) {
        accessKey = null;
        window.location.replace("./../index.html");
    }

};

$.fn.adminSessionUpdate = function () {
    var adminName = localStorage.getItem('name');
    var isAdmin = localStorage.getItem('isAdmin');
    var fileAdmin = localStorage.getItem('file');
    var newsAdmin = localStorage.getItem('news');
    var superAdmin = localStorage.getItem('superAdmin');
    var canDownload = localStorage.getItem("download");


    // console.log('Admin: '+isAdmin, 'File: '+fileAdmin, 'News: '+newsAdmin, )

    $('.adminName').text(adminName);

    if (!superAdmin) {
        $('.superAdmin').hide();
    }

    if (!isAdmin) {
        $('.isAdmin').hide();
    }

    if (!fileAdmin) {
        $('.fileAdmin').hide();
    }
    if (!newsAdmin) {
        $('.newsAdmin').hide();
    }

    if (!canDownload) {
        $('.canDownload').hide();
    }
}


$(document).ready(function() {

    $('body').checkLoginSession();
    $('body').adminSessionUpdate();
    $("#loading").hide();

    // Weekly info updates...
    $('#weekinfoForm').on('submit', function(e){

        e.preventDefault();
        var postData = $(this).serializeArray();
        var formUrl = $(this).attr('action');
        console.log(postData);
        $("#weekinfoSubmit").prop("disabled", true);
        $("#loading").show();

        $.ajax({
            url: formUrl,
            type: "POST",
            data: postData,

            success: function(res,textStatus,jqXHR)
            {
                // var result = JSON.stringify(res);
                console.log(res);
                var res = JSON.parse(res);
                $("#loading").hide();
                $("#weekinfoSubmit").prop("disabled", false);
                 console.log(res);
                 console.log(res.status);
                if (res.status == '1') {
                    //alert(res.message);
                    $(".formInput").val();
                    $('.closeModal').click();
                    Swal.fire({
                      type: 'success',
                      title: res.message,
                      showConfirmButton: true,
                      onClose: () => {
                            $(".formInput").val();
                            location.reload();
                        }
                    });

                }
                else
                {
                    Swal.fire({
                      type: 'error',
                      title: res.message,
                      showConfirmButton: false,
                      timer: 1500
                    });
                }


            },
            error: function(jqXHR,status, error){
                $('#resultstatus').text(status+': '+error);
                console.log(status+': '+error);
            }
        });
    });

    // Month info updates...
    $('#monthinfoForm').on('submit', function(e){

        e.preventDefault();
        var postData = $(this).serializeArray();
        var formUrl = $(this).attr('action');
        console.log(postData);
        $("#monthinfoForm").prop("disabled", true);
        $("#loading").show();

        $.ajax({
            url: formUrl,
            type: "POST",
            data: postData,

            success: function(res,textStatus,jqXHR)
            {
                // var result = JSON.stringify(res);
                console.log(res);
                var res = JSON.parse(res);
                $("#loading").hide();
                $("#monthinfoForm").prop("disabled", false);
                 console.log(res);
                 console.log(res.status);
                if (res.status == '1') {
                    //alert(res.message);
                    $(".formInput").val();
                    $('.closeModal').click();
                    Swal.fire({
                      type: 'success',
                      title: res.message,
                      showConfirmButton: true,
                      onClose: () => {
                            $(".formInput").val();
                            location.reload();
                        }
                    });

                }
                else
                {
                    Swal.fire({
                      type: 'error',
                      title: res.message,
                      showConfirmButton: false,
                      timer: 1500
                    });
                }


            },
            error: function(jqXHR,status, error){
                $('#resultstatus').text(status+': '+error);
                console.log(status+': '+error);
            }
        });
    });

    $('#fileSubsection').on('change', function(e){
        var filesectionCat = $("#fileCategory").val();
        var filesectionGroup = $("#fileDepartmentGroup").val();
        var fileSubsection = $("#fileSubsection").val();
        console.log(filesectionCat, filesectionGroup, fileSubsection );
        var formData = {
            cat_id: filesectionCat,
            group_id: filesectionGroup,
            section_id: fileSubsection,
            loadfiles: 1
        };

        if(!filesectionGroup || filesectionGroup == ""){
            error_message += "Please select a CATEGORY section for the file(s) ";
            alertSweet(error_message, 0);
            return;
        } else{
            $("#uploadingFiles").show();
            $.ajax({
                    url: "./../adminmanager.php",
                    type: "POST",
                    data: formData,

                    success: function(res,textStatus,jqXHR)
                    {
                        // var result = JSON.stringify(res);
                        console.log(res);

                        var res = JSON.parse(res);
                        var tableRole = "";
                        if (res.status == '1') {
                            var sections = res.sections;
                            $.each(sections, function(index, value){
                                //var adminCheck = '<?php if(!is_null($user) && $user[10] !=1){echo \"style=\'display: none;\'";}?>';
                                var adminCheck = '';

                                tableRole += '<tr>'+
                                    '<td>'+ (index+1) +'</td>'+
                                    '<td>'+ value[1] +'</td>'+
                                    '<td>'+ value[8] +'</td>'+
                                    '<td>'+ value[9] +'</td>'+

                                    '<td>'+
                                        '<a class="canDownload" '+adminCheck+' target="blank" href="./../'+value[3]
                                        +'"><span class="downloadBtn" style="color: green;"><i class="fa fa-download"></i></span></a>'+
                                    '</td>'+
                                    '<td>'+
                                        '<a class="superAdmin deleteUploadFileBtn" style="color: red;" id="deleteUploadFile_'+value[0]+'" ><i class="fa fa-trash"></i></a>'+
                                        '<div class="deletingUploadedFile" id="deletingUploadedFile_'+value[0]+'" style="display: none;" >'+
                                           ' .... <img src="../images/pie.gif" style="height: 14px; width: 14px;">'+
                                        '</div>'+
                                    '</td>'+

                                +'</tr>'


                            });
                            $("#uploadingFiles").hide();
                            $("#datatableDashboard").show();
                            $("#fileLoaderDatatable").html(tableRole);

                        }else{
                            alertSweet(res.message, 0);
                            $("#uploadingFiles").hide();
                            $("#datatableDashboard").hide();
                        }

                    },
                    error: function(jqXHR,status, error){
                        console.log(status+': '+error);
                    }
                });
        }
    });

    $('#fileDepartmentGroup').on('change', function(e){
        var filesectionCat = $("#fileCategory").val();
        var filesectionGroup = $("#fileDepartmentGroup").val();


        var formData = {
            cat_id: filesectionCat,
            group_id: filesectionGroup,
            getsections: 1
        };

        if(!filesectionGroup || filesectionGroup == ""){
            error_message += "Please select a department section for the file(s) ";
            alertSweet(error_message, 0);
            return;
        } else{

            $.ajax({
                    url: "./../adminmanager.php",
                    type: "POST",
                    data: formData,

                    success: function(res,textStatus,jqXHR)
                    {
                        // var result = JSON.stringify(res);
                        console.log(res);

                        var res = JSON.parse(res);
                        var options = '<option value="">Choose...</option>';
                        if (res.status == '1') {
                            var sections = res.sections;
                            $.each(sections, function(index, value){
                                options +='<option value="'+value[0]+'">'+value[3]+'</option>';
                            });
                            $("#displaySub").show();
                            $("#fileSubsection").html(options);

                        }

                    },
                    error: function(jqXHR,status, error){
                        console.log(status+': '+error);
                    }
                });
        }
    });

    $('#filesectionUpload').on('change', function(e){
        var filesectionCat = $("#fileCategory").val();
        var filesectionGroup = $("#filesectionUpload").val();


        var formData = {
            cat_id: filesectionCat,
            group_id: filesectionGroup,
            getsections: 1
        };

        if(!filesectionGroup || filesectionGroup == ""){
            error_message += "Please select a department section for the file(s) ";
            alertSweet(error_message, 0);
            return;
        } else{

            $.ajax({
                    url: "./../adminmanager.php",
                    type: "POST",
                    data: formData,

                    success: function(res,textStatus,jqXHR)
                    {
                        // var result = JSON.stringify(res);
                        console.log(res);

                        var res = JSON.parse(res);
                        var options = '<option value="">Choose...</option>';
                        if (res.status == '1') {
                            var sections = res.sections;
                            $.each(sections, function(index, value){
                                options +='<option value="'+value[0]+'">'+value[3]+'</option>';
                            });
                            $("#displaySub1").show();
                            $("#fileSubsection1").html(options);

                        }

                    },
                    error: function(jqXHR,status, error){
                        console.log(status+': '+error);
                    }
                });
        }
    });


    $('#fileUploadForm').on('submit', function(e){
        e.preventDefault();

        var filesectionCat = $("#fileCategory").val();
        var filesectionUpload = $("#filesectionUpload").val();
        var filesectionGroup = $("#fileSubsection1").val();

        if((!filesectionUpload || filesectionUpload == "") || (!filesectionGroup || filesectionGroup == "")){
            error_message = "Please ensure both category section and sub section have been selected for the file(s) ";
            alertSweet(error_message, 0);
            return;
        }
        var error_message = "";
        var formData = new FormData();
        var files = $('#fileFeatInputFile')[0].files;

        if(!files || files.length == 0){
            error_message = "You must choose at least a file for upload.";
            alertSweet(error_message, 0);
            return;
        }

        if (files.length > 5) {
            error_message = "You are not allowed to upload more than 5 files at once!!";
            alertSweet(error_message, 0);
            return;

        } else{
            for (let i = 0; i < files.length; i++) {
                var file = files[i];
                // console.log(file);
                var name = file.name;
                var ext = name.split('.').pop().toLowerCase();

                if(jQuery.inArray(ext, ['jpg','jpeg', 'png','pdf','doc', 'docx','xls', 'xlsx']) == -1) {
                    error_message += "<h6>Invalid File type on file "+i+". (Only excel document is allowed) </h6>";
                }
                formData.append('file[]', file);
            }

            formData.append('fileUpload', 'fileUpload');
            formData.append('cat_id', filesectionCat);
            formData.append('group_id', filesectionUpload);
            formData.append('section_id', filesectionGroup);

            if (error_message != "") {
                alertSweetHTML(error_message, 0);
                return;
            }else{
                $.ajax({
                    url: "./../adminmanager.php",
                    type: "POST",
                    data: formData,
                    contentType:false,
                    cache:false,
                    processData: false,
                    beforeSend: function(){
                        $("#uploadingFeat").show();
                        $("#fileFeatInputFile").prop("disabled", true);
                    },

                    success: function(res,textStatus,jqXHR)
                    {
                        // var result = JSON.stringify(res);
                        console.log(res);
                        var res = JSON.parse(res);
                        $("#uploadingFeat").hide();
                        $("#fileFeatInputFile").prop("disabled", false);
                         //console.log(res);
                         //console.log(res.status);
                        if (res.status == '1') {

                            Swal.fire({
                              type: 'success',
                              title: res.message,
                              showConfirmButton: true,
                              onClose: () => {
                                    location.reload();
                                }
                            });

                        }
                        else
                        {

                            Swal.fire({
                              type: 'error',
                              title: res.message,
                              showConfirmButton: false,
                              timer: 2500
                            });
                        }


                    },
                    error: function(jqXHR,status, error){
                        $('#resultstatus').text(status+': '+error);
                         $("#uploadingFeat").hide();
                         $("#fileFeatInputFile").prop("disabled", false);
                        console.log(status+': '+error);
                    }
                });
            }
        }
    });


    $('#fileFeatInputFile1').on('change', function(e){

        var filesectionCat = $("#fileCategory").val();
        var filesectionUpload = $("#filesectionUpload").val();
        if(!filesectionUpload || filesectionUpload == ""){
            error_message += "Please select a department section for the file(s) ";
            alertSweet(error_message, 0);
            return;
        }
        var error_message = "";
        var formData = new FormData();
        var files = $('#fileFeatInputFile')[0].files;

        if (files.length > 5) {
            error_message += "You are not allowed to upload more than 5 files at once!!";
            alertSweet(error_message, 0);
            return;

        } else{
            for (let i = 0; i < files.length; i++) {
                var file = files[i];
                console.log(file);
                var name = file.name;
                var ext = name.split('.').pop().toLowerCase();

                if(jQuery.inArray(ext, ['jpg','jpeg', 'png','pdf','doc', 'docx','xls', 'xlsx']) == -1) {
                    error_message += "<h6>Invalid File type on file "+i+". (Only excel document is allowed) </h6>";
                }
                formData.append('file[]', file);
            }

            formData.append('fileUpload', 'fileUpload');
            formData.append('cat_id', filesectionCat);
            formData.append('group_id', filesectionUpload);

            if (error_message != "") {
                alertSweetHTML(error_message, 0);
                return;
            }else{
                $.ajax({
                    url: "./../adminmanager.php",
                    type: "POST",
                    data: formData,
                    contentType:false,
                    cache:false,
                    processData: false,
                    beforeSend: function(){
                        $("#uploadingFeat").show();
                        $("#fileFeatInputFile").prop("disabled", true);
                    },

                    success: function(res,textStatus,jqXHR)
                    {
                        // var result = JSON.stringify(res);
                        // console.log(res);
                        var res = JSON.parse(res);
                        $("#uploadingFeat").hide();
                        $("#fileFeatInputFile").prop("disabled", false);
                         //console.log(res);
                         //console.log(res.status);
                        if (res.status == '1') {

                            Swal.fire({
                              type: 'success',
                              title: res.message,
                              showConfirmButton: true,
                              onClose: () => {
                                    location.reload();
                                }
                            });

                        }
                        else
                        {

                            Swal.fire({
                              type: 'error',
                              title: res.message,
                              showConfirmButton: false,
                              timer: 2500
                            });
                        }


                    },
                    error: function(jqXHR,status, error){
                        $('#resultstatus').text(status+': '+error);
                         $("#uploadingFeat").hide();
                         $("#fileFeatInputFile").prop("disabled", false);
                        console.log(status+': '+error);
                    }
                });
            }
        }
    });

    var myDomElement = document.getElementById( "uploadedFileTable" );
    //console.log("Table dom element", myDomElement);
    $(myDomElement).dataTable({
        "pageLength": 10
    });

    // News post...
    $('#createNews').on('click', function(e){
        $('#newModalTitle').text("Add");
        $('#editnewspost').val("");
        $('.formInput').val("");
    });

    $('#newsandeventsForm').on('submit', function(e){

        e.preventDefault();
        var postData = $(this).serializeArray();
        var formUrl = $(this).attr('action');

        var postId = postData[1].value;

        $("#newsandeventSubmit").prop("disabled", true);
        $("#loading").show();

        $.ajax({
            url: formUrl,
            type: "POST",
            data: postData,

            success: function(res,textStatus,jqXHR)
            {
                // var result = JSON.stringify(res);
                console.log(res);
                var res = JSON.parse(res);
                $("#loading").hide();
                $("#newsandeventSubmit").prop("disabled", false);
                 console.log(res);
                 console.log(res.status);
                if (res.status == '1') {
                    //alert(res.message);
                    $(".formInput").val();
                    $('.closeModal').click();
                    Swal.fire({
                      type: 'success',
                      title: res.message,
                      showConfirmButton: true,
                      onClose: () => {
                            $(".formInput").val();
                            if (!postId || postId == "") {
                                location.reload();
                            }
                        }
                    });

                }
                else
                {
                    Swal.fire({
                      type: 'error',
                      title: res.message,
                      showConfirmButton: false,
                      timer: 1500
                    });
                }


            },
            error: function(jqXHR,status, error){
                $('#resultstatus').text(status+': '+error);
                console.log(status+': '+error);
            }
        });
    });


    $('.editNews').on('click', function(e) {
        // body...
        var newsDetails = $(this).attr('id');
        var newsDetailsArr = newsDetails.split('_');

        var newsId = newsDetailsArr[1];

        var formData = {
            news_id: newsId,
            getnews: 1
        };

        $.ajax({
            url: "./../adminmanager.php",
            type: "POST",
            data: formData,
            success: function(res,textStatus,jqXHR)
            {
                // var result = JSON.stringify(res);
                // console.log(res);
                var res = JSON.parse(res);

                if (res.status == '1') {
                    $('#newModalTitle').text("Edit");

                    var fetchedDetails = res.news;
                    $('#editnewspost').val(fetchedDetails.id);
                    $('#subject').val(fetchedDetails.post_topic);
                    $('#news_body').val(fetchedDetails.post_body);

                }
                else
                {

                    Swal.fire({
                      type: 'error',
                      title: res.message,
                      showConfirmButton: false,
                      timer: 2500
                    });
                }


            },
            error: function(jqXHR,status, error){

                console.log(status+': '+error);
            }
        });
    });

    $('.readNews').on('click', function(e) {
        // body...
        var newsDetails = $(this).attr('id');
        var newsDetailsArr = newsDetails.split('_');

        var newsId = newsDetailsArr[1];

        var formData = {
            news_id: newsId,
            getnews: 1
        };

        $.ajax({
            url: "./../adminmanager.php",
            type: "POST",
            data: formData,
            success: function(res,textStatus,jqXHR)
            {
                // var result = JSON.stringify(res);
                // console.log(res);
                var res = JSON.parse(res);

                if (res.status == '1') {

                    var fetchedDetails = res.news;
                    var post_url = '../'+fetchedDetails.post_url;
                    $('#readNewsModalSubject').text(fetchedDetails.post_topic);
                    $('#readNewsBannerImg').attr('src', post_url);
                    $('#readNewsModalContent').html(fetchedDetails.post_body);

                }
                else
                {

                    Swal.fire({
                      type: 'error',
                      title: res.message,
                      showConfirmButton: false,
                      timer: 2500
                    });
                }


            },
            error: function(jqXHR,status, error){

                console.log(status+': '+error);
            }
        });
    });

    $(document).on('click', '.deleteNews', function(e){
        var newsDetails = $(this).attr('id');
        var newsDetailsArr = newsDetails.split('_');

        var newsId = newsDetailsArr[1];

        var formData = {
            news_id: newsId,
            deletenews: 1
        };

        Swal.fire({
          title: 'Are you sure?',
          text: "Do you really intend to delete this news and event post",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, proceed!!'
        }).then((result) => {
          if (result.value) {

            $.ajax({
                    url: "./../adminmanager.php",
                    type: "POST",
                    data: formData,
                    beforeSend: function(){
                        $("#deletingNews_"+newsId).show();
                        //$(this).hide();
                    },

                    success: function(res,textStatus,jqXHR)
                    {
                        // var result = JSON.stringify(res);
                        console.log(res);
                        var res = JSON.parse(res);
                        $("#deletingNews_"+newsId).hide();
                        $(this).show();
                         console.log(res);
                         console.log(res.status);
                        if (res.status == '1') {

                            Swal.fire({
                              type: 'success',
                              title: res.message,
                              showConfirmButton: true,
                              onClose: () => {
                                    location.reload();
                                }
                            });

                        }
                        else
                        {

                            Swal.fire({
                              type: 'error',
                              title: res.message,
                              showConfirmButton: false,
                              timer: 2500
                            });
                        }


                    },
                    error: function(jqXHR,status, error){
                        $('#resultstatus').text(status+': '+error);
                         $(".deletingCap").hide();
                        $(this).hide();
                        console.log(status+': '+error);
                    }
                });


          }
        });
    });

    $(document).on('click', '.editNewsBanner', function(e){
        var newsDetails = $(this).attr('id');
        var newsDetailsArr = newsDetails.split('_');
        var newsId = newsDetailsArr[1];
        $('#postBannerId').val(newsId);
    });

    $('#changeNewsBanner').on('click', function(e){

        // var postDetailsId = $("#fileDetailsId").val();
        var postBannerId = $('#postBannerId').val();
        var error_message = "";
        var formData = new FormData();
        var files = $('#newsBannerInputFile')[0].files;

        if (!files || files.length == 0) {
            error_message += "<h4> Please select an image.</h4>";
            alertSweetHTML(error_message, 0);
            return;
        }

        var file = files[0];
        console.log(file);
        var name = file.name;
        var ext = name.split('.').pop().toLowerCase();

        if(jQuery.inArray(ext, ['jpg', 'jpeg', 'png']) == -1) {
            error_message += "<h4>Invalid File type on file. (Only image file is allowed) </h4>";
        }
        formData.append('file[]', file);

        formData.append('postId', postBannerId);
        formData.append('newsBanner', 'newsBanner');

        if (error_message != "") {
            alertSweetHTML(error_message, 0);
            return;
        }

        $.ajax({
            url: "./../adminmanager.php",
            type: "POST",
            data: formData,
            contentType:false,
            cache:false,
            processData: false,
            beforeSend: function(){
                $("#uploadingBannerImage").show();
                $("#newsBannerInputFile").prop("disabled", true);
            },

            success: function(res,textStatus,jqXHR)
            {
                // var result = JSON.stringify(res);
                console.log(res);
                var res = JSON.parse(res);
                $("#uploadingBannerImage").hide();
                $("#newsBannerInputFile").prop("disabled", false);
                 console.log(res);
                 console.log(res.status);
                if (res.status == '1') {
                    $('#newsBannerInputFile').val(null);
                    Swal.fire({
                      type: 'success',
                      title: res.message,
                      showConfirmButton: true,
                      onClose: () => {
                            location.reload();
                        }
                    });

                }
                else
                {

                    Swal.fire({
                      type: 'error',
                      title: res.message,
                      showConfirmButton: false,
                      timer: 2500
                    });
                }


            },
            error: function(jqXHR,status, error){
                $('#resultstatus').text(status+': '+error);
                 $("#uploadingFeat").hide();
                 $("#fileFeatInputFile").prop("disabled", false);
                console.log(status+': '+error);
            }
        });
    });

    $('#userprofile').on('submit', function(e){

        e.preventDefault();
        var postData = $(this).serializeArray();
        var formUrl = $(this).attr('action');
        // console.log(postData);
        // return;
        $("#createUserSubmit").prop("disabled", true);
        $("#loading").show();

        $.ajax({
            url: formUrl,
            type: "POST",
            data: postData,

            success: function(res,textStatus,jqXHR)
            {
                // var result = JSON.stringify(res);
                console.log(res);
                var res = JSON.parse(res);
                $("#loading").hide();
                $("#createUserSubmit").prop("disabled", false);
                 // console.log(res);
                 // console.log(res.status);
                if (res.status == '1') {
                    //alert(res.message);
                    Swal.fire({
                      type: 'success',
                      title: res.message,
                      showConfirmButton: true,
                      onClose: () => {
                            $(".formInput").val();
                            location.reload();
                        }
                    });

                }
                else
                {
                    Swal.fire({
                      type: 'error',
                      title: res.message,
                      showConfirmButton: false,
                      timer: 1500
                    });
                }


            },
            error: function(jqXHR,status, error){
                $('#resultstatus').text(status+': '+error);
                console.log(status+': '+error);
            }
        });
    });

    $('#userprofileupdate').on('submit', function(e){

        e.preventDefault();
        var postData = $(this).serializeArray();
        var formUrl = $(this).attr('action');
        // console.log(postData);
        // return;
        $("#updateUserSubmit").prop("disabled", true);
        $("#loading").show();

        $.ajax({
            url: formUrl,
            type: "POST",
            data: postData,

            success: function(res,textStatus,jqXHR)
            {
                // var result = JSON.stringify(res);
                console.log(res);
                var res = JSON.parse(res);
                $("#loading").hide();
                $("#updateUserSubmit").prop("disabled", false);
                 // console.log(res);
                 // console.log(res.status);
                if (res.status == '1') {
                    $('#editNewUserForm').hide();
                    $('#addNewUserForm').show();
                    Swal.fire({
                      type: 'success',
                      title: res.message,
                      showConfirmButton: true,
                      onClose: () => {
                            $(".formInput").val();
                            location.reload();
                        }
                    });

                }
                else
                {
                    Swal.fire({
                      type: 'error',
                      title: res.message,
                      showConfirmButton: false,
                      timer: 1500
                    });
                }


            },
            error: function(jqXHR,status, error){
                $('#resultstatus').text(status+': '+error);
                console.log(status+': '+error);
            }
        });
    });

    $('#cancleUserUpdate').on('click', function(e) {
        $('#editNewUserForm').hide();
        $('#addNewUserForm').show();

        $('#gotoToform').click();


    });

    $('.editUserBtn').on('click', function(e) {
        // body...
        var userDetails = $(this).attr('id');
        var userDetailArr = userDetails.split('_');

        var userId = userDetailArr[1];

        if (userId == 1) {
            Swal.fire({
              type: 'error',
              title: 'Super admin account cannot be edited',
              showConfirmButton: false,
              timer: 2500
            });
            return;
        }
        var formData = {
            user_id: userId,
            getuser: 1
        };

        $.ajax({
            url: "./../adminmanager.php",
            type: "POST",
            data: formData,
            success: function(res,textStatus,jqXHR)
            {
                // var result = JSON.stringify(res);
                // console.log(res);
                // return;

                var res = JSON.parse(res);

                if (res.status == '1') {
                    var user = res.user;
                    //console.log(user);

                    $('#setUserId').val(user.id);
                    $('#editUsername').val(user.username);
                    $('#editFirstname').val(user.firstname);
                    $('#editLastname').val(user.lastname);
                    $('#editEmail').val(user.email);
                    $('#editPassword').val('');
                    $('#editTel').val(user.tel);
                    $('#editDetail').text(user.detail);

                    //Do permissions...

                    $('#editFileUpload').val(user.file);
                    $('#editFileDownload').val(user.download);
                    $('#editCanCreateNews').val(user.news);


                    $('#editNewUserForm').show();
                    $('#addNewUserForm').hide();

                    $('#gotoToform').click();

                }
                else
                {

                    Swal.fire({
                      type: 'error',
                      title: res.message,
                      showConfirmButton: false,
                      timer: 2500
                    });
                }


            },
            error: function(jqXHR,status, error){

                console.log(status+': '+error);
            }
        });
    });

    $(document).on('click', '.deleteUserBtn', function(e){
        var usersDetails = $(this).attr('id');
        var usersDetailsArr = usersDetails.split('_');

        var userId = usersDetailsArr[1];

        if (userId == 1) {
            Swal.fire({
              type: 'error',
              title: 'Super admin account cannot be deleted!!',
              showConfirmButton: false,
              timer: 2500
            });
            return;
        }

        var formData = {
            user_id: userId,
            deleteuser: 1
        };

        Swal.fire({
          title: 'Are you sure?',
          text: "Do you really intend to delete this user profile?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, proceed!!'
        }).then((result) => {
          if (result.value) {

            $.ajax({
                    url: "./../adminmanager.php",
                    type: "POST",
                    data: formData,
                    beforeSend: function(){
                        $("#deletingUser_"+userId).show();
                        //$(this).hide();
                    },

                    success: function(res,textStatus,jqXHR)
                    {
                        // var result = JSON.stringify(res);
                        console.log(res);
                        var res = JSON.parse(res);
                        $("#deletingUser_"+userId).hide();
                        $(this).show();
                         console.log(res);
                         console.log(res.status);
                        if (res.status == '1') {

                            Swal.fire({
                              type: 'success',
                              title: res.message,
                              showConfirmButton: true,
                              onClose: () => {
                                    location.reload();
                                }
                            });

                        }
                        else
                        {

                            Swal.fire({
                              type: 'error',
                              title: res.message,
                              showConfirmButton: false,
                              timer: 2500
                            });
                        }


                    },
                    error: function(jqXHR,status, error){
                        $('#resultstatus').text(status+': '+error);
                         $(".deletingCap").hide();
                        $(this).hide();
                        console.log(status+': '+error);
                    }
                });


          }
        });
    });

    $(document).on('click', '.deleteUploadFileBtn', function(e){
        var fileDetails = $(this).attr('id');
    
        var fileDetailsArr = fileDetails.split('_');
        var fileId = fileDetailsArr[1];

        var formData = {
            file_id: fileId,
            deletefile: 1
        };

        Swal.fire({
          title: 'Are you sure?',
          text: "Do you really intend to delete this file?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, proceed!!'
        }).then((result) => {
          if (result.value) {

            $.ajax({
                    url: "./../adminmanager.php",
                    type: "POST",
                    data: formData,
                    beforeSend: function(){
                        $("#deletingUploadedFile_"+fileId).show();
                        //$(this).hide();
                    },

                    success: function(res,textStatus,jqXHR)
                    {
                        // var result = JSON.stringify(res);
                        console.log(res);
                        var res = JSON.parse(res);
                        $("#deletingUploadedFile_"+fileId).hide();
                        $(this).show();
                         console.log(res);
                         console.log(res.status);
                        if (res.status == '1') {

                            Swal.fire({
                              type: 'success',
                              title: res.message,
                              showConfirmButton: true,
                              onClose: () => {
                                    location.reload();
                                }
                            });

                        }
                        else
                        {

                            Swal.fire({
                              type: 'error',
                              title: res.message,
                              showConfirmButton: false,
                              timer: 2500
                            });
                        }


                    },
                    error: function(jqXHR,status, error){
                        $('#resultstatus').text(status+': '+error);
                         $(".deletingCap").hide();
                        $(this).hide();
                        console.log(status+': '+error);
                    }
                });


          }
        });
    });



    $('.logout').on('click', function(e){
        e.preventDefault();
        Swal.fire({
          title: 'Are you sure?',
          text: "Please confirm your logout action",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Logout'
        }).then((result) => {
            if (result.value) {
                localStorage.clear();
                window.location.replace("./../index.html");
            }
        })
    });

});

function alertSweet(msg, status){
    var alertType =  (status == 0? 'error' : 'success');
    Swal.fire({
          type: alertType,
          title: msg,
          showConfirmButton: true
        });
}

function alertSweetHTML(html, status){
    var alertType =  (status == 0? 'error' : 'success');
    Swal.fire({
          type: alertType,
          html: html,
          showConfirmButton: true
        });
}

function alertSweetConfirm(){
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        Swal.fire(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        )
      }
    });
}
