<x-app-luna-layout>
    <x-slot name="nav">
  @include('layouts.luna-nav')
    </x-slot>
      <x-clients-heading>
        <div class="header-icon">
            <i class="pe page-header-icon pe-7s-calculator"></i>
        </div>
        <div class="header-title">
            <h3 class="m-b-xs"><a href="{{url('/clients/' .$task->project->client->slug)}}">{{$task->project->client->name}}</a>  > <a href="{{url('/projects/'.$task->project->slug)}}">{{$task->project->name}}</a>  > task</h3>
            
        </div>
      </x-clients-heading>
      <div class="row">
<div class="col-md-6">
    <span class="vertical-date pull-right">Tiempo: <small>{{$task->timeSpentOnTask()}}</small> </span>
</div>
@can('create', App\Models\Task::class)
    
<div class="col-md-6">
    <p><span class="pull-center"><small><a href="{{url('/tasks-edit/'. $task->id)}}"><i class="fa fa-pencil"></i> Edit</a></small> </span></p>
</div>
@endcan

      </div>
      <div class="row">
        <div class="p-sm">
            <h2>La descripción de la tarea</h2>

            <p>{{$task->description}}</p>
        </div>
    </div>
</x-app-luna-layout>