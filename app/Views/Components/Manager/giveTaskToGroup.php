<div class="card card-primary ">
    <div class="card-header">
        <h3 class="card-title"><i class="fal fa-users icon"></i>Assign task to a group </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>

        </div>
    </div>
    <div class="card-body">
        <form id="taskForm">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Activity </label>

                    <select name="activity" class="form-control select2bs4 " required>
                        <option selected=" selected" disabled>Select a Activity</option>
                        <?php foreach ($activities as $activity) : ?>
                            <option <?= set_select('activity', $activity) ?> value="<?= $activity ?>"><?= $activity ?></option>
                        <?php endforeach; ?>
                    </select>


                </div>

                <?php
                $createdGroups = [];
                foreach ($groups as $group) {
                    array_push($createdGroups, $group['group_name']);
                }


                ?>




                <div class="form-group col-md-6">
                    <label>Select A Group</label>
                    <select name="group" class="form-control select2bs4 " required>
                        <option selected=" selected" disabled>Select a group</option>
                        <?php foreach (array_unique($createdGroups) as $userGroup) : ?>
                            <option value="<?= $userGroup ?>"><?= $userGroup ?></option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="form-group col-md-6">
                    <label for="my-select">City Or Region</label>
                    <select id="region" name="region" class="form-control select2bs4" >
                        <?php foreach (renderRegions() as $region) : ?>
                            <option value="<?= $region['region'] ?>"><?= $region['region'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="my-select">District</label>
                    <select id="district" name="district" class="form-control select2bs4" name="district">
                        <?php foreach (renderDistricts() as $district) : ?>
                            <option value="<?= $district['district'] ?>"><?= $district['district'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Ward</label>
                    <input class="form-control" type="text" name="ward" placeholder="Enter Ward" required />

                </div>
                <div class="form-group col-md-12">
                    <label>Task Description</label>
                    <div class="">
                        <textarea class="textarea" name="description" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">

                    </textarea>
                    </div>


                </div>
            </div>



            <div class="form-group ">

                <button type="submit" class="btn btn-primary btn-sm mt-3">Assign</button>
            </div>

        </form>
    </div>
    <br>

    <!-- /.card-body -->
</div>