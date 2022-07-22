<?php

namespace App\Http\Controllers;

use App\Repositories\ApartmentRepository;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    protected ApartmentRepository $apartmentRepository;

    public function __construct(ApartmentRepository $apartmentRepository)
    {
        $this->apartmentRepository = $apartmentRepository;
    }

    public function index(): View
    {
        $topApartments = $this->apartmentRepository->getTop();
        view()->share('breadcrumbs', null);
        return view('pages.home', compact('topApartments'));
    }
}
