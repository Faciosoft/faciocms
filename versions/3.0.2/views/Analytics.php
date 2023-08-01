<?php
    function Prefix($num) {
        return $num <= 9 ? "0$num" : $num;
    }

    function GetMonthDays($month, $year) {
        if($month === 1 || $month === 3 || $month === 5 || $month === 7 || $month === 8 || $month === 10 || $month === 12) return 31;
        if($month === 4 || $month === 6 || $month === 9 || $month === 11) return 30;

        return $year % 4 === 0 ? 29 : 28;
    }

    function GetViewCountInOffsetDays($offset, $data) {
        $year   = intval(date('Y'));
        $month  = intval(date('m'));
        $day    = intval(date('d'));
        $count = 0;
        
        for($i = 0; $i < $offset; $i++) {
            $format = Prefix($year) . '-' . Prefix($month) . '-' . Prefix($day);
            $count += count($data->{$format} ?? []);

            $day--;
            if($day <= 0) {
                $month --;

                if($month > 12) {
                    $year --;
                    $month = 0;
                }

                $day = GetMonthDays($month, $year);
            }

        }

        return $count;
    }

    // Views
    $date_ymd = date('Y-m-d');
    $data_txt = file_get_contents("../temp/performance/entries.json");
    $data = json_decode($data_txt);

    $views_today = count($data->{$date_ymd} ?? []);
    $views_last_7days = GetViewCountInOffsetDays(7, $data);
    $views_last_month = GetViewCountInOffsetDays(28, $data);

    $yesterday = GetViewCountInOffsetDays(2, $data) - $views_today;
    $previous_7days = GetViewCountInOffsetDays(14, $data) - $views_last_7days;
    $previous_month = GetViewCountInOffsetDays(56, $data) - $views_last_month;    

    // Weight
    $size = filesize("../temp/performance/entries.json");
?>

<div class="analytics">
    <h1>Analytics</h1>

    <div class="admin-panel">
        <div class="info-box">
            <h4 class="info-box__title"> <em class="fas fa-eye"></em> <?php $cms->PrintTranslate('Views_Today'); ?> </h4>
            <p class="info-box__desc">
                <?php $cms->PrintTranslate('txt_16') ?>
            </p>

            <span class="info-box__value">
                <?php echo $views_today; ?> <span class="than-previous" title="<?php $cms->PrintTranslate('Than_Previous_Period'); ?>">(+<?php echo $yesterday; ?>)</span> 
            </span>
        </div>

        <div class="info-box">
            <h4 class="info-box__title"> <em class="fas fa-eye"></em> <?php $cms->PrintTranslate('Views_Last_7_Days'); ?> </h4>
            <p class="info-box__desc">
                <?php $cms->PrintTranslate('txt_22') ?>   
            </p>

            <span class="info-box__value">
                <?php echo $views_last_month; ?> <span class="than-previous" title="<?php $cms->PrintTranslate('Than_Previous_Period'); ?>">(+<?php echo $previous_7days; ?>)</span> 
            </span>
        </div>

        <div class="info-box">
            <h4 class="info-box__title"> <em class="fas fa-eye"></em> <?php $cms->PrintTranslate('Views_Last_Month'); ?> </h4>
            <p class="info-box__desc">
                <?php $cms->PrintTranslate('txt_21') ?>   
            </p>

            <span class="info-box__value">
                <?php echo $views_last_month; ?> <span class="than-previous" title="<?php $cms->PrintTranslate('Than_Previous_Period'); ?>">(+<?php echo $previous_month; ?>)</span> 
            </span>
        </div>
    </div>

    <div id="analytics-container">
        
    </div>
</div>