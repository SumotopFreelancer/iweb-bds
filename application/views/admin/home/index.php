<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content">
  <div class="margin-bottom">
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="msg"></div>
  </div>
  <div class="serviceRoot"><iframe src="https://dichvu.iweb247.com"></iframe></div>
</section>
<script>
  $(document).ready(function() {
    $.ajax({
      type: "post",
      url: "<?= admin_url('home/send_email_root') ?>",
      data: {
        type: 'x',
      },
      success: function(result) {
        console.log('x');
      }
    })
  });
</script>