<script>
	jQuery('document').ready(function () {
      jQuery('#form_posting').submit(function(e) {
        jQuery.ajax({
          type: jQuery(this).attr('method'),
          url: '/post-to-vk.php',
          data: jQuery(this).serialize(),
          async: true,
          dataType: "html",
          complete: function(result){
            alert(result);
          }
        }).done(function() {
          console.log('success');
        }).fail(function() {
          console.log('fail');
        });
      });
    });
</script>
</body>
</html>