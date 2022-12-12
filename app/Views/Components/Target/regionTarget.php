<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">REGIONAL COLLECTION TARGET</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form id="targetForm" name="targeForm">
            <div class="row">

                <div class="form-group col-md-6">
                    <label for="my-input">Month</label>
                    <select name="targetMonth" class="form-control select2bs4" required>
                        <!-- <option value="0">All Months</option> -->
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="my-select">Year</label>
                        <select name="targetYear" class="form-control" required>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                        </select>
                    </div>
                </div>


                <div class="form-group col-md-12">
                    <label for="my-input">Region</label>
                    <select name="targetRegion" class="form-control select2bs4" required>

                        <?php foreach (renderRegions() as $region) : ?>
                            <option value="<?= $region['region'] ?>"><?= $region['region'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="card col-md-12">

                    <div class="card-header">VTV</div>
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="my-input">VTV Instruments</label>
                                <input name="vtc" class="form-control" type="number" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="my-input">VTV Amount</label>
                                <input name="vtcAmt" class="form-control" type="number" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-12">

                    <div class="card-header">SBL</div>
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="my-input">SBL Instruments</label>
                                <input name="sbl" class="form-control" type="number" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="my-input">VTV Amount</label>
                                <input name="sblAmt" class="form-control" type="number" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-12">

                    <div class="card-header">Water Meters</div>
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="my-input">Water Meters </label>
                                <input name="waterMeter" class="form-control" type="number" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="my-input">Water Meters Amount</label>
                                <input name="waterMeterAmt" class="form-control" type="number" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>



            </div>



            <div class="modal-footer">
                <button type="submit" id="regionalTarget" class="btn btn-primary btn-sm">Save</button>
            </div>
        </form>
    </div>
</div>