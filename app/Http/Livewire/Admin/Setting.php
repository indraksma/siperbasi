<?php

namespace App\Http\Livewire\Admin;

use App\Models\SiteConfig;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Setting extends Component
{
    use LivewireAlert;
    public $whatsapp, $password, $email;
    public function mount()
    {
        $this->email = User::where('id', Auth::user()->id)->first()->email;
        $this->whatsapp = SiteConfig::where('option_type', 'whatsapp')->first()->option_value;
    }
    public function render()
    {
        return view('livewire.admin.setting');
    }

    public function store()
    {
        if ($this->password) {
            $user = User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($this->password),
            ]);
        }
        $site_config = SiteConfig::where('option_type', 'whatsapp')->update([
            'option_value' => $this->whatsapp,
        ]);
        if ($site_config) {
            $this->alert('success', 'Data berhasil disimpan.');
            $this->reset('password');
        } else {
            $this->alert('error', 'Data gagal disimpan.');
        }
    }
}
