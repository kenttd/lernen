<?php

namespace App\Livewire\Pages\Admin\Payments;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Earnings extends Component
{
    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.payments.earnings');
    }
}
