<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>/dashboard" class="brand-link">

        <span class="brand-text font-weight-bold ml-3"> WMA-MIS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar child-indent flex-column" data-widget="treeview" role="menu"
                data-accordion="true">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <!-- entire link open -->
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <?php if ($profile->avatar) : ?>
                        <img src="<?= $profile->avatar ?>" class="img-circle elevation-1" alt="User Image" width="28">
                        <?php else : ?>
                        <img src="<?= base_url() ?>/assets/images/avatar.png" class="img-circle elevation-1"
                            alt="User Image" width="28">
                        <?php endif; ?>
                        <p>
                            <?= $profile->first_name . ' ' . $profile->last_name ?>
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/changePassword" class="nav-link">
                                <i class="fal fa-key nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/profile" class="nav-link">
                                <!-- <i class="fal fa-list-alt nav-icon"></i> -->
                                <i class="fal fa-user nav-icon"></i>
                                <p>My Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/logout" class="nav-link">
                                <!-- <i class="fal fa-list-alt nav-icon"></i> -->
                                <i class="fal fa-sign-out-alt nav-icon"></i>
                                <p>Log Out</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/dashboard" class="nav-link ">
                        <i class="fal fa-tachometer-alt nav-icon"></i>
                        <!-- <ion-icon class="nav-icon" name="speedometer-outline"></ion-icon> -->
                        <p>
                            Dashboard

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/searchOfficer" class="nav-link ">
                        <i class="fal fa-search nav-icon"></i>
                        <!-- <ion-icon class="nav-icon" name="speedometer-outline"></ion-icon> -->
                        <p>
                            Search

                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="<?=base_url()?>/reports" class="nav-link ">
                        <i class="fal fa-file-chart-pie nav-icon"></i>
                        <p>
                            Reports
                            <!-- <i class="right fal fa-angle-left"></i> -->
                        </p>
                    </a>

                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="fal fa-balance-scale nav-icon"></i>
                        <p>
                            Scale Inspection
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/newScale" class="nav-link">
                                <i class="fal fa-plus nav-icon"></i>
                                <p>Add New Scale</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/listScales" class="nav-link">
                                <!-- <i class="fal fa-list-alt nav-icon"></i> -->
                                <i class="fal fa-clipboard-list-check nav-icon"></i>
                                <p>View Registered Scales</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- entire link closed -->
                <!-- entire link open -->
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fal fa-gas-pump nav-icon"></i>
                        <p>
                            Fuel Pump Inspection
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/newPump" class="nav-link">
                                <i class="fal fa-plus nav-icon"></i>
                                <p>Add New Pump</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/listFuelPumps" class="nav-link">
                                <!-- <i class="fal fa-list nav-icon"></i> -->
                                <i class="fal fa-clipboard-list-check nav-icon"></i>
                                <p>View Registered Pumps</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- entire link closed -->



                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fal fa-box-full nav-icon"></i>
                        <p>
                            Pre Packages Inspection
                            <i class="right fal fa-angle-left"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/newIndustrialPackage" class="nav-link">
                                <i class="fal fa-plus nav-icon"></i>
                                <p>Add New Package</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/listIndustrialPackages" class="nav-link">
                                <!-- <i class="fal fa-list nav-icon"></i> -->
                                <i class="fal fa-clipboard-list-check nav-icon"></i>
                                <p>View Registered Packages</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fal fa-truck-container nav-icon"></i>
                        <p>
                            Vehicle Tank Verification
                            <i class="right fal fa-angle-left"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/addVehicleTank" class="nav-link">
                                <i class="fal fa-plus nav-icon"></i>
                                <p>Add Vehicle Tank</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/listVehicleTanks" class="nav-link">
                                <!-- <i class="fal fa-list nav-icon"></i> -->
                                <i class="fal fa-clipboard-list-check nav-icon"></i>
                                <p>View Registered Tanks</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fal fa-truck nav-icon"></i>
                        <p>
                            Sandy & Ballast Lorries
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/addLorry" class="nav-link">
                                <i class="fal fa-plus nav-icon"></i>
                                <p>Add Lorry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/listLorries" class="nav-link">
                                <i class="fal fa-clipboard-list-check nav-icon"></i>
                                <p>Registered Lorries</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fal fa-database nav-icon"></i>
                        <p>
                            Bulk Storage Tanks
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/addBulkStorageTank" class="nav-link">
                                <i class="fal fa-plus nav-icon"></i>
                                <p>Add Bulk Storage Tank</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/listBulkStorageTanks" class="nav-link">
                                <i class="fal fa-clipboard-list-check nav-icon"></i>
                                <p>View Bulk Storage Tanks</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fal fa-container-storage nav-icon"></i>
                        <p>
                            Fixed Storage Tanks
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/addFixedStorageTank" class="nav-link">
                                <i class="fal fa-plus nav-icon"></i>
                                <p>Add Fixed Tank</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/listFixedStorageTanks" class="nav-link">
                                <i class="fal fa-clipboard-list-check nav-icon"></i>
                                <p>Registered Fixed Tanks</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fal fa-bullseye nav-icon"></i>
                        <p>
                            Flow Meter
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/addFlowMeter" class="nav-link">
                                <i class="fal fa-plus nav-icon"></i>
                                <p>Add flow Meter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/FlowMeterList" class="nav-link">
                                <i class="fal fa-clipboard-list-check nav-icon"></i>
                                <p>Registered Flow Meters</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fal fa-ring nav-icon"></i>
                        <p>
                            Water Meter
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/addWaterMeter" class="nav-link">
                                <i class="fal fa-plus nav-icon"></i>
                                <p>Add Water Meter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/WaterMeterList" class="nav-link">
                                <i class="fal fa-clipboard-list-check nav-icon"></i>
                                <p>Registered Water Meters</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fal fa-ship nav-icon"></i>
                        <p>
                            Meterological Supervision
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fal fa-ship nav-icon"></i>
                                <p>
                                    OnBoard
                                    <i class="right fal fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/timeLog" class="nav-link">
                                        <i class="fal fa-clock nav-icon"></i>
                                        <p>Time Log</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/documents" class="nav-link">
                                        <i class="fal fa-file-alt nav-icon"></i>
                                        <p>Documents</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/ullageBeforeDischarging" class="nav-link">
                                        <i class="fal fa-file-alt nav-icon"></i>
                                        <p>Ullage Before Discharging</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/ullageAfterDischarging" class="nav-link">
                                        <i class="fal fa-file-alt nav-icon"></i>
                                        <p>Ullage After Discharging</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/petroleum" class="nav-link">
                                        <i class="fal fa-gas-pump nav-icon"></i>
                                        <p>Petroleum</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/certificateOfQuantity" class="nav-link">
                                        <i class="fal fa-file-alt nav-icon"></i>
                                        <p>Certificate Of Quantity</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/noteOfFactBeforeDischarging" class="nav-link">
                                        <i class="fal fa-file-alt nav-icon"></i>
                                        <p>Note Of Fact Before</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/edibleOil" class="nav-link">
                                        <i class="fal fa-burn nav-icon"></i>
                                        <p>Edible Oil</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/LPG" class="nav-link">
                                        <i class="fal fa-gas-pump nav-icon"></i>
                                        <p>LPG</p>
                                    </a>
                                </li>



                            </ul>

                        </li>

                    </ul>



                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>