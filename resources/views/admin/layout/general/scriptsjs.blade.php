<script src="{{asset('admin/assets/dist/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/datedropper/datedropper.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/moment/moment.js')}}"></script>
<script src="{{asset('admin/assets/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/screenfull/dist/screenfull.js')}}"></script>
<script src="{{asset('admin/assets/plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/amcharts/amcharts.js')}}"></script>
<script src="{{asset('admin/assets/plugins/amcharts/gauge.js')}}"></script>
<script src="{{asset('admin/assets/plugins/amcharts/serial.js')}}"></script>
<script src="{{asset('admin/assets/plugins/amcharts/themes/light.js')}}"></script>
<script src="{{asset('admin/assets/plugins/amcharts/animate.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/amcharts/pie.js')}}"></script>
<script src="{{asset('admin/assets/plugins/ammap3/ammap/ammap.js')}}"></script>
<script src="{{asset('admin/assets/plugins/ammap3/ammap/maps/js/usaLow.js')}}"></script>
<script src="{{asset('admin/assets/dist/js/theme.min.js')}}"></script>
<script src="{{asset('admin/assets/js/chart-amcharts.js')}}"></script>
<script src="{{asset('admin/assets/js/chart-amcharts.js')}}"></script>
<script src="{{asset('admin/assets/js/alerts.js')}}"></script>
@include('admin.layout.general.notify')

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="{{asset('admin/assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatables.js')}}"></script>
{{-- <script src="{{asset('admin/assets/src/js/vendor/jquery-3.3.1.min.js')}}"></script>  --}}

<script src="{{asset('admin/assets/js/form-advanced.js')}}"></script>
<script src="{{asset('admin/bower_components/select2/dist/js/select2.full.min.js')}}"></script>



{{-- summernote --}}
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

@yield('bottom-scripts')


<script>

$(document).on("click", "a.deleteText", function() {
    if (confirm('Are you sure you want to delete?')) {
        $(this).prev('span.text').remove();
    }
});
 

$(document).ready(function() {
  $('#summernote').summernote();
  $('#summernote0').summernote();
  $('#summernote1').summernote();
  $('#summernote2').summernote();
  $('#summernote3').summernote();
  $('#summernote4').summernote();
  $('#summernote5').summernote();

});
</script>

<script>

  $('#summernoteshow0').on('click',function(){
   $(".summernoteshow1").toggle(); 
 })
 $('#summernoteshow1').on('click',function(){
   $(".summernoteshow2").toggle(); 

 })

</script>

<script>
  $('#submitreport').change(function(){
    if($(this).is(':checked')){
    $(".submitreport1").hide(); 
    $(".submitreport2").toggle();
    }else{
      $(".submitreport1").toggle(); 
      $(".submitreport2").hide();
    }
  })

  $('#pharmsubmitreport').change(function(){
    if($(this).is(':checked')){
    $(".pharmsubmitreport1").hide(); 
    $(".pharmsubmitreport2").toggle();
    }else{
      $(".pharmsubmitreport1").toggle(); 
      $(".pharmsubmitreport2").hide();
    }
  })
 </script>
 <script>
  $('#check_singlelab').change(function(){
    if($(this).is(':checked')){
      $(".multilabcheck").hide(); 
    $(".singlelab").hide(); 
    $(".singlelab").toggle();
    }else{
      $(".singlelab").toggle(); 
      $(".singlelab").hide();
      $(".multilabcheck").toggle(); 

    }
  })

  $('#check_multilab').change(function(){
    if($(this).is(':checked')){
      $(".singlelabcheck").hide(); 
    $(".multilab").hide(); 
    $(".multilab").toggle();
    }else{
      $(".singlelabcheck").toggle(); 
      $(".multilab").toggle(); 
      $(".multilab").hide();
    }
  })

 </script>
<script>
  $(document).ready(function() {
    var evaluation = $('input[id="evaluation"]').attr("value");
    if (evaluation === '1') {
      $('#complete_report').prop("disabled", true);
    }else{
      $('#complete_report').prop("disabled", false);
    }
  
    if (evaluation === '2') {
      $('#submit_report').prop("disabled", true);
    }
    console.log(evaluation)
  });
  
  </script>
<script>
//this is on the showpage if checked ...
$(document).ready(function() {
 
  var efficacy_value = $('input[id="check_efficacy2"]').attr("value");
  $('input[id="check_efficacy2"]').click(function() {
          $("." + efficacy_value).toggle();
      });
  });
</script>
<script>
$(document).ready(function(){
 $("#printreport").click(function () {
    //Hide all other elements other than printarea.
    $("#printarea").show();
    window.print();
});
});
</script>

<!-- show table head when page loads showmicroreportpage-->
<script type="text/javascript">
  $(document).ready(function(){
  var input_value = $('input[id="pi_zone"]').attr("value");
  $('.date-inputmask').inputmask("9.9 X 99^9");
  console.log(input_value)
  if (input_value === '768992334039322') {
    $("." + input_value).toggle();
    $(".checkefficacy1").hide();
  }

  // var mannycount_la = $('input[id="load_analyses_id"]').attr("value");
  // if (mannycount_la === '3') {
  //   $("." + mannycount_la).toggle();
  //   $('input[id="result_disabled0"]').val('5.0 x 10^4');
  //   $('input[id="result_disabled1"]').val('5.0 x 10^4');

  //   $('input[id="criterion_disabled0"]').val('5.0 x 10^4');
  //   $('input[id="criterion_disabled1"]').val('5.0 x 10^4');

  //   $(".1").hide();

  //   $('input[id="load_analyses0"]').prop("disabled", true);
  //   $('input[id="load_analyses1"]').prop("disabled", true);
  //   $('input[id="load_analyses2"]').prop("disabled", true);
  //   $('input[id="load_analyses3"]').prop("disabled", true);
  //   $('input[id="load_analyses4"]').prop("disabled", true);

  // }if ((mannycount_la === '1')) {
  //   $('input[id="mannycount_loadanalyses0"]').prop("disabled", true);
  //   $('input[id="mannycount_loadanalyses1"]').prop("disabled", true);
  //   $('input[id="mannycount_loadanalyses2"]').prop("disabled", true);
  //   $('input[id="mannycount_loadanalyses3"]').prop("disabled", true);
  //   $('input[id="mannycount_loadanalyses4"]').prop("disabled", true);

  // }
  var product_showtypestate = $('input[id="product_typestate"]').attr("value");
  console.log(product_showtypestate)
  if (product_showtypestate === '77772') {
      $("." + product_showtypestate).toggle();
    }else {
      $("." + '77771').toggle();
    }

  })
</script>

<script>
  $(document).ready(function(){
    var productstatus_value = $('input[id="product_status"]').attr("value");
    console.log(productstatus_value)
  if (productstatus_value === '8119200123') {
    $("." + productstatus_value).toggle();
  }
  var loadanalyses_value = $('input[id="load_analyses"]').attr("value");
  console.log( loadanalyses_value)
  if (loadanalyses_value === '02348403') {
    $("." + loadanalyses_value).toggle();
  }
  })
</script>

<!-- show table head when page selcet product showmicroreportpage-->
<script>
$("#microproduct_id").change(function() {
  var product_typeform = $('option:selected', this).attr('product_typeform');
  console.log(product_typeform);
  if (product_typeform === '88882') {
    $('#expresult-1').val('5.0 x 10^7')
    $('#mla-mannycount1').val('5.0 x 10^7')

    $('#expresult-2').val('5.0 x 10^5')
    $('#mla-mannycount2').val('5.0 x 10^5')

  }else{
    $('#expresult-1').val('5.0 x 10^4')
    $('#mla-mannycount1').val('5.0 x 10^4')

    $('#expresult-2').val('5.0 x 10^2')
    $('#mla-mannycount2').val('5.0 x 10^2')
  }
})
</script>

<script>

$("#inputmask_0").on('keyup', function() {
  console.log()
  if (this.value.replace(/[.X^]/g, '').length === 0) {
    alert('Empty');
  }
});
</script>
<script>
  $('#checkinputmask').submit(function(e){
     
       e.preventDefault();
       console.log('attempted to submit form check inputmask')
       
       var inputmask_1 = $('#inputmask_0').val();
       var inputmask_2 = $('#inputmask_1').val();
       var replace_1 = inputmask_1.replace(/[.X_^]/g, '');
       var replace_2 = inputmask_2.replace(/[.X_^]/g, '');

       var  length1 = replace_1.length;
       var  length2 = replace_2.length;

       if(length1 < 7){
        $('#error-div0').html("Error: Please check Result field and input data properly")
       }else{
        $('#error-div0').html(" ")
       }

       if(length2 < 7){
        $('#error-div1').html("Error: Please check Result field and input data properly")
       }else{
        $('#error-div1').html(" ")
       }

      if (length1 + length2 === 14)
     {
       // $('#userid').val(result.user);
        e.currentTarget.submit();
     }

   })
   </script>

  <script>
 $('#checkunit').submit(function(e){
     
     e.preventDefault();
     console.log('attempted to submit form check unit')
     
     var unit = $('#unit3').val();
     var  length = unit.length;
       
     if(length !== 3){
      $('#error-div3').html("Please check unit field ")
     }else{
      $('#error-div3').html(" ")
     }

    if (length === 3)
   {
     // $('#userid').val(result.user);
      e.currentTarget.submit();
   }

 })
  </script>

<script>
    $(document).ready(function(){
      $('#stateresult').html('Result (CFU/g)'); 
      $('#manycount_stateresult').html('Result (CFU/g)'); 
    })
    $("#microproduct_id").change(function(){
      var product_typestate = $('option:selected', this).attr('product_typestate');
     console.log(product_typestate);
    if (product_typestate === '77772') {
      $('#stateresult').html('Result (CFU/ml)'); 
      $('#manycount_stateresult').html('Result (CFU/ml)'); 

    } else
    $('#stateresult').html('Result (CFU/g)'); 
    $('#manycount_stateresult').html('Result (CFU/g)'); 
    })
  
</script>

<!-- show form when checked -->
 <script type="text/javascript">
  $(document).ready(function() {
    var inputValue = $('input[id="inlineCheckbox1"]').attr("value");

    if($('input[id="inlineCheckbox1"]').prop('checked')){
      $("." + inputValue).toggle();
          $('.date-inputmask').inputmask("9.9 X 99^9");

      }

      $('input[id="inlineCheckbox1"]').click(function() {
          $("." + inputValue).toggle();
          $('#fadeout2').fadeOut('slow');
          $("." +'efficacyonly').fadeOut('slow');  

        if($(this).prop('checked')){
          $('.date-inputmask').inputmask("9.9 X 99^9");
        }
        if($('#inlineCheckbox1').not(':checked')){
         $('#fadeout2').show(); 
         $("." +'efficacyonly').show();  
 
        } 
      });
  });

  $(document).ready(function() {
    var inputValue = $('input[id="inlineCheckbox2"]').attr("value");

    if($('input[id="inlineCheckbox2"]').prop('checked')){
      $("." + inputValue).toggle();
          $('.date-inputmask').inputmask("9.9 X 99^9");
      }

      $('input[id="inlineCheckbox2"]').click(function() {
          $("." + inputValue).toggle();
        if($(this).prop('checked')){
          $('.date-inputmask').inputmask("9.9 X 99^9");
        }
      });
  });

  $(document).ready(function() {
    var inputValue = $('input[id="inlineCheckbox3"]').attr("value");
    $('input[id="inlineCheckbox3"]').click(function() {
      console.log(inputValue)
      $("." + inputValue).toggle();

      
     });
      
  });

</script>
<script>
  
  $(document).ready(function() {
    var inputValue = $('input[id="ml_general_conclusion"]').attr("value");
    $('input[id="ml_general_conclusion"]').click(function() {
      console.log(inputValue)
      $("." + inputValue).toggle();
      $('#micro_la_conclution_option').prop('required',false)

     });
      
  });

  $(document).ready(function() {
    
    
    var inputValue = $('input[id="me_general_conclusion"]').attr("value");
    $('input[id="me_general_conclusion"]').click(function() {
      console.log(inputValue)
      $("." + inputValue).toggle();
      // $('#micro_la_conclution_option').prop('required',false)

     });
  });
</script>
<script>

$(document).ready(function() {
  var rstotal1 = $('input[id="rstotal_0"]').attr("value");
var txt =  "3";
 if (rstotal1 == 0) {
  document.getElementById("manycount0").innerHTML = "0";
  }
  if (rstotal1 == 9900000000) {
    document.getElementById("manycount0").innerHTML = "<span> " + txt.sup() + " TNTC </span>";
  }

  var rstotal2 = $('input[id="rstotal_1"]').attr("value");
  if (rstotal2 == 0) {
    document.getElementById("manycount1").innerHTML = "0";
  }
  if (rstotal2 == 9900000000) {
    document.getElementById("manycount1").innerHTML = "<span> " + txt.sup() + " TNTC </span>";
  }
  });
  
</script>

<script>

$(document).ready(function() {

  var rstotal1 = $('input[id="rstotal0"]').attr("value");
  var txt =  "3";
  if (rstotal1 === "0") {
  document.getElementById("manycount_0").innerHTML = "0";
  }
  if (rstotal1 == 9900000000) {
    document.getElementById("manycount_0").innerHTML = "<span> " + txt.sup() + " TNTC </span>";
  }

  var rstotal2 = $('input[id="rstotal1"]').attr("value");
  
  if (rstotal2 == "0") {
    document.getElementById("manycount_1").innerHTML = "0";
  }
  if (rstotal2 == 9900000000) {
    document.getElementById("manycount_1").innerHTML = "<span> " + txt.sup() + " TNTC </span>";
  }
  });
  
</script>




<!-- model -->
<!-- Auto complete search -->
 <script>

  $( document ).ready(function() {
   $( "#exampleModalCenter" ).trigger( "click" );
});

$(document).ready(function(){
  $("#listSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#listSearch1").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList1 li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#listSearch2").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList2 li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#listSearch3").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList3 li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<script>
  $(".delete").on("submit", function(){
      return confirm("Are you sure?");
  });
</script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
      
  
      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()
  
      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
      //Date range as a button
      $('#daterange-btn').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )
  
      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      })
  
      //iCheck for checkbox and radio inputs
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
      })
      //Red color scheme for iCheck
      $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass   : 'iradio_minimal-red'
      })
      //Flat red color scheme for iCheck
      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
      })
  
      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()
  
      //Timepicker
      $('.timepicker').timepicker({
        showInputs: false
      })
    })
</script>
<script>
  $(function () {
  
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>


  <!-- checkusermicro-->
<script>
    var selectedItems = [];
    $(document).on('change','.microselect',function(){
      if($(this).is(':checked')){
        selectedItems.push($(this).val())
      }else{
        var index = selectedItems.indexOf($(this).val())
        if(index != -1)
        selectedItems.splice(index,1)
      }
      console.log(selectedItems)
    })

$('#acceptmicroproductform').submit(function(e){
  
    e.preventDefault();
    var product_id= $('input[id="deptproduct_id"]').attr("value");
         console.log(product_id);
    console.log('attempted to submit form')
    
    var _token = $('#_token').val()
    var useremail = $('#useremail').val()
    var userpin = $('#userpin').val()

  var data = {
  'email' : useremail,
  'pin' : userpin,
  '_token': _token
  }
  
  var form = $(this);
  var url = form.attr('sign-user-url');
  var url2 = form.attr('action')
  $.post(url, data, function(result){
  console.log(result)

  if (result.status === true)
  {
    $('#adminid').val(result.admin);
    // $('#deptproduct_id').val(selectedItems);

    console.log(selectedItems)
    selectedItems.forEach((item)=>{
      console.log(`<input type='hidden' value='${item}' name='deptproduct_id[]'`)
      $('#acceptmicroproductform').prepend(`<input type='hidden' value='${item}' name='deptproduct_id[]'>`)
    })
    selectedItems=[]
    e.currentTarget.submit();
   
  }

     // display the error message some where on the page with result.message
     $('#error-div').html(result.message)
  })
  
    // Continue the form submit
    // e.currentTarget.submit();
})
</script>

   <!-- checkuserpharm-->
<script>
      var pharm_selectedItems = [];
    $(document).on('change','.pharmselect',function(){
      if($(this).is(':checked')){
        pharm_selectedItems.push($(this).val())
      }else{
        var index = pharm_selectedItems.indexOf($(this).val())
        if(index != -1)
        pharm_selectedItems.splice(index,1)
      }
      console.log(pharm_selectedItems)
    })
$('#acceptpharmproductform').submit(function(e){
  
    e.preventDefault();
    var product_id= $('input[id="deptproduct_id"]').attr("value");
    console.log('attempted to submit form')
        
    var _token = $('#_token').val()
    var useremail = $('#useremail').val()
    var userpin = $('#userpin').val()

  var data = {
  'email' : useremail,
    'pin' : userpin,
  '_token': _token
  }
  
  var form = $(this);
  var url = form.attr('sign-user-url');
  var url2 = form.attr('action')
  $.post(url, data, function(result){
  console.log(result)

  if (result.status === true)
  {
    $('#adminid').val(result.admin);
    console.log(pharm_selectedItems)
    pharm_selectedItems.forEach((item)=>{
      console.log(`<input type='hidden' value='${item}' name='deptproduct_id[]'`)
      $('#acceptpharmproductform').prepend(`<input type='hidden' value='${item}' name='deptproduct_id[]'>`)
    })
    pharm_selectedItems=[]
    e.currentTarget.submit();
  }

    // display the error message some where on the page with result.message
  $('#error-div').html(result.message)
  })
  
    // Continue the form submit
// e.currentTarget.submit();
})
</script>

<!-- checkuserphyto-->
<script>
     var phyto_selectedItems = [];
    $(document).on('change','.phytoselect',function(){
      if($(this).is(':checked')){
        phyto_selectedItems.push($(this).val())
      }else{
        var index = phyto_selectedItems.indexOf($(this).val())
        if(index != -1)
        phyto_selectedItems.splice(index,1)
      }
      console.log(phyto_selectedItems)
    })

  $('#acceptphytoproductform').submit(function(e){
    
      e.preventDefault();
      console.log('attempted to submit form')
      
      var _token = $('#_token').val()
      var useremail = $('#useremail').val()
      var userpin = $('#userpin').val()
  
    var data = {
    'email' : useremail,
    'pin' : userpin,
    '_token': _token
    }
    
    var form = $(this);
    var url = form.attr('sign-user-url');
    // var url2 = form.attr('action')
    $.post(url, data, function(result){
    console.log(result)
  
    if (result.status === true)
    {
      $('#adminid').val(result.admin);
      
      console.log(phyto_selectedItems)
      phyto_selectedItems.forEach((item)=>{
      console.log(`<input type='hidden' value='${item}' name='deptproduct_id[]'`)
      $('#acceptphytoproductform').prepend(`<input type='hidden' value='${item}' name='deptproduct_id[]'>`)
    })
    phyto_selectedItems=[]

      e.currentTarget.submit();
    }
  
      // display the error message some where on the page with result.message
    $('#error-div').html(result.message)
    })
    
      // Continue the form submit
  // e.currentTarget.submit();
  })
  </script>

  <!--validate customer-->

<script>
 $('#customervalidation').submit(function(e){
    
      e.preventDefault();
      console.log('attempted to submit form')
      
      var _token = $('#_token').val()
      var firstname = $('#firstname').val()
      var lastname = $('#lastname').val()
  
      var data = {
      'firstname': firstname,
      'lastname' : lastname,
      '_token': _token
      }
    
      var form = $(this);
      var url = form.attr('validate-url');
      var url2 = form.attr('action')
      $.post(url, data, function(result){
      console.log(result)
  
    if (result.status === true)
    {
      // $('#userid').val(result.user);
       e.currentTarget.submit();
    }
  
      // display the error message some where on the page with result.message
    $('#error-div').html(result.message)
    })
    
      // Continue the form submit
  // e.currentTarget.submit();
  })
  </script>



<script>
$('#checkusertoacceptproduct').submit(function(e){
    
      e.preventDefault();
      console.log('attempted to submit form')
     
})    
  // Continue the form submit
  // e.currentTarget.submit();
</script>
  


{{-- pharmacology scripts --}}
<!-- Animal Experimentation maketest -->
<script>
  $(document).ready(function() {
    console.log('ajssssssssssssssssssssssssssd wede')
    $(`select[tag= 35909090456]`).select2();
    $(`select[tag= 359090904560]`).select2();
    $(`select[tag= 359090904561]`).select2();
    $(`select[tag= 359090904562]`).select2();
    });
  
  </script>
<script>
  var toxic = [];
  var animalmodel = [];
  $(document).ready(function(){
      var i=1;
      var j=1;
    $('#add').click(function(){
      i++; 
      $('#dynamic_field').append('<tr id="row'+i+'"> <td class="font"><div class=""><select class="form-control animalmodel" tagg="'+j+'"  name="animalmodel[]" required style="width:130px"></select></div></td><td class="font"><input type="text" required class="form-control" name="weight[]" placeholder="(g)" value="(g)" style="width:70px"></td><td class="font"><input type="text" class="form-control sp_volume" required name="dosage[]"  placeholder="(mg/kg)" Value ="5000 (mg/kg)" style="width:100px"></td>    <td class="font"> <select class="form-control select2 methodapplied"  name="method_of_admin[]" style="width:130"><option value="1">Oral</option><option value="2">Subcutanious</option><option value="3">Intradermal</option><option value="4">Intra Veinous</option><option value="5">Applied Topical</option> <option value="6">Applied Topical & Intrademal</option></select></td>     <td><input type="text" class="form-control" required name="time_administration[]" placeholder="Time/period" style="width:100px"></td>   <td class="font"><select class="form-control select23 toxicity1"   multiple="multiple" name="toxicity['+i+'][]" id="selectlist" tag="'+i+'" style="width:150"></select></td>    <td class="font"><select class="form-control" required id="animaldeath_'+i+'" name="death[]" style="width:70px"><option value="2">No</option><option value="1">Yes</option></select></td>    <td><input type="text" class="form-control" required value="Nill" name="time_death[]" placeholder="Time of death" style="width:100px"></td>   <td class="font"><select class="form-control allsex" required name="sex[]" style="width:100px"><option  value="">select</option><option value="1">Male</option><option value="2">Female</option></select></td>     <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');


      getToxicity(toxic,function(r){
        console.log(i,r)
        $(`select[tag=${i}]`).html('')
        r.forEach(function(item){
          $(`select[tag=${i}]`).append(`<option class='toxicity${item.id}' value='${item.name}'> ${item.name} </option>`)
        })
      })
      $(`select[tag=${i}]`).select2();
      

      getAnimalmodel(animalmodel,function(r){
        console.log(i,r)
        $(`select[tagg=${j}]`).html('')
        r.forEach(function(item){
          $(`select[tagg=${j}]`).append(`<option value='${item.id}'>${item.name}</option>`)
        })
      })

         $(`select[tag=${j}]`).select2();

      });
      

      function getToxicity(data,callback){
        if(data.length>0)
        {
          callback(data)
        }else{
          $.get("{{url('admin/pharm/animalexperimentation/fetchtoxicity')}}",function(resp){
            if(resp){
              toxic = resp.data
              callback(resp.data)
            }else{
              callback(null)
            }
          }).fail(function(){
            callback(null)
          })
        }
      }

      function getAnimalmodel(data,callback){
        if(data.length>0)
        {
          callback(data)
        }else{
          $.get("{{url('admin/pharm/animalexperimentation/fetchtanimal_model')}}",function(resp){
            if(resp){
              animalmodel = resp.data
              callback(resp.data)
            }else{
              callback(null)
            }
          }).fail(function(){
            callback(null)
          })
        }
      }

    $(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
  
  
  });
</script>


<script>
  $("#pharmproduct_id").change(function() {
    var product_ma = $('option:selected', this).attr('product_ma');
   
    console.log(product_ma);
    if (product_ma == 2) {
      $('#pharmtest').find('option[value="2"]').attr("selected",true);
      $("." + 'methodapp').toggle();  
    }
    else{
      $('#pharmtest').find('option[value="2"]').attr("selected",false);
      $("." + 'methodapp').hide();
    }

    if (product_ma == 1) {
      $('#pharmtest').find('option[value="1"]').attr("selected",true);
      $("." + 'methodapp').toggle();  
    }
    else{
      $('#pharmtest').find('option[value="1"]').attr("selected",false);
      $("." + 'methodapp').hide();
    }
  
    if (product_ma == 3) {
      $('#pharmtest').find('option[value="3"]').attr("selected",true);
      $("." + 'methodapp').toggle();  
    }
    else{
      $('#pharmtest').find('option[value="3"]').attr("selected",false);
      $("." + 'methodapp').hide();
    }

    if (product_ma == 2) {
      $('#pharmtest0').val('Dermal Toxicity Test');
    }
    if (product_ma == 1) {
      $('#pharmtest0').val('Acute Toxicity Test');
    }
    if (product_ma == 3) {
      $('#pharmtest0').val('Acute / Dermal Toxicity Test');
    }
  })
</script>

<script>
  $("#pharmproduct_id").change(function() {
var spvolume = $('option:selected', this).attr('spvolume');
console.log(spvolume);
 $("." + 'spvolume').val(spvolume);
   
  });
</script>

<script>
  var male_sex = $('input[id="male_sex"]').attr("value");
  var female_sex = $('input[id="female_sex"]').attr("value");

  console.log(male_sex)
 $('input[id="male_sex"]').click(function() {
    $("." + 'allsex').val(male_sex);
 });
 $('input[id="female_sex"]').click(function() {
    $("." + 'allsex').val(female_sex);
 });
</script>
<script>
  var male_sex2 = $('input[id="male_sex2"]').attr("value");
  var female_sex2 = $('input[id="female_sex2"]').attr("value");
 $('input[id="male_sex2"]').click(function() {
    $("." + 'allsex2').val(male_sex2);
 });
 $('input[id="female_sex2"]').click(function() {
    $("." + 'allsex2').val(female_sex2);
 });
</script>

<script>
$('#toxicity1').change(function(){
  if($(this).is(':checked')){
    console.log('cc')
    $('select[tag]').val('Nill').trigger('change') 

  }else{
    $('select[tag]').val('No Sign').trigger('change')
    console.log('mm')
  }
})
</script>

<script>
  var toxicity = $('input[id="toxicity2"]').attr("value");

 $('input[id="toxicity2"]').click(function() {
    $("." + 'toxicity2').val(2);
 });
 
</script>

<script>
  var toxicity = $('input[id="toxicity3"]').attr("value");

 $('input[id="toxicity3"]').click(function() {
    $("." + 'toxicity3').val(2);
 });
 
</script>

<script>
  $("#animal_model").change(function() {
var animalmodel = $('option:selected', this).val();
console.log(animalmodel);
 $("." + 'animalmodel').val(animalmodel);
   
  });

</script>

{{-- Hod Evaluation --}}

{{-- <script>
  $(document).ready(function() {
    var pharm_hod_evaluation = $('input[id="pharm_hod_evaluation"]').attr("value");
    if (pharm_hod_evaluation === '1') {
      $('#pharm_complete_report').prop("disabled", true);
    }else{
      $('#pharm_complete_report').prop("disabled", false);
    }
  
    if (pharm_hod_evaluation === '2') {
      $('#pharm_submit_report').prop("disabled", true);
    }
    });
  
</script> --}}



  {{-- pharm report display div base on test conducted --}}
  <script>
    $(document).ready(function() {    
  var test_conducted = $('input[id="pharm_test_conducted"]').attr("value");
  console.log(test_conducted);
  if (test_conducted == 1 || test_conducted == 3) {
    $(".test" + test_conducted).toggle();
  }
  else if (test_conducted == 2 || test_conducted == 3) {
    $(".test" + test_conducted).toggle();
  }
    });
  </script>

  {{-- Micro hop signin --}}
  <script>
    $('#microhodfinalapproveform').submit(function(e){

        e.preventDefault();
      
        console.log('attempted to submit form')
        
        var _token = $('#_token').val()
        var useremail = $('#useremail').val()
        var userpin = $('#userpin').val()
    
      var data = {
      'email' : useremail,
      'pin' : userpin,
      '_token': _token
      }
      
      var form = $(this);
      var url = form.attr('sign-user-url');
      var url2 = form.attr('action')
      $.post(url, data, function(result){
      console.log(result)
    
      if (result.status === true)
      {
        $('#adminid').val(result.admin);
        
        e.currentTarget.submit();
      }
    
        // display the error message some where on the page with result.message
      $('#error-div').html(result.message)
      })
      
        // Continue the form submit
    // e.currentTarget.submit();
    })
   </script>
  
  <script>
    $('#microhodapproveform').submit(function(e){
      
        e.preventDefault();
        console.log('attempted to submit form')
        
        var _token = $('#_token').val()
        var useremail = $('#useremail').val()
        var userpin = $('#userpin').val()
    
      var data = {
      'email' : useremail,
      'pin' : userpin,
      '_token': _token
      }
      
      var form = $(this);
      var url = form.attr('sign-user-url');
      var url2 = form.attr('action')
      $.post(url, data, function(result){
      console.log(result)
    
      if (result.status === true)
      {
        $('#adminid').val(result.admin);
        
        e.currentTarget.submit();
      }
    
        // display the error message some where on the page with result.message
      $('#error-div').html(result.message)
      })
      
        // Continue the form submit
    // e.currentTarget.submit();
    })
    </script>

    {{-- Pharm hop signin --}}
 
  <script>
    $('#pharmhodapproveform').submit(function(e){
      
        e.preventDefault();
        console.log('attempted to submit form')
        
        var _token = $('#_token').val()
        var useremail = $('#useremail').val()
        var userpin = $('#userpin').val()
    
      var data = {
      'email' : useremail,
      'pin' : userpin,
      '_token': _token
      }
      
      var form = $(this);
      var url = form.attr('sign-user-url');
      var url2 = form.attr('action')
      $.post(url, data, function(result){
      console.log(result)
    
      if (result.status === true)
      {
        $('#adminid').val(result.admin);
        e.currentTarget.submit();
      }
        // display the error message some where on the page with result.message
       $('#error-div').html(result.message)
      })
      
        // Continue the form submit
    // e.currentTarget.submit();
    })
  </script>

        {{-- phyto hop signin --}}
 
  <script>
    $('#phytohodapproveform').submit(function(e){
      
        e.preventDefault();
        console.log('attempted to submit form')
        
        var _token = $('#_token').val()
        var useremail = $('#useremail').val()
        var userpin = $('#userpin').val()
    
      var data = {
      'email' : useremail,
      'pin' : userpin,
      '_token': _token
      }
      
      var form = $(this);
      var url = form.attr('sign-user-url');
      // var url2 = form.attr('action')
      $.post(url, data, function(result){
      console.log(result)
    
      if (result.status === true)
      {
        $('#adminid').val(result.admin);
      
        e.currentTarget.submit();
      }
    
      // display the error message some where on the page with result.message
      $('#error-div').html(result.message)
      })
      
    // Continue the form submit
    // e.currentTarget.submit();
    })

 </script>

<script>
  $('#pharmhodfinalapproveform').submit(function(e){
    
      e.preventDefault();
      console.log('attempted to submit form')
      
      var _token = $('#_token').val()
      var useremail = $('#useremail').val()
      var userpin = $('#userpin').val()
  
    var data = {
    'email' : useremail,
    'pin' : userpin,
    '_token': _token
    }
    
    var form = $(this);
    var url = form.attr('sign-user-url');
    var url2 = form.attr('action')
    $.post(url, data, function(result){
    console.log(result)
  
    if (result.status === true)
    {
      $('#adminid').val(result.admin);
      
      e.currentTarget.submit();
    }
  
      // display the error message some where on the page with result.message
    $('#error-div').html(result.message)
    })
    
      // Continue the form submit
  // e.currentTarget.submit();
  })
 </script>

<script>


  $("#pharmproduct_id").change(function() {
    var product_ma = $('option:selected', this).attr('product_ma');
   
    console.log(product_ma);
    if (product_ma == 2) {
      $("." + 'methodapplied').find('option[value="6"]').attr("selected",true);
    }
    else{
      $("." + 'methodapplied').find('option[value="6"]').attr("selected",false);
    }
  })
  
</script>


<script>

  $("#micro_la_conclution_option").change(function() {
    var tag = $('option:selected', this).attr('tag');
   
    console.log(tag);
    if (tag == 1) {
      $("#flexRadioDefault1").prop("checked", true);
    }
    if (tag == 2) {
      $("#flexRadioDefault2").prop("checked", true);
    }
  })
  
</script>
<script>
   $("#micro_ea_comment_option").change(function() {
    var tag2 = $('option:selected', this).attr('tag2');
   
    console.log(tag2);
    if (tag2 == 1) {
      $("#flexRadioDefault_1").prop("checked", true);
    }
    if (tag2 == 2) {
      $("#flexRadioDefault_2").prop("checked", true);
    }
  })
</script>





    