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
{{-- <script src="{{asset('admin/assets/src/js/vendor/jquery-3.3.1.min.js')}}"></script> --}}

<script src="{{asset('admin/assets/js/form-advanced.js')}}"></script>
<script src="{{asset('admin/bower_components/select2/dist/js/select2.full.min.js')}}"></script>



<script>
$("#microproduct_id").change(function() {
  var producttype = $('option:selected', this).attr('datatype');
  console.log(producttype);
  if (producttype === '9') {
    $('#expresult-1').val('5.0 x 10^7')
    $('#expresult-2').val('5.0 x 10^5')

  }else{
    $('#expresult-1').val('5.0 x 10^4')
    $('#expresult-2').val('5.0 x 10^2')
  }
   
})
</script>
<!-- show form when checked -->
 <script type="text/javascript">
  $(document).ready(function() {
      $('input[id="inlineCheckbox1"]').click(function() {
          var inputValue = $(this).attr("value");
          $("." + inputValue).toggle();
      });
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



  <!-- checkusermicro-->
<script>
$('#acceptmicroproductform').submit(function(e){
  
    e.preventDefault();
    console.log('attempted to submit form')
    
    var _token = $('#_token').val()
    var useremail = $('#useremail').val()
    var userpassword = $('#userpassword').val()

  var data = {
  'email' : useremail,
  'password' : userpassword,
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

   <!-- checkuserpharm-->
<script>
$('#acceptpharmproductform').submit(function(e){
  
    e.preventDefault();
    console.log('attempted to submit form')
    
    var _token = $('#_token').val()
    var useremail = $('#useremail').val()
    var userpassword = $('#userpassword').val()

  var data = {
  'email' : useremail,
  'password' : userpassword,
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

<!-- checkuserphyto-->
<script>
  $('#acceptphytoproductform').submit(function(e){
    
      e.preventDefault();
      console.log('attempted to submit form')
      
      var _token = $('#_token').val()
      var useremail = $('#useremail').val()
      var userpassword = $('#userpassword').val()
  
    var data = {
    'email' : useremail,
    'password' : userpassword,
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
  })
  </script>