<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ExampleController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('index');
    }

    /**
     * @return JsonResponse
     */
    public function masterData(): \Illuminate\Http\JsonResponse
    {
        $jsonData = $this->readJsonFile();

        return $this->sendSuccessResponse($jsonData);
    }


    /**
     * @return mixed
     */
    public function readJsonFile(): mixed
    {
        $jsonString = file_get_contents(storage_path('dishes.json'));

        return json_decode($jsonString, true);
    }
}
