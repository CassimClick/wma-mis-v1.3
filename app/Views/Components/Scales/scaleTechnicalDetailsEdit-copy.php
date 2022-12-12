 <div class="form-group">
     <label>Type of Scale</label>
     <select name="scaletype" id="" class="form-control">
         <option selected <?= set_select('scaletype', $record->scale_type) ?> value="<?= $record->scale_type ?>">
             <?= $record->scale_type ?></option>

         <?php foreach (showOption([$record->scale_type], $scales) as $scale) : ?>
         <option value="<?= $scale ?>"><?= $scale ?></option>
         <?php endforeach; ?>


     </select>
     <span class="text-danger"><?= displayError($validation, 'scaletype') ?></span>
 </div>
 <div class="form-group">
     <label>Denomination Capacity For Scales </label>
     <select name="scalecapacity" id="capacity" class="form-control" value="<?= set_value('scalecapacity') ?>">

         <?php foreach ($denominations as $denomination) : ?>
         <option <?= set_select('scalecapacity', $denomination['capacity']) ?> value="<?= $denomination['price'] ?>">
             <?= $denomination['capacity'] ?>
         </option>
         <?php endforeach; ?>
     </select>
     <span class="text-danger"><?= displayError($validation, 'scalecapacity') ?></span>
 </div>
 <div class="form-group">
     <label>Weights For Scales </label>
     <select name="weights" id="weights" class="form-control">

         <option value="0">No Weights</option>
         <?php foreach ($weights as $weight) : ?>
         <option <?= set_select('scalecapacity', $weight['capacity']) ?> value="<?= $weight['price'] ?>">
             <?= $weight['capacity'] ?>
         </option>
         <?php endforeach; ?>
     </select>

 </div>
 <div class="form-group">
     <label>Koroboi</label>
     <select name="koroboi" id="koroboi" class="form-control" value="<?= set_value('koroboi') ?>">

         <option value="0">No Koroboi</option>
         <?php foreach ($korobois as $koroboi) : ?>
         <option <?= set_select('scalecapacity', $koroboi['capacity']) ?> value="<?= $koroboi['price'] ?>">
             <?= $koroboi['capacity'] ?>
         </option>
         <?php endforeach; ?>
     </select>
     <span class="text-danger"><?= displayError($validation, 'scalecapacity') ?></span>
 </div>
 <!-- Animated Form -->
 <div class="scale-result">
     <div class="card card-default">
         <div class="card-header">
             SCALE RESULTS
         </div>

         <?= $this->include('Widgets/ResultsEdit.php'); ?>
     </div>



 </div>