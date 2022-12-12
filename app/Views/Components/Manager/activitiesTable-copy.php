<div class="card card-primary ">
    <div class="card-header">
        <h3 class="card-title">Tasks And Groups</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>

        </div>
    </div>
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Activities</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>

                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>

                            <th>
                                Activity
                            </th>
                            <th>
                                Group Members
                            </th>
                            <th>
                                Group Name
                            </th>


                        </tr>
                    </thead>
                    <tbody>

                        <?php



                        function group_by($key, $activities)
                        {
                            $result = array();

                            foreach ($activities as $val) {
                                if (array_key_exists($key, $val)) {
                                    $result[$val[$key]][] = $val;
                                } else {
                                    $result[""][] = $val;
                                }
                            }

                            return $result;
                        }

                        $byGroup = group_by("activity", $activities);


                        ?>
                        </pre>
                        <?php foreach ($byGroup as $activity) : ?>

                        <tr>
                            <td>
                                <a>


                                    <?php foreach ($activity as $item) : ?>
                                    <?php endforeach; ?>
                                    <?= $item['activity'] ?>

                                </a>
                                <br />
                                <small>
                                    Created : <b><?= dateFormatter($item['created_at']) ?></b>
                                </small>
                            </td>
                            <td>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <?php foreach ($activity as $item) : ?>
                                        <?php if ($item['avatar']) : ?>
                                        <img alt="Avatar" class="table-avatar" src="<?= $item['avatar'] ?>">
                                        <?php else : ?>
                                        <img alt="Avatar" class="table-avatar"
                                            src="<?= base_url() ?>/assets/images/avatar.png">
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </li>

                                </ul>
                            </td>

                            <td>
                                <?= $item['the_group'] ?>
                            </td>
                        </tr>

                        <?php endforeach; ?>



                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.card-body -->
</div>