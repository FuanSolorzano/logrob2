<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categoria;

class Categorias extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $categoria;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.categorias.view', [
            'categorias' => Categoria::latest()
						->orWhere('categoria', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
    }
	
    private function resetInput()
    {		
		$this->categoria = null;
    }

    public function store()
    {
        $this->validate([
		'categoria' => 'required',
        ]);

        Categoria::create([ 
			'categoria' => $this-> categoria
        ]);
        
        $this->resetInput();
		$this->dispatchBrowserEvent('closeModal');
		session()->flash('message', 'Categoria Successfully created.');
    }

    public function edit($id)
    {
        $record = Categoria::findOrFail($id);
        $this->selected_id = $id; 
		$this->categoria = $record-> categoria;
    }

    public function update()
    {
        $this->validate([
		'categoria' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Categoria::find($this->selected_id);
            $record->update([ 
			'categoria' => $this-> categoria
            ]);

            $this->resetInput();
            $this->dispatchBrowserEvent('closeModal');
			session()->flash('message', 'Categoria Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            Categoria::where('id', $id)->delete();
        }
    }
}