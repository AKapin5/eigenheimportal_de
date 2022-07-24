<?php

namespace App\Http\Controllers;

use App\Repositories\ApartmentRepository;
use App\Repositories\BlogRepository;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    protected ApartmentRepository $apartmentRepository;
    protected BlogRepository $blogRepository;

    public function __construct(ApartmentRepository $apartmentRepository, BlogRepository $blogRepository)
    {
        $this->apartmentRepository = $apartmentRepository;
        $this->blogRepository = $blogRepository;
    }

    public function index(): View
    {
        $topApartments = $this->apartmentRepository->getTop();
        $topBlogs = $this->blogRepository->getTop();
        view()->share('breadcrumbs', null);
        return view('pages.home', compact('topApartments', 'topBlogs'));
    }
}
