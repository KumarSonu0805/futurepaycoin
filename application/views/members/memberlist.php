
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
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
                                                <th>Password</th>
                                                <?php
                                                    }
                                                ?>
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
                                                <td><?= $single['password'] ?></td>
                                                <?php
                                                    }
                                                ?>
                                                <td><?= $single['wallet_address'] ?></td>
                                                <td><?= $status; ?></td>
                                                <?php if($this->session->role=='admin'){ ?>
                                                <td>
                                                    <?php
                                                    if($single['status']==0){
                                                    ?>
                                                    <button type="button" value="<?= md5('regid-'.$single['regid']) ?>" class="btn btn-sm btn-success activate">Activate</button>
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
                                                        <button type="submit" class="btn btn-xs btn-success mt-1" name="changememberstatus" value="Un-block">Un-block Member</button>
                                                        <?php }elseif($single['user_status']==1){ ?>
                                                        <input type="hidden" name="status" value="0">
                                                        <button type="submit" class="btn btn-xs btn-danger mt-1" name="changememberstatus" value="Un-block">Block Member</button>
                                                        <?php } ?>
                                                    </form>
                                                    <form action="<?= base_url('members/updateincomestatus/') ?>" method="post" onSubmit="return validate('<?= $single['income']==0?'Restart':'Stop' ?>')">
                                                        <input type="hidden" name="regid" value="<?= $single['regid']; ?>">
                                                        <?php if($single['income']==0){ ?>
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit" class="btn btn-xs btn-success mt-1" name="updateincomestatus" value="Un-block">Restart Income</button>
                                                        <?php }elseif($single['income']==1){ ?>
                                                        <input type="hidden" name="status" value="0">
                                                        <button type="submit" class="btn btn-xs btn-danger mt-1" name="updateincomestatus" value="Un-block">Stop Income</button>
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
            $('#table').dataTable();
            
            var url="<?= base_url('members/getmembers/?type='.$type); ?>";
            var columns=[
                    { 
                        title: "Sl.No.", 
                        field: "serial", 
                        type: "auto"
                    },
                    { title: "Member ID", field: "username" },
                    { title: "Member Name", field: "name" },
                    { title: "Sponsor ID", field: "sponsor_id" },
                    { title: "Sponsor Name", field: "sponsor_name" },
                    { 
                        title: "Joining Date", 
                        field: "date",
                        formatter: function(cell){
                            let dateStr = cell.getValue(); // Y-m-d format
                            let formattedDate = dateStr.split("-").reverse().join("-");
                            return formattedDate;
                        }
                    },
                    <?php if($this->session->role=='admin'){ ?>
                    { title: "Mobile", field: "mobile" },
                    { title: "Email", field: "email" },
                    { title: "Amount", field: "package" },
                    { title: "Wallet Address", field: "wallet_address" },
                    <?php }else{ ?>
                    { title: "Wallet Address", field: "wallet_address", width:450 },
                    <?php } ?>
                ];

            var pagination={
                sizes:[10, 20, 50, 100]
            }

            //var table=createTabulator('tabulator-table',url,columns,pagination);

            function refreshTableData() {
                table.replaceData(url);
            }
            $('body').on('keyup','#searchInput',function(){
                let value = $(this).val().toLowerCase();
                console.log(value);
                table.setFilter(function(data) {
                    return Object.values(data).some(field => 
                        field !== null && field !== undefined && field.toString().toLowerCase().includes(value)
                    );
                });
            });

            $('body').on('click','#clearSearch',function(){
                document.getElementById("searchInput").value = "";
                table.clearFilter();
            });

            $('body').on('click','.activate',function(){
                var id=$(this).val();
                var amount=prompt("Enter Package Amount (Min $50)");
                amount=Number(amount);
                amount=isNaN(amount)?0:amount;
                if(amount>=50){
                   $.post('<?= base_url('members/adminactivate') ?>',{id:id,amount:amount},function(){
                       window.location.reload();
                   });
                }
                else{
                    alert("Enter amount greater than 50!")
                }
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
    
    	
