<?php

namespace App\Http\Livewire;

use App\Models\Feedback;
use Livewire\Component;

class ContactForm extends Component
{
    public string $theme = 'default';

    public $name;

    public $email;

    public $text;

    public bool $submitted = false;

    protected array $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email',
        'text' => 'required|max:4000',
    ];

    public function send()
    {
        $this->validate();

        Feedback::create([
            'name' => $this->name,
            'email' => $this->email,
            'text' => $this->text,
        ]);

        $this->submitted = true;
    }
}
