<?php

namespace App\Http\Livewire;

use App\Models\Categorias;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vehiculo;


class Vehiculos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id,$vehiculos, $keyWord, $marca, $modelo, $color, $estado, $categoria_id, $user_id,$categorias;

	public function mount()
    {
		$this->vehiculos = Vehiculo::all();
        
    }
	
    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.vehiculos.view', [
            'vehiculos' => Vehiculo::latest()
						->orWhere('marca', 'LIKE', $keyWord)
						->orWhere('modelo', 'LIKE', $keyWord)
						->orWhere('color', 'LIKE', $keyWord)
						->orWhere('estado', 'LIKE', $keyWord)
						->orWhere('categoria_id', 'LIKE', $keyWord)
						->orWhere('user_id', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
    }
	
    private function resetInput()
    {		
		$this->marca = null;
		$this->modelo = null;
		$this->color = null;
		$this->estado = null;
		$this->categoria_id = null;
		$this->user_id = null;
    }

    public function store()
    {
        $this->validate([
		'marca' => 'required',
		'modelo' => 'required',
		'color' => 'required',
		'estado' => 'required',
		'categoria_id' => 'required',
		'user_id' => 'required',
        ]);

        Vehiculo::create([ 
			'marca' => $this-> marca,
			'modelo' => $this-> modelo,
			'color' => $this-> color,
			'estado' => $this-> estado,
			'categoria_id' => $this-> categoria_id,
			'user_id' => $this-> user_id
        ]);
        
        $this->resetInput();
		$this->dispatchBrowserEvent('closeModal');
		session()->flash('message', 'Vehiculo Successfully created.');
    }

    public function edit($id)
    {
        $record = Vehiculo::findOrFail($id);
        $this->selected_id = $id; 
		$this->marca = $record-> marca;
		$this->modelo = $record-> modelo;
		$this->color = $record-> color;
		$this->estado = $record-> estado;
		$this->categoria_id = $record-> categoria_id;
		$this->user_id = $record-> user_id;
    }

    public function update()
    {
        $this->validate([
		'marca' => 'required',
		'modelo' => 'required',
		'color' => 'required',
		'estado' => 'required',
		'categoria_id' => 'required',
		'user_id' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Vehiculo::find($this->selected_id);
            $record->update([ 
			'marca' => $this-> marca,
			'modelo' => $this-> modelo,
			'color' => $this-> color,
			'estado' => $this-> estado,
			'categoria_id' => $this-> categoria_id,
			'user_id' => $this-> user_id
            ]);

            $this->resetInput();
            $this->dispatchBrowserEvent('closeModal');
			session()->flash('message', 'Vehiculo Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            Vehiculo::where('id', $id)->delete();
        }
    }
}