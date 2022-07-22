<?php

namespace App\Http\Livewire;

use App\Models\ApartmentCategory;
use App\Repositories\ApartmentRepository;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Apartments extends Component
{
    public Collection $apartments;

    public ApartmentCategory $category;

    public int $page = 1;

    public bool $hasMore = false;

    protected ApartmentRepository $apartmentRepository;

    public function boot(ApartmentRepository $apartmentRepository)
    {
        $this->apartmentRepository = $apartmentRepository;
    }

    public function mount()
    {
        $this->apartments = new Collection();
        $this->loadItems();
    }

    public function loadItems()
    {
        $newApartments = $this->apartmentRepository->getApartments($this->category)
            ->paginate(3, ['*'], 'page', $this->page);
        $this->hasMore = $newApartments->hasMorePages();
        $this->page++;
        $this->apartments->push(...$newApartments);
    }

    public function render()
    {
        return view('livewire.apartments');
    }
}
