@section('title', __('Vehiculos'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Vehiculo Listing </h4>
						</div>
						@if (session()->has('message'))
                      <div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif

					<div>
						<form wire:submit.prevent="buscarVehiculos">
							<label for="categoria_id">Categoría:</label>
							<select wire:model="categoria_id" id="categoria_id" class="form-control" placeholder="Categoría">
								<option value="">Todas las categorías</option>
								@if ($categorias)
									@foreach ($categorias as $item)
										<option value="{{ $item->id }}">{{ $item->categoria }}</option>
									@endforeach
								@endif
							</select>
							<button type="submit" class="btn btn-primary">Buscar</button>
						</form>
            <!-- Otras opciones de categoría -->
    

						<div class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createDataModal">
						<i class="fa fa-plus"></i>  Add Vehiculos
						</div>
					</div>
				</div>
				
				<div class="card-body">
						@include('livewire.vehiculos.modals')
				<div class="table-responsive">
					<table class="table table-bordered table-sm">
						<thead class="thead">
							<tr> 
								<td>#</td> 
								<th>Marca</th>
								<th>Modelo</th>
								<th>Color</th>
								<th>Categoria Id</th>
								<th>User Id</th>
								<td>ACTIONS</td>
							</tr>
						</thead>
						<tbody>
							@forelse($vehiculos as $row)
							<tr>
								<td>{{ $loop->iteration }}</td> 
								<td>{{ $row->marca }}</td>
								<td>{{ $row->modelo }}</td>
								<td>{{ $row->color }}</td>
								<td>{{ $row->categoria->categoria }}</td>
								<td>{{ $row->user_id }}</td>
								<td width="90">
									<div class="dropdown">
										<a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											Actions
										</a>
										<ul class="dropdown-menu">
											<li><a data-bs-toggle="modal" data-bs-target="#updateDataModal" class="dropdown-item" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i> Edit </a></li>
											<li><a class="dropdown-item" onclick="confirm('Confirm Delete Vehiculo id {{$row->id}}? \nDeleted Vehiculos cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i> Delete </a></li>  
										</ul>
									</div>								
								</td>
							</tr>
							@empty
							<tr>
								<td class="text-center" colspan="100%">No data Found </td>
							</tr>
							@endforelse
						</tbody>
					</table>						
					<div class="float-end">{{ $vehiculos->links() }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>