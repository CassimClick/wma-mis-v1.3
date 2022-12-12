<?= $this->extend('layouts/base'); ?>
<?= $this->section('content'); ?>
<div class="container">
  
    <div class="error">
        <h3>404</h3>
        <a href="<?=base_url()?>" class="btn-primary btn-lg">Home</a>
    </div>
</div>
<?= $this->endSection(); ?>