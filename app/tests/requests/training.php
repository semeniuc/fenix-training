<?php

use Beupsoft\Fenix\App\Service\TrainingService;

try {
    $trainingId = 10;

    $training = new TrainingService();
     $response = $training->getTraining($trainingId);
//    $response = $training->handle($trainingId);

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
