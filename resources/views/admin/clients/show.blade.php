<x-app-luna-layout>
    <x-slot name="nav">
  @include('layouts.luna-nav')
    </x-slot>
      <x-clients-heading>
        <div class="header-icon">
            <i class="pe page-header-icon pe-7s-calculator"></i>
        </div>
        <div class="header-title">
            <h3 class="m-b-xs">{{$client->name}} > Proyectos</h3>
            
        </div>
      </x-clients-heading>
<div class="row">
      <div class="view-header col-lg-6">
        <div class="header-icon">
            <small><i class="fa fa-list"></i></small>
        </div>
        <div class="header-title">
            <h3> <small> Projects</small></h3>
        </div>
    </div>
    @can('create', App\Models\Project::class)
    <div class="col-lg-6">
        <div class="view-header col-lg-6">
            <div class="header-icon">
                <i class="fa fa-plus"></i>
            </div>
            <div class="header-title">
                <a href="{{url('/projects-create',['client_id' => $client->slug])}}"><h3> <small>Nuevo</small></h3></a> 
                
            </div>
        </div>
    </div>
    @endcan
</div>
<div class="panel">
    <div class="panel-body">
        <table class="table table-vertical-align-middle table-responsive-sm">
            <thead>
            <tr>
                <th>
                    Project Name
                </th>
                <th>
                    Total time
                </th>
            @can('create', App\Models\Project::class)
            <th class="text-right">
                Actions
            </th>
            @endcan
            </tr>
            </thead>
            <tbody>
                @if ($projects->count() > 0)
    @foreach ($projects as $project)
    <tr>
        <td>
            <a href="{{'/projects/'. $project->slug}}">{{$project->name}} </a>
        </td>
        <td>
            {{$project->timeSpentSoFar()}}
        </td>
        <td>
            @can('update', App\Models\Project::class)
            <div class="btn-group pull-right">
                <a href="{{url('/projects-edit/' . $project->slug)}}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                <form action="{{url('/projects/'. $project->slug)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-default btn-xs"><i class="fa fa-trash"></i> Delete</button>
                </form> 
            </div>
            @endcan
        </td>
    </tr>
    @endforeach
    @endif
                
            </tbody>
        </table>
    </div>
</div>
    
</x-app-luna-layout>
