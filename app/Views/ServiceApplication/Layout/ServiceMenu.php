<!-- start sidebar menu -->
<div class="sidebar-container">
    <div class="sidemenu-container navbar-collapse collapse fixed-menu">
        <div id="remove-scroll">
            <ul class="sidemenu page-header-fixed p-t-20" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                </li>
                <li class="sidebar-user-panel">
                    <div class="user-panel">


                <!-- <li class="nav-item <?= url_is('service-request/dashboard') ? 'active' : '' ?>">
                    <a href="<?= base_url('service-request/dashboard') ?>" class="nav-link nav-toggle">

                        <i class="fa-solid fa-gauge"></i>
                        <span class="title">Dashboard</span>

                    </a>

                </li> -->


                <li class="nav-item">
                    <a href="#" class="nav-link nav-toggle">
                        <i class="fa-solid fa-briefcase"></i>
                        <span class="title">Services Applications</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="<?= base_url('service-request/service-application') ?>" class="nav-link nav-toggle">
                                <i class="fa-solid fa-square-poll-horizontal"></i>
                                <span class="title">Service Request</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('service-request/submitted-service-requests') ?>" class="nav-link nav-toggle">
                                <i class="fa-solid fa-list"></i>
                                <span class="title">Submitted Requests</span>
                            </a>
                        </li>




                    </ul>
                </li>
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link nav-toggle">
                        <i class="fas fa-file-signature"></i>
                        <span class="title">License Applications</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">





                    </ul>
                </li> -->

                <li class="nav-item  <?= 
                url_is('service-request/license-application') ||
                url_is('service-request/applicant-particulars') ||
                url_is('service-request/applicant-qualifications') ||
                url_is('service-request/license-type') ||
                url_is('service-request/tools') ||
                url_is('service-request/attachments') 
                
                ? 'active' : '' ?>">
                    <a href="<?= base_url('service-request/license-application') ?>" class="nav-link nav-toggle">
                        <i class="fas fa-file-signature"></i>

                        <span class="title">License Application</span>
                    </a>
                </li>


                <li class="nav-item start <?= url_is('service-request/submission') ? 'active' : '' ?>  ">
                    <a href="<?= base_url('service-request/submission') ?>" class="nav-link nav-toggle">

                        <i class="fas fa-paper-plane"></i>
                        <span class="title">Submit Application</span>

                    </a>

                </li>

                <li class="nav-item start <?= url_is('service-request/application-preview') ? 'active' : '' ?> ">
                    <a href="<?= base_url('service-request/application-preview') ?>" class="nav-link nav-toggle">

                        <i class="fas fa-eye"></i>
                        <span class="title">Application Preview </span>

                    </a>

                </li>




            </ul>
        </div>
    </div>
</div>
<!-- end sidebar menu -->