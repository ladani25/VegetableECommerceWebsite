<footer class="footer">
    <div class="footer__block block no-margin-bottom">
      <div class="container-fluid text-center">
        <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
         <p class="no-margin-bottom">2018 © Your company. Download From <a target="_blank" href="https://templateshub.net">Templates Hub</a>.</p>
      </div>
    </div>
  </footer>

  <script src="{{url('admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{url('admin/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{url('admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{url('admin/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{url('admin/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{url('admin/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{url('admin/js/charts-home.js')}}"></script>
    <script src="{{url('admin/js/front.j')}}s"></script>


    {{-- <script>
      
      /*
Big Thanks To:
https://developer.mozilla.org/en-US/docs/Rich-Text_Editing_in_Mozilla#Executing_Commands
*/

$('#editControls a').click(function(e) {
  switch($(this).data('role')) {
    case 'h1':
    case 'h2':
    case 'p':
      document.execCommand('formatBlock', false, $(this).data('role'));
      break;
    default:
      document.execCommand($(this).data('role'), false, null);
      break;
    }
  update_output();
})

$('#editor').bind('blur keyup paste copy cut mouseup', function(e) {
  update_output();
})

function update_output() {
  $('#output').val($('#editor').html());
}


      
      </script> --}}
