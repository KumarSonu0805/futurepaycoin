<?php
$member['wallet_address']=empty($member['wallet_address'])?'':$member['wallet_address'];
?>
<style>
    
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
</style>
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><?= $title; ?></div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-5">
                                <div class="card card-outline">
                                    <div class="card-body box-profile">
                                        <div class="row mb-2">
                                            <div class="col-12 text-center">
                                                <div id="wallet-address" class="address"><?= $member['wallet_address']; ?></div>
                                            </div>
                                        </div>
                                <?php 
									if(isset($member['wallet_address']) && $member['wallet_address']!=''){
                                        echo form_open_multipart('wallet/requestwithdrawal/', 'id="myform" onSubmit="return validate()"'); 
                                ?>
                                    <div class="form-group d-none">
                                        <?php
                                            echo create_form_input("date","date","Date",true,date('Y-m-d')); 
                                        ?>
                                    </div>
                                    <div class="form-group my-2">
                                        <?php
                                            echo create_form_input("text","","Member ID",false,$user['username'],array("readonly"=>"true")); 
                                        ?>
                                    </div>
                                    <div class="form-group my-2">
                                        <?php
                                            echo create_form_input("text","","Name",false,$user['name'],array("readonly"=>"true")); 
                                        ?>
                                    </div>
                                    <div class="form-group my-2">
                                        <?php
                                            echo create_form_input("text","","Wallet Balance ($)",false,$avl_balance,array("id"=>"usdt_balance","readonly"=>"true")); 
                                        ?>
                                    </div>
                                    <div class="form-group my-2 " >
                                        $1 = <span id="price"></span> FPC
                                    </div>
                                    <div class="form-group my-2">
                                        <?php
                                            echo create_form_input("text","","Wallet Balance (FPC)",false,0,array("id"=>"avl_balance","readonly"=>"true")); 
                                        ?>
                                    </div>
                                    <div class="form-group my-2">
                                        <?php
                                            echo create_form_input('text','amount','Withdrawal Amount',true,'',array("id"=>"amount","Placeholder"=>"Withdrawal Amount","autocomplete"=>"off","min"=>MIN_WITHDRAW));
                                        ?><p class="text-danger"></p>
                                    </div>
                                    <?php
                                        echo create_form_input("hidden","rate","",false,'',array('id'=>'rate')); 
                                        echo create_form_input("hidden","regid","",false,$user['id']); 
                                    ?>
                                    <small class="text-danger">*Note: Minimun withdrawal amount is <span id="min_withdraw"></span> FPC!</small><br>
                                    <small class="text-danger">*Note: <?= DEDUCTION ?>% will be deducted from the withdrawal amount!</small><br>
                                    <button type="submit" class="btn btn-sm btn-success" name="requestwithdrawal" value="Request">Request Withdrawal</button>
                                <?php 
                                        echo form_close(); 
                                    }
                                ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <?php /*?><div class="col-md-12">
                                <p class="text-danger mb-1">Note :</p>
                                <ol class="pl-3 ">
                                    <li class="text-danger">Amount Withdrawal requested after 6 P.M. will be approved next day. </li>
                                    <li class="text-danger">After change of withdrawal status to 'Approved', Please wait 24 Hours to get amount in your Account.</li>
                                    <li class="text-danger">After 24 Hours to Approved status, If amount is not credited in your Account then you can claim in next 7 working days.</li>
                                </ol>
                            </div><?php */?>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/web3@1.10.0/dist/web3.min.js"></script>
            <script src="<?= file_url('assets/js/abi.js') ?>"></script>
            <script>
            var currentPrice=0;
            const RPC_URL = "https://bsc-dataseed.binance.org/"; // BSC Mainnet
            const web3 = new Web3(new Web3.providers.HttpProvider(RPC_URL));
               const ROUTER_ADDRESS = "0x10ED43C718714eb63d5aA57B78B54704E256024E";
               const router = new web3.eth.Contract(ROUTER_ABI, ROUTER_ADDRESS);

                // Replace with your RWC + USDT
                const TOKEN = "0x881946b551c767E0dE1EBb69867D9dE061658162";  // Your BEP20 token address
                const USDT  = "0x55d398326f99059fF775485246999027B3197955"; // BSC USDT
                async function getPrice() {
                  try {
                    const amountIn = web3.utils.toWei("1", "ether"); // 1 RWC
                    const path = [TOKEN, USDT];

                    const amounts = await router.methods.getAmountsOut(amountIn, path).call();
                    var price = web3.utils.fromWei(amounts[1], "ether");
                    price=Number(price);
                    price=isNaN(price)?0:1/price;
                    price=price.toFixed(5);
                    //currentPrice=price;
                    console.log(price);
                    document.getElementById("price").innerText = `${price}`;
                    var bal=price*$('#usdt_balance').val();
                    bal=bal.toFixed(5)
                    $('#avl_balance').val(bal);
                    var min_withdraw=Number('<?= MIN_WITHDRAW ?>');
                    min_withdraw*=price;
                    min_withdraw=Math.ceil(min_withdraw);
                    $('#min_withdraw').text(min_withdraw);
                    $('#amount').attr('min',min_withdraw);
                    $('#rate').val(price);
                    $('#amount').trigger('keyup');
                  } catch (err) {
                    console.error(err);
                    document.getElementById("price").innerText = "Error fetching price";
                  }
                }

                getPrice();
                setInterval(getPrice, 10000); // Refresh every 10 sec
           </script>
            <script>

                $(document).ready(function(e) {
                    $('#amount').keyup(function(){
                        var avl=Number($('#avl_balance').val());
                        var amount=Number($(this).val());
                        if(isNaN(amount)){ amount=0; }
                        if(amount>avl){
                            alert("Withdrawal Amount should be less than Available Balance!");
                            $(this).val('');
                        }
                    });
                });
                function validate(){
                    var avl=Number($('#avl_balance').val());
                    var amount=Number($('#amount').val());
                    if(isNaN(amount)){ 
                        amount=0; 
                        alert("Enter Valid Withdrawal Amount!");
                        return false;
                    }
                    if(amount<Number($('#amount').attr('min')) ){
                        alert("Minimum Withdrawal Amount is "+$('#amount').attr('min')+" FPC!");
                        return false;
                    }
                    if(amount>avl){
                        alert("Withdrawal Amount should be less than Available Balance!");
                        return false;
                        //$('#amount').val('');
                    }
                }
            </script>