<?= $this->include('ServiceApplication/Layout/TheHeader.php'); ?>
<!-- /.navbar -->
<!-- Main Side menu Container -->
<div class="page-container">
    <?= $this->include('ServiceApplication/Layout/ServiceMenu.php'); ?>
    <!-- start page content -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <div class="page-title-breadcrumb">
                    <div class="pull-left">
                        <!-- <div class="page-title"><?=$page->heading ?></div> -->
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?=base_url('service-request/dashboard')?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li class="active"><?=$page->heading ?></li>
                    </ol>
                </div>
            </div>
            
            
            <?= $this->renderSection('content'); ?>
         
            <!-- end Payment Details -->
            
        </div>
    </div>
    <!-- end page content -->

</div>



<?= $this->include('ServiceApplication/Layout/TheFooter.php'); ?>