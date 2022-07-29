<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
use Illuminate\Contracts\View\View;


class BlogController extends Controller
{
    /**
     * @var BlogRepository
     */
    protected BlogRepository $blogRepository;

    /**
     * @param BlogRepository $blogRepository
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @param null $category
     * @return View
     */
    public function index($category = null): View
    {
        $blogCategory = $category ? $this->blogRepository->findCategory($category) : null;

        if ($blogCategory) {
            $breadcrumbs[] = ['name' => __('app.blogs.title'), 'url' => route('blog.index')];
            $pageTitle = $blogCategory->name;
        } else {
            $pageTitle = __('app.blogs.title');
        }
        $breadcrumbs[] = ['name' => $pageTitle];
        view()->share('pageTitle', $pageTitle);
        $blogs = $this->blogRepository->getBlogs($blogCategory)->paginate();
        view()->share('breadcrumbs', $breadcrumbs);
        $categories = $this->blogRepository->getCategories()->get();
        return view('blog.list',
            compact('blogCategory', 'blogs', 'pageTitle', 'categories'));
    }

    /**
     * @param $category
     * @param $alias
     * @return View
     */
    public function show($category, $alias): View
    {
        $blog = $this->blogRepository->findBlog($category, $alias);
        $blogCategory = $blog->category;
        $breadcrumbs = [
            ['name' => __('app.blogs.title'), 'url' => route('blog.index')],
            ['name' => $blogCategory->name, 'url' => $blogCategory->getLink()],
            ['name' => $blog->name],
        ];
        view()->share('pageTitle', $blog->name);
        view()->share('breadcrumbs', $breadcrumbs);
        $categories = $this->blogRepository->getCategories()->get();
        return view('blog.show', compact('blog', 'blogCategory', 'categories'));
    }
}
