<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DashBoardCardsService;

class HomeController extends Controller
{
    protected $dashBoardCardsService;

    public function __construct(DashBoardCardsService $dashBoardCardsService)
    {
        $this->dashBoardCardsService = $dashBoardCardsService;
    }



    public function index()
    {
       $income =  $this->dashBoardCardsService->income();

        return view('admin.index', ['income' => $income]);
    }
}