<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<?php searched_ca()?>

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
       $('#excitons').val(pt);
    });

    // Update 10 points to excitons
    $('#neg_10_grav').click(function(){
       var pt = $('#gravitons').val();
       pt = Number(pt);
        pt = pt - 10;
       $('#gravitons').val(pt);
    });

  });
</script>




<?php include('includes/footer.php') ?>	