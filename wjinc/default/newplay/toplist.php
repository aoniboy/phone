<?php
if ($this->result)
    foreach ($this->result as $key => $var) {
        ?>
        <li class="top_title clearfix f24">
            <span class="col666 qi_mal">第<span class="qishu2"><?= $var['number'] ?></span>期</span>
            <?= $var['tnumber'] ?>

            <span class="iconfont icon-xialajiantou fr qi_mar colc6c js_xia"></span>
        </li>
    <?php } ?>
