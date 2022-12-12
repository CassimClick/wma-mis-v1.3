<?php $regions = ["Arusha", "Dar es Salaam", "Dodoma", "Iringa", "Kagera", "Kigoma", "Kilimanjaro", "Lindi", "Manyara", "Mara", "Mbeya", "Morogoro", "Mtwara", "Mwanza", "Pemba North", "Pemba South", "Pwani", "Rukwa", "Ruvuma", "Shinyanga", "Singida", "Tabora", "Tanga", "Zanzibar Central/South", "Zanzibar North", "Zanzibar Urban/West"]; ?>

<div class="form-group">
    <label for="">Region</label>
    <select class="form-control select2" name="region" id="region" required style="width:100%">
        <?php foreach ($regions as $region) : ?>
            <option value="<?= $region ?>"><?= $region ?></option>
        <?php endforeach; ?>
    </select>
</div>