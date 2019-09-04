<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<?php $ca=searched_ca(); ?>
<?php ca_calls()?>

   <div class='row justify-content-md-center'>
      <br><br> <br><br>
         <form id='registrar-login-form' style='display: block;' method='post'>
         <br><br>
            <div class='form-group' style='width:300px'>
               <label for='email' id='celestaid_field' name='celestaid_field' value='<?php echo $ca['celestaid'] ?>'>CelestaID: <?php echo $ca['celestaid'] ?></label>
            </div>
            <div class='form-group'>
               <label for='email' id='name_field'>Name: <?php echo $ca['first_name'] ." ". $ca['last_name'] ?></label>
            </div>
            <div class='form-group'>
               <label for='email' id='phone_field'>Phone: <?php echo $ca['phone'] ?></label>
            </div>
            <div class='form-group'>
               <label for='email' id='college_field'>College: <?php echo $ca['college'] ?></label>
            </div>

            <div class='form-group'>
               <label for='email' >Excitons</label>
               <input type='text' readonly class='form-control' id='excitons' name='excitons' required value='<?php echo $ca['excitons'] ?>'>
            </div>
            <div class='form-group' style='margin-bottom:20px'>
               <label for='email'>Gravitons</label>
               <input type='text' readonly class='form-control' style='margin-bottom:20px' id='gravitons' name='gravitons' required value='<?php echo $ca['gravitons'] ?>'>
            </div>
            <input type='hidden' name='celestaid' id='celestaid' value='<?php echo $ca['celestaid'] ?>'>
            <span id='10_exc' name='10_exc' style='background:green; color:white; padding:15px'>+ 10 Excitons</span>
            <span id='neg_10_exc' name='neg_10_exc' style='background:red; color:white; padding:15px'>-10 Excitons</span>
            <span id='10_grav' name='10_grav' style='background:green; color:white; padding:15px'> + 10 Gravitons</span>
            <span id='neg_10_grav' name='neg_10_grav' style='background:red; color:white; padding:15px'> -10 Gravitons</span><br><br><br>
            <button type='submit' id='save_ca' name='save_ca' value='save_ca' class='btn btn-primary'>Save</button>
            <button type='submit' id='cancel_ca' name='cancel_ca' value='cancel_ca' class='btn btn-primary'>Cancel</button>
         </form>
      </div>

<script>
  $(document).ready(function(){
    // Update 10 points to excitons
    $('#10_exc').click(function(){
       var pt = $('#excitons').val();
       pt = Number(pt);
        pt = pt + 10;
       $('#excitons').val(pt);
    });

    // Update 10 points to excitons
    $('#10_grav').click(function(){
       var pt = $('#gravitons').val();
       pt = Number(pt);
        pt = pt + 10;
       $('#gravitons').val(pt);
    });

    // Update 10 points to excitons
    $('#neg_10_exc').click(function(){
       var pt = $('#excitons').val();
       pt = Number(pt);
        pt = pt - 10;
        if(pt>=0)
        $('#excitons').val(pt);
    });

    // Update 10 points to excitons
    $('#neg_10_grav').click(function(){
      var pt = $('#gravitons').val();
      pt = Number(pt);
      pt = pt - 10;
      if(pt>=0)
      $('#gravitons').val(pt);
    });

  });
</script>


<?php include('includes/footer.php') ?>	