<x-app-luna-layout>
    <x-slot name="nav">
  @include('layouts.luna-nav')
    </x-slot>
      <x-clients-heading>
        <div class="header-icon">
            <i class="pe page-header-icon pe-7s-calculator"></i>
        </div>
        <div class="header-title">
            <h3 class="m-b-xs"><a href="{{url('/clients/' .$project->client->slug )}}">{{$project->client->name}} </a> > <a href="{{ url('/projects/'. $project->slug)}}">{{$project->name}}</a>  > tasks</h3>
            
        </div>
      </x-clients-heading>
<div class="row">
      <div class="view-header col-lg-6">
        <div class="header-icon">
            <i class="fa fa-list"></i>
        </div>
        <div class="header-title">
            <h3> <small> Tasks</small></h3>
        </div>
    </div>
    @can('create', App\Models\Task::class)
    <div class="col-lg-6">
        <div class="view-header col-lg-6">
            <div class="header-icon">
                <i class="fa fa-plus"></i>
            </div>
            <div class="header-title">
                <a href="{{url('/tasks-create',['project_id' => $project->slug])}}"><h3> <small>Nuevo</small></h3></a> 
                
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
                    Task Description
                </th>
                <th>
                    Time spent
                </th>
            @can('create', App\Models\Task::class)
                
                <th class="text-right">
                    Actions
                </th>
                @endcan
            </tr>
            </thead>
            <tbody>
                @if ($project->tasks->count() > 0)
    @foreach ($project->tasks as $task)
    <tr>
        <td>
            {{$task->description}} 
        </td>
        <td>
            {{$task->timeSpentOnTask()}}
        </td>
        <td>
            @can('create', App\Models\Task::class)
            <div class="btn-group pull-right">
                <a href="{{url('/tasks/'.$task->id)}}" class="btn btn-default btn-xs"><i class="fa fa-folder"></i> View</a>
                <a href="{{url('/tasks-edit/'. $task->id)}}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                <form action="{{url('/tasks/'. $task->id)}}" method="POST">
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
