<!DOCTYPE html>
<html lang="en">

<head>
    <title>Singup Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>


    <div class="container mt-5 ">
        <h1 class="mb-3">Singup Form</h1>
        <div class="row">
            <div class="col-md-7">
                <form enctype="multipart/form-data" id="submit">
                    <div class="form-group ">
                        <label for="fullname">Full Name</label>
                        <input type="text" class="form-control" id="fullname" placeholder="Enter Full Name">
                        <span class="text-danger" id="name_error"></span>
                    </div>
                    <div class="form-group ">
                        <label for="Mobile">Mobile</label>
                        <input type="text" class="form-control" id="mobilenum" placeholder="Enter Mobile Number">
                        <span class="text-danger" id="mobile_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="Emailid">Email Id</label>
                        <input type="text" class="form-control" id="email" placeholder="Enter Email Id">
                        <span class="text-danger" id="email_error"></span>
                    </div>
                    <div class="form-group ">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter Password">
                        <span class="text-danger" id="password_error"></span>
                    </div>
                    <div class="form-group ">
                        <label for="comformpassword">Conform Password</label>
                        <input type="password" class="form-control" id="comformpassword"
                            placeholder="Re-Enter Password">
                        <span class="text-danger" id="comformpassword_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="file">Upload Multiple Files</label>
                        <input type="file" class="form-control" name="files" id="files" multiple
                            accept="image/png,image/jpg,image/jpeg">
                        <span class="text-danger" id="file_error"></span>
                    </div>
                    <button type="submit" id="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div>
            <div class="col-md-5">
                <div class="container" id="cha-tab">

                </div>
            </div>
        </div>

    </div>


    <script type="text/javascript">
    $(document).ready(function() {
        // Show to Get Data 

        function getdata() {
            $.ajax({
                type: 'ajax',
                url: "<?php  echo base_url('index.php/Welcome/GetData');?>",
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = "";
                    var num = 1;
                    for (var index = 0; index < data.length; index++) {
                        html += '<div class="row">';
                        html += '<div class="col">';
                        html += '' + num + ' User Name:-' + data[index]['Name'] + '<br> Email:- ' +
                            data[index]['Email'] + ' ';
                        html += '<br>Password :- ' + data[index]['Password'] + '<br>Mobile :- ' + data[
                            index]['Mobile'] + '<br> ';
                        for (var j = 0; j < data[index]['File'].length; j++) {
                            var src = '<?php echo base_url('uploads/')?>' + data[index]['File'][j];
                            html += '<img src="' + src + '" style="height:100px;width:100px;" />';
                        }
                        html += '<hr></div>';
                        html += '</div>';
                        num++;
                    }
                    $('#cha-tab').html(html);
                }

            });
        }
        getdata();
        //  Data Add End Check Valid

        $("#name_error").hide();
        $("#mobile_error").hide();
        $("#email_error").hide();
        $("#password_error").hide();
        $("#comformpassword_error").hide();

        var form_data = new FormData();
        error_fname = true;
        error_num = true;
        error_email = true;
        error_password = true;
        error_retype_password = true;
        error_images = false;
        //  coll the name valid function
        $("#fullname").focusout(function() {
            check_fname();
        });
        //  name function
        function check_fname() {
            var pattern = /^[a-z ]*$/;
            var fname = $("#fullname").val();
            if (pattern.test(fname) && fname !== '') {
                $("#name_error").hide();
                $("#fullname").css("border-bottom", "2px solid #34F458");
            } else {
                $("#name_error").html("Should contain only Characters");
                $("#name_error").show();
                $("#fullname").css("border-bottom", "2px solid #F90A0A");
                error_fname = false;
            }
        }
        //  coll the mobile valid function
        $("#mobilenum").focusout(function() {
            check_mobile();
        });
        //  mobile function
        function check_mobile() {
            var pattern =
                /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
            var mobile = $("#mobilenum").val();
            if (pattern.test(mobile) && mobile !== '' && mobile.length == 10) {
                $("#mobile_error").hide();
                $("#mobilenum").css("border-bottom", "2px solid #34F458");
            } else {
                $("#mobile_error").html("Should only 10 Numbers ");
                $("#mobile_error").show();
                $("#mobilenum").css("border-bottom", "2px solid #F90A0A");
                error_num = false;
            }
        }
        //  coll the email valid function
        $("#email").focusout(function() {
            check_email();
        });
        //  email valid functon
        function check_email() {
            var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var email = $("#email").val();
            if (pattern.test(email) && email !== '') {
                $("#email_error").hide();
                $("#email").css("border-bottom", "2px solid #34F458");
            } else {
                $("#email_error").html("Invalid Email");
                $("#email_error").show();
                $("#email").css("border-bottom", "2px solid #F90A0A");
                error_email = false;
            }
        }

        //  coll the password valid function
        $("#password").focusout(function() {
            check_password();
        });
        //  password valid function
        function check_password() {
            var password_length = $("#password").val().length;
            if (password_length < 8) {
                $("#password_error").html("Atleast 8 Characters");
                $("#password_error").show();
                $("#password").css("border-bottom", "2px solid #F90A0A");
                error_password = false;
            } else {
                $("#password_error").hide();
                $("#password").css("border-bottom", "2px solid #34F458");
            }
        }
        //   re-enter password
        $("#comformpassword").focusout(function() {
            check_retype_password();
        });
        //function re-enter password
        function check_retype_password() {
            var password = $("#password").val();
            var retype_password = $("#comformpassword").val();
            if (password !== retype_password) {
                $("#comformpassword_error").html("Passwords Did not Matched");
                $("#comformpassword_error").show();
                $("#comformpassword").css("border-bottom", "2px solid #F90A0A");
                error_retype_password = false;
            } else {
                $("#comformpassword_error").hide();
                $("#comformpassword").css("border-bottom", "2px solid #34F458");

            }
        }
        //   re-enter password
        var files = null;
        $('#files').change(function() {
            files = $('#files')[0].files;
            var error = '';
            for (var count = 0; count < files.length; count++) {
                var name = files[count].name;
                var extension = name.split('.').pop().toLowerCase();
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    error += "Invalid " + count + " Image File"
                } else {
                    form_data.append("files[]", files[count]);
                }
            }
            if (files.length <= 0) {
                error_images = false;
                $("#file_error").html("Please Select Images");
                $("#file_error").show();
                $("#files").css("border-bottom", "2px solid #F90A0A");
            } else {
                $("#file_error").hide();
                error_images = true;
                $("#files").css("border-bottom", "2px solid #34F458");
            }

        });

        //  check form filed than submit data 
        $('#submit').submit(function(e) {
            e.preventDefault();
            error_fname = true;
            error_num = true;
            error_email = true;
            error_password = true;
            error_retype_password = true;
            error_images = true;
            // data add
            check_fname();
            check_mobile();
            check_email();
            check_password();
            check_retype_password();

            if (error_fname === true && error_num === true && error_email === true && error_password ===
                true && error_retype_password === true && files.length !== null) {

                //   SEND DATA USING AJAX
                form_data.append("password", $('#password').val());
                form_data.append("email", $('#email').val());
                form_data.append("mobilenum", $('#mobilenum').val());
                form_data.append("fullname", $('#fullname').val());
                $.ajax({
                    url: "<?php echo base_url();?>index.php/Welcome/savedata",
                    type: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(res) {
                        if (res == 1) {
                           $('#fullname').val(null);
                           $('#mobilenum').val(null);
                           $('#email').val(null);
                           $('#password').val(null);
                           $('#comformpassword').val(null);
                            alert('Data Add');
                            getdata();
                        } else {
                            alert('Data Not Add');
                        }
                    }
                });
            } else {
                alert("Please Fill the form Correctly And Check The File ");
            }
        });


    });
    </script>
</body>

</html>