<?php
$ok = \App\Core\Session::flash('flash_ok');
$err = \App\Core\Session::flash('flash_err');
?>
<?php if ($ok): ?><div class="flash flash--ok"><?= e($ok) ?></div><?php endif; ?>
<?php if ($err): ?><div class="flash flash--err"><?= e($err) ?></div><?php endif; ?>
