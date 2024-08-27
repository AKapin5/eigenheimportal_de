<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryLinks;
use App\Repositories\ApartmentRepository;
use Illuminate\Contracts\View\View;

class ApartmentController extends Controller
{
    /**
     * @var ApartmentRepository
     */
    protected ApartmentRepository $apartmentRepository;

    /**
     * @var CategoryLinks
     */
    protected CategoryLinks $categoryLinks;

    /**
     * @param ApartmentRepository $apartmentRepository
     * @param CategoryLinks $categoryLinks
     */
    public function __construct(ApartmentRepository $apartmentRepository, CategoryLinks $categoryLinks)
    {
        $this->apartmentRepository = $apartmentRepository;
        $this->categoryLinks = $categoryLinks;
    }

    /**
     * @param $path
     * @return View
     */
    public function index($path = null): View
    {
        $category = $path ? $this->apartmentRepository->findCategory($path) : null;
        $subCategories = $this->apartmentRepository->getCategories($category)->get();

        if ($category) {
            $breadcrumbs[] = [
                'name' => __('app.apartments.title'),
                'url' => route('apartment.index'),
            ];
            $pageTitle = $category->name;
            $pageDescription = $category->description;
            foreach ($category->getAncestors() as $node) {
                $breadcrumbs[] = [
                    'name' => $node->name,
                    'url' => $node->getLink(),
                ];
            }
            view()->share('pageLinks', $category->getLinks());
        } else {
            $pageTitle = __('app.apartments.title');
            $pageDescription = __('app.apartments.description');
        }
        $breadcrumbs[] = ['name' => $pageTitle];
        view()->share('pageTitle', $pageTitle);
        view()->share('breadcrumbs', $breadcrumbs);

        $categoryLinks = $this->categoryLinks->buildMenu();
        return view('apartment.alternate.list',
            compact('category', 'subCategories', 'pageTitle', 'pageDescription', 'categoryLinks'));
    }

    /**
     * @return View
     */
    public function references(): View
    {
        $pageTitle =  __('app.apartments.references');
        $breadcrumbs[] = [
            'name' => __('app.apartments.title'),
            'url' => route('apartment.index'),
        ];

        $breadcrumbs[] = ['name' => $pageTitle];
        view()->share('pageTitle', $pageTitle);
        view()->share('breadcrumbs', $breadcrumbs);
        $apartments = $this->apartmentRepository->getReferences()
            ->get();
        return view('apartment.references',
            compact('apartments', 'pageTitle'));
    }

    /**
     * @param $path
     * @param $alias
     * @return View
     */
    public function show($path, $alias): View
    {
        $apartment = $this->apartmentRepository->findApartment($path, $alias);
        $category = $apartment->category;
        $breadcrumbs[] = [
            'name' => __('app.apartments.title'),
            'url' => route('apartment.index'),
        ];
        foreach ($category->breadcrumbs() as $node) {
            $breadcrumbs[] = [
                'name' => $node->name,
                'url' => $node->getLink(),
            ];
        }
        view()->share('pageLinks', $apartment->getLinks());
        view()->share('pageTitle', $apartment->name);
        $breadcrumbs[] = ['name' => $apartment->name];
        view()->share('breadcrumbs', $breadcrumbs);
        return view('apartment.show', compact('apartment', 'category'));
    }
}
