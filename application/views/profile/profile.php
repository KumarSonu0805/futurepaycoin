 
<style>
    .btn{}
    .change-photo{
        position: absolute;
        border: 0;
        top: 15px;
        margin-left: -12px;
        background: #e9e9e9;
        padding: 1px 6px;
        font-size: 18px;
        border-radius: 50%;
        color: #1979ad;
    }
    .img-circle{
        border-radius: 50%;
        height: 150px;
        width: 150px;
    }
    .address{
        margin-top: 15px;
        padding: 10px;
        background-color: #4ca229;
        border: 1px solid #80d13c;
        border-radius: 5px;
        font-size: 1rem;
        text-align: center;
        color: #ffffff;
    }
    .list-group{
        border: 0;
    }
    .list-group-item{
        border-radius: 0 !important;
    }
    .list-group-item b{
        font-weight: 400;
        font-size: 15px;
        width: 30%;
        display: block;
        float: left;
    }
    .list-group-item a{
        text-decoration: none;
        color: #000;
        font-size: 16px;
    }
    .list-group.no-border .list-group-item{
        border: 0;
    }
</style>

            <div class="main-deshboard-section">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle bg-success" src="<?php if($user['photo']!=''){echo $user['photo'];}else{echo file_url('assets/images/avatar.webp');} ?>" alt="<?= $user['name']; ?> photo" id="view_photo"><br>
                                        <button type="button" class="change-photo" 
                                                onClick="$('#photoform').show();$('#photo').click();"><i class="fa fa-camera"></i></button>

                                        <?php echo form_open_multipart('profile/updatephoto', 'id="photoform" style="display:none;"'); ?>
                                            <input type="hidden" name="name" value="<?= $member['name']; ?>">
                                            <input type="file" name="photo" id="photo" onChange="getPhoto(this)" required class="d-none"/><br>
                                            <?php
                                                $input=array("type"=>"hidden","name"=>"name","value"=>$user['name']);
                                                echo form_input($input);
                                                $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                                echo form_input($input);
                                            ?>
                                            <button type="submit" class="btn btn-sm btn-success" name="updatephoto" value="Update">Update</button>
                                            <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                        <?php echo form_close(); ?>
                                    </div>

                                    <h5 class="profile-username text-center"><?= $user['username']; ?></h5>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Name </b> <a class="float-right"><?= $user['name']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Mobile </b> <a class="float-right"><?= $user['mobile']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Email </b> <a class="float-right"><?= $user['email']; ?></a>
                                        </li>
                                    </ul>

                                    <button type="button" onClick="$('#form-div').removeClass('d-none');" class="btn btn-primary btn-sm">Edit Profile</button>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 d-none" id="form-div">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">Update Profile</h3>
                                    <?= form_open('profile/updateprofile'); ?>
                                    <ul class="list-group list-group-unbordered mb-3 no-border">
                                        <li class="list-group-item">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?= $user['name']; ?>">
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="form-group">
                                                <label for="mobile">Mobile</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile" value="<?= $user['mobile']; ?>">
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?= $user['email']; ?>">
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" name="updateprofile" class="btn btn-success btn-sm">Update Profile</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" onclick="window.location.reload();" class="btn btn-danger btn-sm">Cancel</button>
                                        </div>
                                    </div>
                                    
                                    <?= form_close(); ?>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">Linked Wallet Address</h3>
                                    <p class="address"><?= $member['wallet_address']; ?></p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
                <script>

                    function getPhoto(input){
                        $('#view_photo').replaceWith('<img class="profile-user-img img-fluid img-circle bg-success" src="<?php if($user['photo']!=''){echo $user['photo'];}else{echo file_url('assets/images/avatar.jpg');} ?>" alt="<?= $user['name']; ?> photo" id="view_photo">');
                        if (input.files && input.files[0]) {
                            var filename=input.files[0].name;
                            var re = /(?:\.([^.]+))?$/;
                            var ext = re.exec(filename)[1]; 
                            ext=ext.toLowerCase();
                            if(ext=='jpg' || ext=='jpeg' || ext=='png'){
                                var size=input.files[0].size;
                                if(size<=2048000 && size>=20480){
                                    var reader = new FileReader();

                                    reader.onload = function (e) {
                                        $('#view_photo').attr('src',e.target.result);
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                                else if(size>=2048000){
                                    document.getElementById('photo').value= null;
                                    alert("Image size is greater than 2MB");	
                                    $('#photoform').hide();
                                    //$('.change-photo').show();
                                }
                            }
                            else{
                                document.getElementById('photo').value= null;
                                alert("Select 'jpeg' or 'jpg' or 'png' image file!!");	
                                $('#photoform').hide();
                                //$('.change-photo').show();
                            }
                        }
                        else{
                            $('#photoform').hide();
                            //$('.change-photo').show();
                        }
                    }

                </script>