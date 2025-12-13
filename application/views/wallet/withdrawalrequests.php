
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">   
                                <div id="tabulator-table"></div>
                            </div>
                        </div>
                    </div>
                </div>
    <script>
	
		$(document).ready(function(e) {
            alertify.defaults.transition = "slide";
            alertify.defaults.theme.ok = "btn btn-primary";
            alertify.defaults.theme.cancel = "btn btn-danger";
            alertify.defaults.theme.input = "form-control";
            $('body').on('click','.approve-transfer',function(){
                var id=$(this).val();
                var recipient=$(this).data('address');
                var amount=$(this).data('amount');
                alertify.confirm("Approve Withdrawal Request", "Are you sure you want to Approve this Withdrawal Request?", 
                    function(){ 
                        sendFPC(id, recipient, amount);
                    },
                    function(){ alertify.error("Withdrawal Request Approval Cancelled!"); }
                ).set('labels', {ok:'Approve Withdrawal Request'});
            });
            $('body').on('click','.reject',function(){
                var id=$(this).val();
                
                alertify.prompt("Reject Withdrawal Request", "Enter Reason to Reject Withdrawal Request :", "", 
                    function(evt, value){ 
                        if (value.trim() === "") {  
                            alertify.alert("Error","Reason is required!");
                            return false;  // Prevent closing the prompt
                        } 
                        $.ajax({
                            type:'post',
                            url:"<?= base_url('wallet/rejectwithdrawal') ?>",
                            data:{id:id,remarks:value},
                            success:function(data){
                                data=JSON.parse(data);
                                if(data.status===true){
                                    refreshTableData();
                                    alertify.success(data.message);
                                }
                                else{
                                    alertify.error(data.message);
                                }
                            }
                        });  
                    }, 
                    function(){ alertify.error("Reject Withdrawal Request Cancelled"); }
                ).set('labels', {ok:'Reject Withdrawal Request'})
                .set('closable', false);
            });

            
            var url="<?= base_url('wallet/withdrawalrequests/?type=data'); ?>";
            var columns=[
                    { 
                        title: "Sl.No.", 
                        field: "serial", 
                        type: "auto"
                    },
                    { 
                        title: "Date", 
                        field: "date",width:140,
                        formatter: function(cell){
                            let dateStr = cell.getValue(); // Y-m-d format
                            let formattedDate = dateStr.split("-").reverse().join("-");
                            return formattedDate;
                        }
                    },
                    { title: "MID", field: "username", width:100 },
                    { title: "Name", field: "name", width:180 },
                    { title: "Address", field: "wallet_address", width:450 },
                    { title: "Amount", field: "amount", width:250 ,
                        formatter: function(cell){
                            let rowData = cell.getRow().getData();
                            let rate = rowData.rate;
                            let amount = Number(cell.getValue());
                            amount=amount==Math.round(amount)?Math.round(amount):amount.toFixed(8);
                            if(rate>0){
                                let amt = Number(amount*rate);
                                amt = amt.toFixed(4)==Math.round(amt)?Math.round(amt):amt.toFixed(4);
                                return '$'+amount +' ('+amt+' FPC)'
                            }
                            else{
                                return '$'+amount;
                            }
                        }
                    },
                    { title: "Deduction", field: "deduction_amount", width:250 ,
                        formatter: function(cell){
                            let rowData = cell.getRow().getData();
                            let rate = rowData.rate;
                            let amount = Number(cell.getValue());
                            amount=amount==Math.round(amount)?Math.round(amount):amount.toFixed(8);
                            if(rate>0){
                                let amt = Number(amount*rate);
                                amt = amt.toFixed(4)==Math.round(amt)?Math.round(amt):amt.toFixed(4);
                                return '$'+amount +' ('+amt+' FPC)'
                            }
                            else{
                                return '$'+amount;
                            }
                        }
                    },
                    { title: "Payable($)", field: "payable_amount" , width:180 ,
                        formatter: function(cell){
                            let amount = Number(cell.getValue());
                            amount=amount==Math.round(amount)?Math.round(amount):amount.toFixed(8);
                            return '$'+amount
                        }
                    },
                    { title: "Payable(FPC)", field: "amount_fpc" , width:180 ,
                        formatter: function(cell){
                            let amount_fpc = Number(cell.getValue());
                            amount_fpc=amount_fpc==Math.round(amount_fpc)?Math.round(amount_fpc):amount_fpc.toFixed(8);
                            return amount_fpc+' FPC';
                        }
                    },
                    { 
                       title: "Action", 
                       field: "id", 
                       width: 200, 
                       formatter: function(cell) {
                           let rowData = cell.getRow().getData();
                           let id = rowData.id; // Get full row data
                           let amount_fpc = Number(rowData.amount_fpc); // Get full row data
                           let amount = Number(rowData.payable_amount); // Get full row data
                           let address = rowData.wallet_address; // Get full row data
                           amount=amount==Math.round(amount)?Math.round(amount):amount.toFixed(8);
                           amount_fpc=amount_fpc==Math.round(amount_fpc)?Math.round(amount_fpc):amount_fpc.toFixed(8);
                           let button=`<button type="button" class="btn btn-sm btn-success approve-transfer mb-1" value="${id}" data-amount="${amount_fpc}" data-address="${address}">Approve Withdrawal</button><br>`;
                           //button+=`<button type="button" class="btn btn-sm btn-success approve-staking mb-1" value="${id}">Transfer to Staking</button><br>`;
                           button+=`<button type="button" class="btn btn-sm btn-danger reject" value="${id}">Reject</button>`;
                           return button;
                       } 
                    }
                ];

            var pagination={
                sizes:[10, 20, 50, 100]
            }

            var table=createTabulator('tabulator-table',url,columns,pagination);

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

            $('body').on('click','.view-screenshot',function(){
                var src=$(this).data('src');
                $('#preview').attr('src',src);
                var myModal = new bootstrap.Modal(document.getElementById('modal-default'));
                myModal.show();

            });

        });
        
        function approveWithdrawal(id,response){
            
            $.ajax({
                type:'post',
                url:"<?= base_url('wallet/approvewithdrawal') ?>",
                data:{id:id,response:response},
                success:function(data){
                    data=JSON.parse(data);
                    if(data.status===true){
                        alertify.success(data.message);
                        window.location.reload();
                    }
                    else{
                        alertify.error(data.message);
                    }
                }
            }); 
        }
        
        function logError(id,response){
            
            $.ajax({
                type:'post',
                url:"<?= base_url('wallet/logerror') ?>",
                data:{id:id,response:response},
                success:function(data){
                    data=JSON.parse(data);
                    if(data.status===true){
                        alertify.success(data.message);
                        window.location.reload();
                    }
                    else{
                        alertify.error(data.message);
                    }
                }
            }); 
        }
        
		function validate(){
			if(!confirm("Confirm Activate this Member?")){
				return false;
			}
		}
	</script>
    <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js/dist/web3.min.js"></script>
    <script src="<?= file_url('assets/js/abi.js') ?>"></script>
    <script>
        const BSC_CHAIN_ID = '0x38'; // 56 in decimal for Binance Smart Chain Mainnet
        const TOKEN = "0x881946b551c767E0dE1EBb69867D9dE061658162";  // Your BEP20 token address
        const USDT_CONTRACT_ADDRESS = '0x55d398326f99059fF775485246999027B3197955'; // USDT BEP20 Address
        const USDT_ABI2 = [ // Minimal ABI for token interactions
            {
                "constant": false,
                "inputs": [
                    { "name": "_spender", "type": "address" },
                    { "name": "_value", "type": "uint256" }
                ],
                "name": "approve",
                "outputs": [{ "name": "", "type": "bool" }],
                "type": "function"
            },
            {
                "constant": false,
                "inputs": [
                    { "name": "_to", "type": "address" },
                    { "name": "_value", "type": "uint256" }
                ],
                "name": "transfer",
                "outputs": [{ "name": "", "type": "bool" }],
                "type": "function"
            }
        ];

        let web3;
        let userAddress;

        // Connect to Wallet
        async function connectWallet() {
            if (window.ethereum) {
                web3 = new Web3(window.ethereum);
                try {
                    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                    userAddress = accounts[0];
                    //document.getElementById('walletAddress').textContent = userAddress;
                    //document.getElementById('walletInfo').style.display = 'block';
                    //document.getElementById('formContainer').style.display = 'block';

                    const chainId = await window.ethereum.request({ method: 'eth_chainId' });
                    if (chainId !== BSC_CHAIN_ID) {
                        try {
                            await window.ethereum.request({
                                method: 'wallet_switchEthereumChain',
                                params: [{ chainId: BSC_CHAIN_ID }],
                            });
                            console.log('Switched to Binance Smart Chain');
                        } catch (switchError) {
                            console.error('Failed to switch to Binance Smart Chain:', switchError);
                        }
                    }
                } catch (error) {
                    console.error('User denied wallet connection:', error);
                }
            } else {
                alert('No Ethereum-compatible browser extension detected.');
            }
        }

        async function sendUSDT(id, recipient,amount) {
            //if(confirm("Confirm approve Withdrawal?")){
                if (!recipient || amount <= 0) {
                    alert('Please enter valid recipient address and amount.');
                    return;
                }

                const usdtContract = new web3.eth.Contract(USDT_ABI2, USDT_CONTRACT_ADDRESS);
                try {
                    const tx = await usdtContract.methods
                        .transfer(recipient, web3.utils.toWei(amount.toString(), 'ether'))
                        .send({ from: userAddress });

                    console.log('Transaction successful:', tx);
                    approveWithdrawal(id,tx.transactionHash)
                    alert('Withdrawal Approved  successfully!');
                } catch (error) {
                    console.error('Transaction failed:', error);
                    alertify.error("Approval Failed!");
                }
            //}
        }
        async function sendFPC(id, recipient,amount) {
            //if(confirm("Confirm approve Withdrawal?")){
                if (!recipient || amount <= 0) {
                    alert('Please enter valid recipient address and amount.');
                    return;
                }

                const fpcContract = new web3.eth.Contract(TOKEN_ABI, TOKEN);
                try {
                    const tx = await fpcContract.methods
                        .transfer(recipient, web3.utils.toWei(amount.toString(), 'ether'))
                        .send({ from: userAddress });

                    console.log('Transaction successful:', tx);
                    approveWithdrawal(id,tx.transactionHash)
                    alert('Withdrawal Approved  successfully!');
                } catch (error) {
                    console.error('Transaction failed:', error);
                    alertify.error("Approval Failed!");
                }
            //}
        }
        window.onload=function(){
            connectWallet();
        }
    </script>