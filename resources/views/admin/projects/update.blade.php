<x-app-luna-layout>
    <x-slot name="nav">
  @include('layouts.luna-nav')
    </x-slot>
      <x-clients-heading>
        <div class="header-icon">
            <i class="pe page-header-icon pe-7s-calculator"></i>
        </div>
        <div class="header-title">
            <h3 class="m-b-xs">{{$project->client->name}} | Proyectos</h3>
            
        </div>
      </x-clients-heading>

      <div class="view-header">
        <div class="header-icon">
            <i class="pe page-header-icon  pe-7s-plus"></i>
        </div>
        <div class="header-title">
            <h3> <small> Editar proyecto</small></h3>
        </div>
    </div>

    <div class="panel panel-filled">
        <div class="panel-body">
            <p>

            </p>
            <form action="{{url('/projects/' .$project->slug)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="name">Name</label>
                        <input type="text"  id="name" class="form-control" name="name" value="{{$project->name}}">
                        <span class="form-text small">The project's name.</span>
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="number"  id="client_id" class="form-control" name="client_id" value="{{$project->client->id}}" hidden>
                    </div>
                    <button class="btn btn-accent">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-luna-layout>
