<!DOCTYPE html>
<html lang="en">
<head>
    <title>iSosial</title>
</head>
<body>
    <ul>
        <?php foreach($kegiatan as $arsip) : ?>
            <li><?= $arsip->kegiatanapa ?> (<?= $arsip->tanggal ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>