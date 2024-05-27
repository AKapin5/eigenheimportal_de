<?php

namespace App\Http\Livewire;

use App\Models\ApartmentCategory;
use App\Repositories\ApartmentRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Apartments extends Component
{
    public ?string $template = null;

    public Collection $apartments;

    public ?ApartmentCategory $category = null;

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
            ->paginate(21, ['*'], 'page', $this->page);
        $this->hasMore = $newApartments->hasMorePages();
        $this->page++;
        $this->apartments->push(...$newApartments);
    }

    public function render()
    {
        if (!$this->template) {
            throw new Exception('Missing template for apartments list component.');
        }
        return view("livewire.apartment.list");
    }
}
