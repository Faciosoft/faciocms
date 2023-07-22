<?php
    // Calculating average load time from last entries.
    $data_txt = file_get_contents("../temp/performance/loads.json");
    $data = json_decode($data_txt);

    $load_time_sum = 0;
    $size = 0;
    foreach($data as $key => $value) {
        foreach($value as $item) {
            $load_time_sum += $item;
            $size++;
        }
    }

    $average_load_time = $size > 0 ? round($load_time_sum / $size) : "No data! ";

    $has_supercaching = $cms->GetSetting("supercaching")->value == "true" && $cms->GetSetting("prod")->value == "true";
?>

<h1><?php $cms->PrintTranslate('Performance'); ?></h1>

<div class="admin-panel">
    <div class="info-box">
        <h4 class="info-box__title"> <em class="fas fa-tachometer-alt"></em> <?php $cms->PrintTranslate('Performance'); ?> </h4>
        <p class="info-box__desc">
            <?php $cms->PrintTranslate('txt_1') ?>. 
        </p>

        <span class="info-box__value">
            <?php echo $average_load_time; ?>ms
        </span>
    </div>
</div>

<span class="hr-line hr-light mt-5 mb-5"></span>

<div class="performance-testing">
    <?php if($has_supercaching): ?>
        <h3><?php $cms->PrintTranslate('Performance_With_Supercaching'); ?></h3>
    <?php else: ?>
        <PerformanceTestRun title="<?php $cms->PrintTranslate('Run_test'); ?>"></PerformanceTestRun>

        <span class="warning">
            <em class="fas fa-exclamation-triangle"></em>
            <span class="warning-text">
                <?php $cms->PrintTranslate('Warning') ?>: <?php $cms->PrintTranslate('Txt_2') ?>
            </span>
        </span>
    <?php endif; ?>
</div>

<span class="hr-line hr-light mt-5 mb-5"></span>

<h3><?php $cms->PrintTranslate('Documentation'); ?></h3>
<h4 class="gray"><?php $cms->PrintTranslate('Learn_more'); ?></h4>

documentation module is under development