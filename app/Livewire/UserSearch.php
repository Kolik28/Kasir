<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Search Users')]
class UserSearch extends Component
{
    public $search = '';
    public $users = [];

    public function render()
    {
        $this->users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('role', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.user-search', [
            'users' => $this->users,
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $this->dispatch('user-deleted', id: $id);
        }
    }
}
