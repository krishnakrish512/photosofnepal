<div class="wrap">
    <h2>Next Gen Image Plugin</h2>
    <p>Total number of cache images (<?=$totalCacheFiles?>)</p>
    <?php
    if($message){
        echo <<<EOF
            <div style="background-color: #0b90be; color:white; padding: 12px 16px; width: auto; display: inline-block">{$message}</div>
EOF;
    }
    ?>
    <p>
        <strong>Logs: <a href="?page=next-gen-image-log" >image logs</a> </strong>
    </p>
    <p>
        <strong>Logs: <a href="?page=next-gen-image&service=clear-log" >Delete image logs</a> </strong>
    </p>
    <p>
        <strong>Cache: <a href="?page=next-gen-image&service=clear">click here to clear all cache</a> </strong>
    </p>
</div>