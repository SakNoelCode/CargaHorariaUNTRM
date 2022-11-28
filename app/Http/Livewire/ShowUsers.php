<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ShowUsers extends Component
{
    use WithPagination;
    public $search, $numberOfRecords = "5";
    public $open_edit = true;

    //Escuchar eventos 
    protected $listeners = ['render_table_users' => 'render'];

    protected $queryString = [
        'numberOfRecords' => ['except' => '5']
    ];

    public function render()
    {
        $users = DB::table('users as u')
            ->join('roles as r', 'u.rol_id', '=', 'r.id')
            ->select(
                'u.id',
                'u.name',
                'u.email',
                'u.dni',
                'u.status',
                'u.profile_photo_path',
                'r.descripcion'
            )
            ->orderBy('u.id', 'desc')
            ->where('u.name', 'like', '%' . $this->search . '%')
            ->orWhere('u.email', 'like', '%' . $this->search . '%')
            ->paginate($this->numberOfRecords);

        return view('livewire.show-users', ['users' => $users]);
    }

    //Cuando busque un registro la página se resetea
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
