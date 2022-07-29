<?php

namespace App\Http\Controllers;

use App\Repositories\ApartmentRepository;
use App\Repositories\BlogRepository;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    protected ApartmentRepository $apartmentRepository;
    protected BlogRepository $blogRepository;

    public function __construct(ApartmentRepository $apartmentRepository, BlogRepository $blogRepository)
    {
        $this->apartmentRepository = $apartmentRepository;
        $this->blogRepository = $blogRepository;
    }

    public function home(): View
    {
        $topApartments = $this->apartmentRepository->getTop();
        $topBlogs = $this->blogRepository->getTop();
        view()->share('breadcrumbs', null);
        return view('pages.home', compact('topApartments', 'topBlogs'));
    }

    public function contact(): View
    {
        $pageTitle = __('app.contact.title');
        view()->share('breadcrumbs', [
            ['name' => $pageTitle],
        ]);
        view()->share('pageTitle', $pageTitle);
        return view('pages.contact', compact('pageTitle'));
    }
}
