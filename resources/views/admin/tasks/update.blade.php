<x-app-luna-layout>
    <x-slot name="nav">
  @include('layouts.luna-nav')
    </x-slot>
      <x-clients-heading>
        <div class="header-icon">
            <i class="pe page-header-icon pe-7s-calculator"></i>
        </div>
        <div class="header-title">
            <h3 class="m-b-xs">{{$task->project->name}} > Tasks > actualizar tarea</h3>
            
        </div>
      </x-clients-heading>

      <div class="view-header">
        <div class="header-icon">
            <i class="pe page-header-icon  pe-7s-plus"></i>
        </div>
        <div class="header-title">
            <h3> <small> Editar tarea</small></h3>
        </div>
    </div>

    <div class="panel panel-filled">
        <div class="panel-body">
            <p>

            </p>
            <form action="{{url('/tasks/'.$task->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label>Description</label>
                            <textarea class="form-control" rows="3" name="description" placeholder="Describe la tarea">{{$task->description}}</textarea>
                            @error('description')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="number"  id="project_id" class="form-control" name="project_id" value="{{$task->project->id}}" hidden>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <h5>Tiemp gastado en la tarea:</h5>
                    </div>
                    
                  <div class="form-group col-md-8 form-inline">
                      
                        <input type="number"  class="form-control" min="0" maxlength="2" placeholder="horas"  name="time_spent_on_hours" value="{{$hours}}" required>
                        <label class="m-xxs"> : </label>
                        <input type="number" class="form-control" min="0"  maxlength="2" placeholder="minutos" name="time_spent_on_minutes" value="{{$minutes}}" required>
                        <label class="m-xxs"> : </label>
                        <input type="number" class="form-control"  min="0" maxlength="2" placeholder="segundos" name="time_spent_on_secs" value="{{$secs}}" required>
                        <div class="row">
                           <div class="col-md-12  d-block">
                                @error('time_spent_on_hours')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                            @error('time_spent_on_minutes')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                                @error('time_spent_on_secs')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                         
                                </div>
                        </div>
                    </div>
                      <!--<div class="form-group col-lg-6">
                        <label for="password_confirmation">Repeat Password</label>
                        <input type="password" value="" id="password_confirmation" class="form-control" name="password_confirmation">
                        <span class="form-text small">Please repeat your pasword</span>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="email">Email Address</label>
                        <input type="email" value="" id="email" class="form-control" name="email">
                        <span class="form-text small">Your address email to contact</span>
                    </div>
                </div>-->
            </div>
                <div>
                    <button class="btn btn-accent">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-luna-layout>
