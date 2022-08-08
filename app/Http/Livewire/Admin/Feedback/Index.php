<?php

namespace App\Http\Livewire\Admin\Feedback;

use App\Http\Livewire\Admin\Base\BaseComponent;
use App\Models\Feedback;

class Index extends BaseComponent
{
    protected $listeners = ['onDelete'];

    public function onDelete($params)
    {
        Feedback::findOrFail($params['id'])->delete();
        return redirect()->to($params['_return'] ?: route( 'admin.feedback.index'));
    }
}
