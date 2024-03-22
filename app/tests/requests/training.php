<?php

use Beupsoft\Fenix\App\Training\TrainingService;

try {
    $trainingId = 1240;

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
