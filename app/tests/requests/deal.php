<?php



try {
    $dealId = 18;

    $deal = new \Beupsoft\Fenix\App\Service\DealService();
     $response = $deal->getDeal($dealId);
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
