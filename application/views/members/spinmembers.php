
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
                                                <th>Reward</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($members)){
                                                    $i=0;
                                                    foreach($members as $single){
                                                        $reward='--';
                                                        $status='';
                                                        if($single['type']==''){
                                                            $status='<span class="text-danger">Reward not Set</span>';
                                                        }
                                                        elseif($single['spin_status']==0){
                                                            $status='<span class="text-warning">Spin Wheel Pending</span>';
                                                        }
                                                        elseif($single['spin_status']==1){
                                                            $status='<span class="text-success">Spin Wheel Done</span>';
                                                        }
                                                        if($single['type']!='' && $single['reward']!=''){
                                                            $type=$single['type'];
                                                            $reward=$single['reward'];
                                                            if($type=='Amount'){
                                                                $reward='$'.$reward;
                                                            }
                                                        }
                                            ?>
                                            <tr>
                                                <td><?= ++$i; ?></td>
                                                <td><?= $single['username'] ?></td>
                                                <td><?= $single['name'] ?></td>
                                                <td><?= $reward; ?></td>
                                                <td><?= $status; ?></td>
                                                <td>
                                                    <?php
                                                        if($single['spin_status']===NULL){
                                                    ?>
                                                    <button type="button" class="btn btn-sm btn-success set-reward" data-bs-toggle="modal" data-bs-target="#spinModal" data-username="<?= $single['username']; ?>" data-name="<?= $single['name']; ?>" data-regid="<?= md5('regid-'.$single['regid']); ?>">Set Reward</button>
                                                    <?php
                                                        }
                                                    ?>
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
<div class="modal fade text-dark" id="spinModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">

      <div class="modal-header border-0">
        <h5 class="modal-title">Set Reward</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <div class="row">
            <div class="col-md-12">
                <?= form_open_multipart('members/savememberreward/'); ?>
                    <div class="form-group row my-2">
                        <label class="col-sm-2 col-form-label">Member ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="" id="username" readonly>
                        </div>
                    </div>
                    <div class="form-group row my-2">
                        <label class="col-sm-2 col-form-label">Member Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="" id="name" readonly>
                        </div>
                    </div>
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
                            <select name="reward" id="reward" class="form-control" required>
                                <option value="">Select</option>
                                <?php
                                if(!empty($rewards)){
                                    foreach($rewards as $reward){
                                ?>
                                <option value="<?= $reward['value'] ?>" class="to-hide <?= $reward['type'] ?>"><?= ($reward['type']=='Amount'?'$':'').$reward['value'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row my-2">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <input type="hidden" name="regid" id="regid">
                            <input type="submit" id="savebtn" class="btn btn-success waves-effect waves-light" name="savememberreward" value="Save Member Reward">
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
	
		$(document).ready(function(e) {
            //$('#table').dataTable();
            createDatatable();
            
            
            $('body').on('click','.set-reward',function(){
                $('#username').val($(this).data('username'));
                $('#name').val($(this).data('name'));
                $('#regid').val($(this).data('regid'));
                $('#type').trigger('change');
            });

            $('body').on('change','#type',function(){
                var type=$(this).val();
                $('.to-hide').hide();
                $('.'+type).show();
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
    
    	
