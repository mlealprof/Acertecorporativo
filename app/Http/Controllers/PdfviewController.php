<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfviewController extends Controller
{
    private $model;
    public function __construct(Stackoverflow $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $data['model'] = $this->model->all();
        return PDF::loadView('view', $data)
            ->stream();
    }
}
