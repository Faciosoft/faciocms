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

    // Views
    $date_ymd = date('Y-m-d');
    $data_txt = file_get_contents("../temp/performance/entries.json");
    $data = json_decode($data_txt);

    $views_today = count($data->{$date_ymd} ?? []);
?>

<h1 class="welcome-header"><?php $cms->PrintTranslate('Welcome'); ?>, <u><?php echo $cms->user["username"]; ?></u> <?php $cms->PrintTranslate('txt_3'); ?></h1>
<h3 class="welcome-subheader"><?php $cms->PrintTranslate('txt_4'); ?></h3>

<div class="admin-panel">
    <div class="info-box">
        <h4 class="info-box__title"> <em class="fas fa-tachometer-alt"></em> <?php $cms->PrintTranslate('Performance'); ?> </h4>
        <p class="info-box__desc">
            <?php $cms->PrintTranslate('txt_1') ?>. 
            <a class="cms-link" href="/admin/performance"><?php $cms->PrintTranslate('See_more'); ?> <em class="fas fa-arrow-right"></em></a>
        </p>

        <span class="info-box__value">
            <?php echo $average_load_time; ?>ms
        </span>
    </div>

    <div class="info-box">
        <h4 class="info-box__title"> <em class="fas fa-eye"></em> <?php $cms->PrintTranslate('Views_Today'); ?> </h4>
        <p class="info-box__desc">
            <?php $cms->PrintTranslate('txt_16') ?>
            <a class="cms-link" href="/admin/analytics/#!/views"><?php $cms->PrintTranslate('See_more'); ?> <em class="fas fa-arrow-right"></em></a>
        </p>

        <span class="info-box__value">
            <?php echo $views_today; ?>
        </span>
    </div>

    <div class="info-box">
        <h4 class="info-box__title"> <em class="fas fa-server"></em> <?php $cms->PrintTranslate('Disk_Usage'); ?> </h4>
        <p class="info-box__desc">
            <?php $cms->PrintTranslate('txt_17') ?>
            <br>
        </p>

        <span class="info-box__value pointer" id="disk-usage" data-memory="0" data-type="b">
            <?php $cms->PrintTranslate('Loading'); ?>...
        </span>
    </div>
</div>

<script>
    const types = { b: 1, kb: 1024, mb: 1024 * 1024, gb: 1024 * 1024 * 1024 };
    const types_list = ['kb','mb','gb'];

    fetch("/api/disk-usage")
        .then(res => res.text())
        .then(res => {
            const { result } = JSON.parse(res);
            const b = result;
            const kb = b / 1024;
            const mb = kb / 1024;
            const gb = mb / 1024;

            let text = '', type = 'b';

            if(gb >= 0.1) {
                text = new Intl.NumberFormat('fr-FR').format(parseFloat(gb.toFixed(2))) + ' GB';
                type = 'gb';
            }
            else if(mb >= 0.1) {
                text = new Intl.NumberFormat('fr-FR').format(parseFloat(mb.toFixed(2))) + ' MB';
                type = 'mb';
            }
            else if(kb >= 0.1) {
                text = new Intl.NumberFormat('fr-FR').format(parseFloat(kb.toFixed(2))) + ' KB';
                type = 'kb';
            }

            document.querySelector('#disk-usage').innerHTML = text;
            document.querySelector('#disk-usage').setAttribute('data-memory', b);
            document.querySelector('#disk-usage').setAttribute('data-type', type);

            setTimeout(() => {
                document.querySelector('#disk-usage').addEventListener('click', () => {
                    const current = document.querySelector('#disk-usage').getAttribute('data-type');
                    let index = 0;

                    types_list.forEach((t, i) => {
                        if(t == current) index = i;
                    });

                    index++;
                    index %= 3;

                    const newType = types_list[index];
                    const typeMutliplier = types[newType];
                    const usage = parseInt(document.querySelector('#disk-usage').getAttribute('data-memory') || 0);
                    const newUsage = parseFloat((usage / typeMutliplier).toFixed(2));
                    const suffix = newType.toUpperCase();

                    document.querySelector('#disk-usage').innerHTML = `${new Intl.NumberFormat('fr-FR').format(newUsage)} ${suffix}`;
                    document.querySelector('#disk-usage').setAttribute('data-type', newType);
                });
            }, 25)
        });
</script>