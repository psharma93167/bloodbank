
$(document).ready(function(){
    $("#banks").change(function(){
        var bankCode=  this.value;
        $('#cost').val('');
        $('#discount').val('');
        $('#amountpayble').val('');
        $.ajax({
            type: "POST",
            url: 'process.php',
            data: {bankCode:bankCode,action:'getGroupCode'},
            success: function(data){
                    $('#bloods').empty().append(data);
            },
            error: function(xhr, status, error){
                 console.error(xhr);
            }
        });

    });

    $("#qty").change(function(){
        changeCost();
    });
    $("#bloods").change(function(){
        changeCost();
    });
    $("#cutomertypes").change(function(){
        changeCost();
    });
    function changeCost(){
        var bankCode=  $('#banks').find(":selected").val();
        var groudCode=  $('#bloods').find(":selected").val();
        var cutomertypes=  $('#cutomertypes').find(":selected").val();
        var qty=  $('#qty').val();
        if(bankCode == '' || groudCode == ''){
            alert('Please select bank and group');
            return false;
        }
        if(qty == ''){
            return false;
        }
        $.ajax({
            type: "POST",
            url: 'process.php',
            dataType:"json",
            data: {bankCode:bankCode,groudCode:groudCode,action:'getPrice'},
            success: function(data){
                let pricePerUnit = data.PricePerUnit;
                let cost = parseFloat(qty)*parseFloat(pricePerUnit);
                let discount =0;
                if(cutomertypes == 'Employee'){
                 discount = cost*20/100;
                }
                let netAmount = cost-discount;
                $('#cost').val(cost);
                $('#discount').val(discount);
                $('#amountpayble').val(netAmount);
            },
            error: function(xhr, status, error){
                 console.error(xhr);
            }
        });
    }

   
  });
  function formValidation(){
    var bankCode=  $('#banks').find(":selected").val();
    var groudCode=  $('#bloods').find(":selected").val();
    var cutomertypes=  $('#cutomertypes').find(":selected").val();
    var qty=  $('#qty').val();
    var cost=  $('#cost').val();
    var discount=  $('#discount').val();
    var amountpayble=  $('#amountpayble').val();
    if(bankCode == '' || groudCode == '' ||cutomertypes == '' ||qty == '' ||cost == '' ||discount == '' ||amountpayble == '' ){
        alert('Please enter or select all requird fields');
        return false;
    }

}
//
