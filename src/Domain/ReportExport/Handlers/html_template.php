<?php

declare(strict_types=1);

/**
 * @var array $headers
 * @var array $rows
 */

?>

<div class="container">
    <table class="table">
        <thead>
        <tr>
            <?php foreach ($headers as $header) : ?>
                <th scope="col"><?= $header ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($rows as $row) : ?>
            <tr>
                <?php foreach ($row as $column) : ?>
                    <td><?= $column ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
