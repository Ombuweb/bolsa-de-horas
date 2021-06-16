<x-app-luna-layout>
    <x-slot name="nav">
  @include('layouts.luna-nav')
    </x-slot>
      <x-clients-heading>
        <div class="header-icon">
            <i class="pe page-header-icon pe-7s-calculator"></i>
        </div>
        <div class="header-title">
            <h3 class="m-b-xs">{{$client->name}} | Proyectos</h3>
            
        </div>
      </x-clients-heading>

      <div class="view-header">
        <div class="header-icon">
            <i class="pe page-header-icon  pe-7s-plus"></i>
        </div>
        <div class="header-title">
            <h3> <small> Nuevo proyecto</small></h3>
        </div>
    </div>

    <div class="panel panel-filled">
        <div class="panel-body">
            <p>

            </p>
            <form action="{{url('/projects')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="name">Name</label>
                        <input type="text"  id="name" class="form-control" name="name">
                        <span class="form-text small">The project's name.</span>
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="number"  id="client_id" class="form-control" name="client_id" value="{{$client->id}}" hidden>
                    </div>
                    <!--<div class="form-group col-lg-6">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" name="password">
                        <span class="form-text small">Your hard to guess password</span>
                    </div>
                    <div class="form-group col-lg-6">
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
                <div>
                    <button class="btn btn-accent">Crear</button>
                </div>
            </form>
        </div>
    </div>
</x-app-luna-layout>
