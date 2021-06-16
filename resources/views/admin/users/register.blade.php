<x-app-luna-layout>
    <x-slot name="nav">
  @include('layouts.luna-nav')
    </x-slot>
      <x-clients-heading>
        <div class="header-icon">
            <i class="pe page-header-icon pe-7s-calculator"></i>
        </div>
        <div class="header-title">
            <h3 class="m-b-xs">Usuarios</h3>
            
        </div>
      </x-clients-heading>

      <div class="view-header">
        <div class="header-icon">
            <i class="pe page-header-icon  pe-7s-plus"></i>
        </div>
        <div class="header-title">
            <h3> <small> Nuevo usuario</small></h3>
            <small>
                Crear un usuario nuevo.
            </small>
        </div>
    </div>

    <div class="panel panel-filled">
        <div class="panel-body">
            <p>

            </p>
            <form action="{{route('register')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="name">Name</label>
                        <input type="text"  id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="email">Email</label>
                        <input type="email"  id="email" class="form-control" name="email">
                    </div>
                </div>
                    <div class="row">
                   <div class="form-group col-lg-6">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" name="password">
                        <span class="form-text small">Your hard to guess password</span>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="password_confirmation">Repeat Password</label>
                        <input type="password" value="" id="password_confirmation" class="form-control" name="password_confirmation">
                        <span class="form-text small">Please repeat your pasword</span>
                    </div>
                </div>

                <div class="row">
                   
                     <div class="form-group col-lg-6">
                         <label for="client_id">Cliente: </label>
                         <select class="form-control"  name="client_id" id="client_id">
                             
                             @foreach ($clients as $client)
                                 <option value="{{$client->id}}">{{$client->name}}</option>
                             @endforeach
                         </select>
                         
                     </div>
                     <div class="col-lg-6">
                        Is user admin?
                        <div class="form-check abc-radio">
                            <input class="form-check-input" type="radio" name="is_admin" id="radio3" value="1">
                            <label class="form-check-label" for="radio3">
                                Yes
                            </label>
                        </div>
                        <div class="form-check abc-radio">
                            <input class="form-check-input" type="radio" name="is_admin" id="radio4" value="0" checked="">
                            <label class="form-check-label" for="radio4">
                               No
                            </label>
                        </div>
                    </div>
                 </div>
                
                <div>
                    <button class="btn btn-accent">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-luna-layout>
