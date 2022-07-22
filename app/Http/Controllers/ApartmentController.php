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

    public function index($path = null): View
    {
        $category = $path ? $this->apartmentRepository->findCategory($path) : null;
        $subCategories = $this->apartmentRepository->getCategories($category);

        if ($category) {
            $breadcrumbs[] = ['name' => __('app.apartments.title'), 'url' => route('apartment.index')];
            $pageTitle = $category->name;
            $pageDescription = nl2br($category->description);
            foreach ($category->getAncestors() as $node) {
                $breadcrumbs[] = ['name' => $node->name, 'url' => $node->getLink()];
            }
        } else {
            $pageTitle = __('app.apartments.title');
            $pageDescription = __('app.apartments.description');
        }
        $breadcrumbs[] = ['name' => $pageTitle];
        view()->share('breadcrumbs', $breadcrumbs);

        if ($subCategories->isNotEmpty()) {
            return view('apartment.categories',
                compact('category', 'subCategories', 'pageTitle', 'pageDescription'));
        }
        $apartments = $this->apartmentRepository->getApartments($category);
        return view('apartment.list',
            compact('category', 'apartments', 'pageTitle', 'pageDescription'));
    }

    public function show($path, $alias): View
    {
        $apartment = $this->apartmentRepository->findApartment($path, $alias);
        $category = $apartment->category;
        $pageTitle = $apartment->name;
        $pageDescription = $apartment->description;
        $breadcrumbs[] = ['name' => __('app.apartments.title'), 'url' => route('apartment.index')];
        foreach ($category->breadcrumbs() as $node) {
            $breadcrumbs[] = ['name' => $node->name, 'url' => $node->getLink()];
        }
        $breadcrumbs[] = ['name' => $pageTitle];
        view()->share('breadcrumbs', $breadcrumbs);
        return view('apartment.show', compact('apartment', 'category', 'pageTitle', 'pageDescription'));
    }
}
