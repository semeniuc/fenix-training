<?php

use Beupsoft\Fenix\App\Service\TrainingService;

try {
    $trainingId = 4;

    $response = new TrainingService($trainingId);

} catch (Throwable $th) {
    $response = [
        'code' => $th->getCode(),
        'message' => $th->getMessage(),
        'file' => $th->getFile(),
        'line' => $th->getLine(),
    ];
} finally {
    dd($response);
}
