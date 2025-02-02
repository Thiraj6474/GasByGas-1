<form action="pay_gas.php" method="POST" id="pay_gas"> 
  <input type="hidden" name="request_id" value="<?= $_GET['request_id'] ?>" />
  <div class="modal-header">
    <h5 class="modal-title" id="payModalLabel">Pay the Gas sent to your store</h5>
    <!-- <button class="close" type="button" data-dismiss="modal" aria-label="Close"> -->
      <span aria-hidden="true">×</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="p-3">

      <div class="form-group" id="out_put"></div>
      <div class="form-group">
        <label for="exampleInputEmail1">Tel. Number</label>
        <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Please enter phone with enough balance" name="phone_number">
      </div>
      <!-- <div class="form-group">
        <label for="exampleInputPassword1">Pin</label>
        <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Pin..." name="pin_number">
      </div> -->
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-primary" id="login_button">Pay Now</button>
  </div>
</form>

<script type="text/javascript">
  $(document).ready(function(){
    $("#pay_gas").submit(function(e){
      e.preventDefault();

      var oldData = $("#login_button").html();
        $("#login_button").html('<i class="fas fa-sync fa-spin"></i> Sending Request...');
        $("#login_button").attr("disabled", "disabled");

        $("#login_progess").hide();
      $("#out_put").html("");

      $.ajax({
          type: $(this).attr('method'),
          url: $(this).attr('action'),  
          data: $(this).serialize(),
          success: function(response){
              console.log(response.success);
              if(response.success){
                  // $("#request_operation_modal").modal("hide");
                  $("#out_put").html();
                  $("#out_put").html("<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>" + response.message + "</strong></div>");
              } else {
                  if(response.message){
                    $("#out_put").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert'>&times;</button><strong>" + response.message + "</strong></div>");
                  } else {
                    $("#out_put").html("<div class='alert alert-danger'><button class='close' data-dismiss='alert'>&times;</button><strong>Invalid Response from the server</strong></div>");
                  }
              }

              $("#login_button").html(oldData);
              $("#login_button").removeAttr("disabled");
          },
          error: function(error){
              $("#login_button").html(oldData);
              $("#login_button").removeAttr("disabled");
              
              $("#login_progess").html(error);
          }
      });
    });
  });
</script>