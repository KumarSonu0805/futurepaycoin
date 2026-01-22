
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"><?= $title; ?></h4>
									
								</div>
								<div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?= form_open_multipart('settings/savereward/'); ?>
                                                <div class="form-group row my-2">
                                                    <label class="col-sm-2 col-form-label">Type</label>
                                                    <div class="col-sm-10">
                                                        <select name="type" id="type" class="form-control" required>
                                                            <option value="Amount">Amount</option>
                                                            <option value="Reward">Reward</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label class="col-sm-2 col-form-label" id="value-id">Value</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" name="value" id="value" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-10">
                                                        <input type="hidden" name="id" id="id">
                                                        <input type="submit" id="savebtn" class="btn btn-success waves-effect waves-light" name="savereward" value="Save Spin Reward">
                                                        <button type="button" class="btn btn-danger waves-effect waves-light cancel-btn d-none">Cancel</button>
                                                    </div>
                                                </div>
                                            <?= form_close(); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-condensed" id="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No.</th>
                                                            <th>Type</th>
                                                            <th>Value</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if(!empty($rewards)){ $i=0;
                                                            foreach($rewards as $single){
                                                                $i++;
                                                                $value=$single['value'];
                                                                if($single['type']=='Amount'){
                                                                    $value='$'.$value;
                                                                }
                                                        ?>
                                                        <tr>
                                                            <td><?= $i; ?></td>
                                                            <td><?= $single['type']; ?></td>
                                                            <td><?= $value; ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-primary edit-btn" value="<?= md5('reward-'.$single['id']); ?>"><i class="fa fa-edit"></i></button>
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
                                    </div>
								</div>
							</div>
						</div>
					</div>
            <script>
                $(document).ready(function(){
                    $('body').on('change','#type',function(){
                        var type=$(this).val();
                        if(type=='Amount'){
                           $('#value').attr('type','number');
                        }
                        else{
                           $('#value').attr('type','text');
                        }
                    });
                    $('body').on('click','.cancel-btn',function(){
                        $('#savebtn').val('Save Reward');
                        $('#value').val('');
                        $('#savebtn').attr('name','savereward');
                        $('.cancel-btn').toggleClass('d-none');
                    });
                    $('table').on('click','.edit-btn',function(){
                        var id = $(this).val();
                        $.ajax({
                            type:"post",
                            url:"<?= base_url('settings/getreward'); ?>",
                            data:{id:id},
                            success:function(data){
                                if(data!='null' && data!='[]'){
                                    data=JSON.parse(data);
                                    $('#id').val(data['id']);
                                    $('#type').val(data['type']).trigger('change');
                                    $('#value').val(data['value']);
                                    $('#savebtn').val('Update Reward');
                                    $('#savebtn').attr('name','updatereward');
                                    $('.cancel-btn').toggleClass('d-none');
                                }
                            }
                        });
                    });
                });
            </script>