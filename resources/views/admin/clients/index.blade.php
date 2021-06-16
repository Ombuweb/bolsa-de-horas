<x-app-luna-layout>
    <x-slot name="nav">
        @include('layouts.luna-nav')
          </x-slot>
          <x-clients-heading>
            <div class="header-icon">
                <i class="pe page-header-icon pe-7s-calculator"></i>
            </div>
            <div class="header-title">
                <h3 class="m-b-xs">Clientes</h3>
                
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
                            Client Name
                        </th>
                        <th>
                             Contracted
                        </th>
                        <th>
                           Consumed
                        </th>
                        <th>
                            Remaining
                        </th>
                        <th class="text-right">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @if ($clients->count() > 0)
            @foreach ($clients as $client)
            <tr>
                <td>
                    <a href="{{'/clients/'. $client->slug}}">{{$client->name}} </a>
                </td>
                <td>
                    {{$client->hours}}
                </td>
                <td>
                    {{$client->formattedTotalTimeSpent($client->totalTimeSpent())}}
                </td>
                <td>
                    {{$client->formattedTotalTimeSpent($client->timeRemaining())}}
                </td>
                <td> 
                    <div class="btn-group pull-right">
                    <a href="{{url('/clients-edit/'. $client->slug)}}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                    <form action="{{url('/clients/'. $client->slug)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-default btn-xs"><i class="fa fa-trash"></i> Delete</button>
                    </form>     
                </div></td>
            </tr>
            @endforeach
            @endif
                        
                    </tbody>
                </table>
            </div>
        </div>
          
</x-app-luna-layout>