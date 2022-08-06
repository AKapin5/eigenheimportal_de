<?php

namespace App\Http\Livewire\Admin\Feedback;

use App\Models\Feedback;
use Livewire\Component;

class Delete extends Component
{
    public function mount(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->to(request('_return') ?: route( 'admin.feedback.index'));
    }
}
