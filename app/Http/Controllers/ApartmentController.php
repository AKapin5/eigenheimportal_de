<?php

namespace App\Http\Controllers;

use App\Repositories\ApartmentRepository;
use Illuminate\Contracts\View\View;

class ApartmentController extends Controller
{
    protected ApartmentRepository $apartmentRepository;

    public function __construct(ApartmentRepository $apartmentRepository)
    {
        $this->apartmentRepository = $apartmentRepository;
    }

    public function index(): View
    {
        return view('apartment.index');
    }

    public function category($path): View
    {
        return view('apartment.category');
    }

    public function show($path, $alias): View
    {
        return view('apartment.show');
    }
}
