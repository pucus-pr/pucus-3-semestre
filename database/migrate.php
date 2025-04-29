<?php

use App\Models\Model;

require_once __DIR__ . '/../app/Models/Model.php';

$migrationPath = __DIR__ . '/migrations';

foreach(glob("$migrationPath/*.php") as $migrationFile) {
    require $migrationFile;
    Model::query($sql, []);
}
