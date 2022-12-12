<?php if ($role == '1') : ?>
    <?= $this->include('pages/officerDashboard'); ?>
<?php elseif ($role == '2') : ?>
     <?= $this->include('pages/Manager/managerDashboard'); ?>
<?php elseif ($role == '3' || $role == '7') : ?>
     <?= $this->include('pages/Dts/dtsDashboard'); ?>
<?php endif; ?>