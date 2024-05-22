function print_today() {
  // ***********************************************
  // AUTHOR: WWW.CGISCRIPT.NET, LLC
  // URL: http://www.cgiscript.net
  // Use the script, just leave this message intact.
  // Download your FREE CGI/Perl Scripts today!
  // ( http://www.cgiscript.net/scripts.htm )
  // ***********************************************
  var now = new Date();
  var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
  var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
  function fourdigits(number) {
    return (number < 1000) ? number + 1900 : number;
  }
  var today =  months[now.getMonth()] + " " + date + ", " + (fourdigits(now.getYear()));
  return today;
}

// from http://www.mediacollege.com/internet/javascript/number/round.html
function roundNumber(number,decimals) {
  var newString;// The new rounded number
  decimals = Number(decimals);
  if (decimals < 1) {
    newString = (Math.round(number)).toString();
  } else {
    var numString = number.toString();
    if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
      numString += ".";// give it one at the end
    }
    var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
    var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
    var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
    if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
      if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
        while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
          if (d1 != ".") {
            cutoff -= 1;
            d1 = Number(numString.substring(cutoff,cutoff+1));
          } else {
            cutoff -= 1;
          }
        }
      }
      d1 += 1;
    } 
    if (d1 == 10) {
      numString = numString.substring(0, numString.lastIndexOf("."));
      var roundedNum = Number(numString) + 1;
      newString = roundedNum.toString() + '.';
    } else {
      newString = numString.substring(0,cutoff) + d1.toString();
    }
  }
  if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
    newString += ".";
  }
  var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
  for(var i=0;i<decimals-decs;i++) newString += "0";
  //var newNumber = Number(newString);// make it a number if you like
  return newString; // Output the result to the form field (change for your purposes)
}

function update_total() {
  var total = 0;
  $('.price').each(function(i){
    price = $(this).html().replace("","");
    if (!isNaN(price)) total += Number(price);
  });

  total = roundNumber(total,2);

  $('#subtotal').html(""+total);
  $('#total').html(""+total);
  
  // var stax = (18 * total) / 100;
  // stax = roundNumber(stax,2);
  //$('#paid').val(stax);
  //update_balance();
  update_gstpervalue();
}

function update_balance() {
  var due = $("#total").html().replace("","") - $("#paid").val().replace("","-");
  due = roundNumber(due,2);
  
  $('.due').html(""+due);
}

function update_gstpervalue(){
	
	var stax = ($("#serviceTaxVal").val().replace("","")  * $("#total").val().replace("","") ) / 100;
	stax = roundNumber(stax,2);
	CGSTvalue=roundNumber((stax/2),2);
	IGSTvalue=roundNumber((stax/2),2);
	$('#paid').val(stax);
	document.getElementById("CGSTvalue").value=CGSTvalue;
	document.getElementById("SGSTvalue").value=IGSTvalue;
	
	var CGSTSGST = ($("#serviceTaxVal").val().replace("","")) / 2;
	document.getElementById("CGST").value=CGSTSGST;
	document.getElementById("SGST").value=CGSTSGST;

	update_balance();
	
}

function update_price() {
  var row = $(this).parents('.item-row');
  var price = row.find('.cost').val() * row.find('.qty').val();
  price = roundNumber(price,2);
  isNaN(price) ? row.find('.price').html("N/A") : row.find('.price').html(""+price);
  
  update_total();
}

function bind() {
  $(".cost").change(update_price);
  $(".qty").change(update_price);
  $("#paid").blur(update_balance);
  $("#serviceTaxVal").change(update_gstpervalue);  
}

$(document).ready(function() {

  $('input').click(function(){
    $(this).select();
  });

  $("#paid").blur(update_balance);
   
  $("#addrow").click(function(){
    $(".item-row:last").after('<tr class="item-row top-border"> <td class="item-name"><div class="form-group col-12 col-md-12"><label>Bank Name</label> <select class="custom-select" name="EMIBankName[]" id="EMIBankName"> <option value="Standard Charted Bank">Standard Charted Bank</option><option value="Bank of Baroda">Bank of Baroda</option><option value="Emirates NBD Bank">Emirates NBD Bank</option><option value="Emirates Islamic Bank">Emirates Islamic Bank</option><option value="Mashreq Bank">Mashreq Bank</option><option value="RAK Bank">RAK Bank</option><option value="ADCB Bank">ADCB Bank</option><option value="Abu Dhabi Islamic Bank">Abu Dhabi Islamic Bank</option><option value="Dubai Islamic Bank">Dubai Islamic Bank</option><option value="National Bank Of Fujairah">National Bank Of Fujairah</option><option value="CITIBANK">CITIBANK</option><option value="HSBC Bank">HSBC Bank</option><option value="First Abu Dhabi Bank">First Abu Dhabi Bank</option> </select></div></td><td><div class="form-group col-12 col-md-12"><label>Type of Loan</label><select class="custom-select" name="EMITypeofLoan[]" id="inlineFormCustomSelectPref"> <option value="Personal Loan">Personal Loan</option><option value="Car Loan">Car Loan</option><option value="Mortgage loan">Mortgage loan</option></select></div></td><td><div class="form-group col-12 col-md-12"><label>Monthly EMI</label><div class="input-group"><input type="text" name="EMIMonthlyAmount[]" class="form-control" placeholder="Monthly EMI"><div class="input-group-prepend"> <select class="custom-select" name="EMICurrencyType[]" id="EMICurrencyType"> <option value="AED">AED</option><option value="USD">USD</option><option value="INR">INR</option> </select></div></div></div></td><td> <div class="form-group col-12 col-md-12"> <label class="nodisplay">&nbsp;</label> <div class="input-group"> <a class="btn btn-submit delete" href="javascript:;" title="Remove row"><i class="fa fa-trash"></i></a> </div> </div> </td></tr>');
    if ($(".delete").length > 0) $(".delete").show();
    bind();
  });
  
  bind();
  
  $(".delete").live('click',function(){
    $(this).parents('.item-row').remove();
    update_total();
    if ($(".delete").length < 1) $(".delete").hide();
	if ($(".delete2").length < 2) $(".delete2").hide();
  });
  
  $("#cancel-logo").click(function(){
    $("#logo").removeClass('edit');
  });
  $("#delete-logo").click(function(){
    $("#logo").remove();
  });
  $("#change-logo").click(function(){
    $("#logo").addClass('edit');
    $("#imageloc").val($("#image").attr('src'));
    $("#image").select();
  });
  $("#save-logo").click(function(){
    $("#image").attr('src',$("#imageloc").val());
    $("#logo").removeClass('edit');
  });
  
  $("#date").val(print_today());
  
});