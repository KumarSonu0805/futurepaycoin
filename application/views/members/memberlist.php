
<style>
    .wallet_address{
        font-size: 12px;
    }
</style>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div id="status"></div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-12">   
                                <?php /*?><div id="tabulator-table"></div><?php */?>
                                <div class="table-responsive">
                                    <table class="table table-condensed" id="table">
                                        <thead>
                                            <tr>
                                                <th>Sl.No.</th>
                                                <th>Member ID</th>
                                                <th>Member Name</th>
                                                <th>Sponsor ID</th>
                                                <th>Sponsor Name</th>
                                                <th>Joining Date</th>
                                                <?php if($this->session->role=='admin'){ ?>
                                                <th>Mobile</th>
                                                <th>Amount</th>
                                                <th>Password</th>
                                                <?php }elseif($type=='downline'){ ?>
                                                <th class="select-filter">Level</th>
                                                <?php } ?>
                                                <th>Wallet Address</th>
                                                <th>Status</th>
                                                <?php if($this->session->role=='admin'){ ?>
                                                <th>Action</th>
                                                <?php
                                                    }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($members)){
                                                    $i=0;
                                                    foreach($members as $single){
                                                        $status='<span class="text-danger">In-Active</span>';
                                                        if($single['status']==1){
                                                            $status='<span class="text-success">Active</span>';
                                                        }
                                            ?>
                                            <tr>
                                                <td><?= ++$i; ?></td>
                                                <td><?= $single['username'] ?></td>
                                                <td><?= $single['name'] ?></td>
                                                <td><?= $single['sponsor_id'] ?></td>
                                                <td><?= $single['sponsor_name'] ?></td>
                                                <td><?= date('d-m-Y',strtotime($single['date'])) ?></td>
                                                <?php if($this->session->role=='admin'){ ?>
                                                <td><?= $single['mobile'] ?></td>
                                                <td><?= $single['package'] ?></td>
                                                <td><?= $single['password'] ?></td>
                                                <?php }elseif($type=='downline'){ ?>
                                                <td><?= $single['level']; ?></td>
                                                <?php } ?>
                                                <td>
                                                    <?php if($this->session->role=='admin'){ ?>
                                                    <span><?= $single['wallet_address'] ?> <button type="button" class="btn p-0 edit-wallet"><i class="fa fa-edit"></i></button></span>
                                                    <?php
                                                        if($this->session->role=='admin'){
                                                            echo form_open('members/updatewallet','class="d-none"');
                                                            echo create_form_input('text','wallet_address','',true,$single['wallet_address'],['class'=>'wallet_address','data-value'=>$single['wallet_address']]);
                                                            echo create_form_input('hidden','regid','',true,md5('regid-'.$single['regid']));
                                                    ?>
                                                    <button type="submit" class="btn btn-sm btn-success" name="updatewallet"><i class="fa fa-check"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger cancel-edit"><i class="fa fa-times"></i></button>
                                                    <?php
                                                            echo form_close();
                                                        }
                                                    ?>
                                                    <?php }else{ echo $single['wallet_address']; } ?>
                                                </td>
                                                <td><?= $status; ?></td>
                                                <?php if($this->session->role=='admin'){ ?>
                                                <td>
                                                    
                                                    <?php
                                                    if($single['status']==0){
                                                    ?>
                                                    <button type="button" value="<?= md5('regid-'.$single['regid']) ?>" class="btn btn-sm btn-success activate">Activate</button>
                                                    <button type="button" value="<?= md5('regid-'.$single['regid']) ?>" class="btn btn-sm btn-success activate top-up mt-1">Top-Up ID</button>
                                                    <?php
                                                    }
                                                    if($single['status']==1 && $single['booster']==0){
                                                    ?>
                                                    <button type="button" value="<?= md5('regid-'.$single['regid']) ?>" class="btn btn-sm btn-success activate-booster">Activate Booster</button>
                                                    <?php
                                                    }
                                                    if($single['status']==1){
                                                    ?>
                                                    <form action="<?= base_url('members/updateincomestatus/') ?>" method="post" onSubmit="return validate('<?= $single['user_status']==0?'Un-Block':'Block' ?>')">
                                                        <input type="hidden" name="regid" value="<?= $single['regid']; ?>">
                                                        <?php if($single['user_status']==0){ ?>
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit" class="btn btn-sm btn-success mt-1" name="changememberstatus" value="Un-block">Un-block Member</button>
                                                        <?php }elseif($single['user_status']==1){ ?>
                                                        <input type="hidden" name="status" value="0">
                                                        <button type="submit" class="btn btn-sm btn-danger mt-1" name="changememberstatus" value="Un-block">Block Member</button>
                                                        <?php } ?>
                                                    </form>
                                                    <form action="<?= base_url('members/updateincomestatus/') ?>" method="post" onSubmit="return validate('<?= $single['income']==0?'Restart':'Stop' ?>')">
                                                        <input type="hidden" name="regid" value="<?= $single['regid']; ?>">
                                                        <?php if($single['income']==0){ ?>
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit" class="btn btn-sm btn-success mt-1" name="updateincomestatus" value="Un-block">Restart Income</button>
                                                        <?php }elseif($single['income']==1){ ?>
                                                        <input type="hidden" name="status" value="0">
                                                        <button type="submit" class="btn btn-sm btn-danger mt-1" name="updateincomestatus" value="Un-block">Stop Income</button>
                                                        <?php } ?>
                                                    </form>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                    }
                                                ?>
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
    <script>
	
		$(document).ready(function(e) {
            //$('#table').dataTable();
            createDatatable();
            
            $('body').on('click','.activate',function(){
                var id=$(this).val();
                var amount=prompt("Enter Package Amount (Min $50)");
                amount=Number(amount);
                amount=isNaN(amount)?0:amount;
                if(amount>=50){
                   var topup=$(this).hasClass('top-up')?1:0;
                   $.post('<?= base_url('members/adminactivate') ?>',{id:id,amount:amount,topup:topup},function(){
                       window.location.reload();
                   });
                }
                else{
                    alert("Enter amount greater than 50!")
                }
            });
            
            $('body').on('click','.edit-wallet',function(){
                var $col=$(this).closest('td');
                $col.find('span').addClass('d-none');
                $col.find('form').removeClass('d-none');
            });
            
            $('body').on('click','.cancel-edit',function(){
                var $col=$(this).closest('td');
                $col.find('span').removeClass('d-none');
                $col.find('form').addClass('d-none');
                $col.find('.wallet_address').val($col.find('.wallet_address').attr('data-value'));
            });
            
            $('body').on('click','.activate-booster',function(){
                var id=$(this).val();
                if(confirm("Activate Booster?")){
                   $.post('<?= base_url('members/adminactivatebooster') ?>',{id:id},function(){
                       window.location.reload();
                   });
                }
            });

        });
		
        function createDatatable(){
            $('#status').html('');
            let table=$('#table').DataTable();
            table.columns('.select-filter').every(function(){
                var that = this;
                var pos=$('#status');
                // Create the select list and search operation
                var select = $('<select class="form-control" />').appendTo(pos).on('change',function(){
                                that.search("^" + $(this).val() + "$", true, false, true).draw();
                            });
                    select.append('<option value=".+">All</option>');
                // Get the search data for the first column and add to the select list
                this.cache( 'search' ).unique().each(function(d){
                        select.append($('<option value="'+d+'">'+d+'</option>') );
                });
            });
        }
        function validate(text){
            var message='';
            if(text=='Restart' || text=='Stop'){
               message="Confirm "+text+" Income of this Member?";
            }
            if(text=='Un-Block' || text=='Block'){
               message="Confirm "+text+" this Member?";
            }
            if(!confirm(message)){
                return false;
            }
        }
	</script>
    
    	
