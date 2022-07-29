<?php

namespace App\Http\Livewire;

use App\Interfaces\HasComments;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Comments extends Component
{
    public HasComments $entity;

    public Collection $comments;

    public int $page = 1;

    public bool $hasMore = false;

    public bool $submitted = false;

    public $name;

    public $text;

    protected array $rules = [
        'name' => 'required|min:2|max:255',
        'text' => 'required|max:4000',
    ];

    public function mount()
    {
        $this->comments = new Collection();
        $this->loadItems();
    }

    public function add()
    {
        $this->validate();
        $newComment = $this->entity->comments()->create([
            'name' => $this->name,
            'text' => $this->text,
            'entity_class' => get_class($this->entity),
        ]);
        $this->comments->push($newComment);
        $this->clearForm();
        $this->submitted = true;
    }

    public function loadItems()
    {
        $newComments = $this->entity->comments()->paginate(20, ['*'], 'page', $this->page);
        $this->hasMore = $newComments->hasMorePages();
        $this->page++;
        $this->comments->push(...$newComments);
    }

    protected function clearForm()
    {
        $this->name = '';
        $this->text = '';
    }
}
