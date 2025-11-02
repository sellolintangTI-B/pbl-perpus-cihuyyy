<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table class="border">
        <thead>
            <tr>
                <th>
                    Nama Ruangan
                </th>
                <th>
                    Deskripsi
                </th>
                <th>
                    Min
                </th>
                <th>
                    Max
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $value) : ?> 
            <tr>
                <td>
                    <?= $value->name ?>
                </td>
                <td>
                    <?= $value->description ?>
                </td>
                <td>
                    <?= $value->min_capacity ?>
                </td>
                <td>
                    <?= $value->max_capacity ?>
                </td>
                <td>
                    <a href="<?= URL ?>/user/room/details/<?= $value->id ?>">Details</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    
</body>
</html>