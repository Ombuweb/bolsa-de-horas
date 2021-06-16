<x-app-luna-layout>
    <x-slot name="nav">
        @include('layouts.luna-nav')
          </x-slot>
          <x-clients-heading>
            <div class="header-icon">
                <i class="pe page-header-icon pe-7s-calculator"></i>
            </div>
            <div class="header-title">
                <h3 class="m-b-xs">Users</h3>
                
            </div>
          </x-clients-heading>
    
          <div class="view-header">
            <div class="header-icon">
                <i class="fa fa-list"></i>
                        </div>
            <div class="header-title">
                <h3> <small> Listado</small></h3>
                
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <table class="table table-vertical-align-middle table-responsive-sm">
                    <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                             Company
                        </th>
                        <th>
                           Admin
                        </th>
                        <th class="text-right">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @if ($users->count() > 0)
            @foreach ($users as $user)
            <tr>
                @if (!$user->is_admin)
                    
               
                <td>
                    <a href="{{'/users/'. $user->id}}">{{$user->name}} </a>
                </td>
                <td>
                    {{$user->client->name}}
                </td>
                <td>
                    @php
                        echo $user->is_admin ? 'Yes': 'No';
                    @endphp
                    
                </td>
                <td> 
                    <div class="btn-group pull-right">
                    <a href="{{url('/users-edit/'. $user->id)}}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                    <form action="{{url('/users/'. $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-default btn-xs"><i class="fa fa-trash"></i> Delete</button>
                    </form>     
                </div></td>
                @endif
            </tr>
            @endforeach
            @endif
                        
                    </tbody>
                </table>
            </div>
        </div>
          
</x-app-luna-layout>