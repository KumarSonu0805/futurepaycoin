
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"><?= $title; ?></h4>
									
								</div>
								<div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-condensed" id="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No.</th>
                                                            <th>Name</th>
                                                            <th>Value</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if(!empty($settings)){ $i=0;
                                                            foreach($settings as $single){
                                                                $i++;
                                                                $value=$single['value'];
                                                                if($single['type']=='Time'){
                                                                    $value=date('h:i A',strtotime($value));;
                                                                }
                                                                elseif($single['name']=='admin_address'){
                                                                    $value=$value;
                                                                }
                                                                elseif($single['name']=='qrcode' && $value!=''){
                                                                    $value='<img src="'.file_url($value).'" alt="" height="80">';
                                                                }
                                                                else{
                                                                    $value.=" ".$single['type'];
                                                                }
                                                        ?>
                                                        <tr>
                                                            <td><?= $i; ?></td>
                                                            <td><?= $single['title']; ?></td>
                                                            <td><?= $value; ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-primary edit-btn" value="<?= md5('setting-'.$single['id']); ?>"><i class="fa fa-edit"></i></button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <?= form_open_multipart('settings/updatesetting/'); ?>
                                                <div class="form-group row my-2">
                                                    <label class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="title" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label class="col-sm-2 col-form-label" id="value-id">Value</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="value" id="value" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-10">
                                                        <input type="hidden" name="id" id="id">
                                                        <input type="submit" class="btn btn-success waves-effect waves-light" name="updatesetting" value="Update Settings">
                                                        <button type="button" class="btn btn-danger waves-effect waves-light cancel-btn hidden">Cancel</button>
                                                    </div>
                                                </div>
                                            <?= form_close(); ?>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
            <script>
                $(document).ready(function(){
                    $('table').on('click','.edit-btn',function(){
                        var id = $(this).val();
                        $('#value').removeAttr('maxlength');
                        var input='<input type="text" class="form-control" name="value" id="value" required>';
                        $('#value').replaceWith(input);
                        $.ajax({
                            type:"post",
                            url:"<?= base_url('settings/getsetting'); ?>",
                            data:{id:id},
                            success:function(data){
                                if(data!='null' && data!='[]'){
                                    data=JSON.parse(data);
                                    $('#id').val(data['id']);
                                    $('#title').val(data['title']);
                                    $('#value').val(data['value']);
                                    if(data['type']!='Text'){
                                        $('#value-id').text('Value ('+data['type']+')');
                                    }
                                }
                            }
                        });
                    });
                });
            </script>