<!-- Navigation-->
@can('create', App\Models\Client::class)
    

<aside class="navigation">
    <nav>
        <ul class="nav luna-nav">
            <li class="nav-category">
                Main
            </li>
            <li class="active">
                <a href="{{url('/')}}">Dashboard</a>
            </li>

            <li>
                <li>
                    <a href="#users" data-toggle="collapse" aria-expanded="false">
                        Users<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="users" class="nav nav-second collapse">
                        <li><a href="{{url('/users-create')}}"> Create</a></li>
                        <li><a href="{{url('users')}}"> List</a></li>
                    </ul>
                </li>
                <li>
                <a href="#monitoring" data-toggle="collapse" aria-expanded="false">
                    Clients<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="monitoring" class="nav nav-second collapse">
                    <li><a href="{{route('clients-create')}}"> Create</a></li>
                    <li><a href="{{url('clients')}}"> List</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
@endcan
<!-- End navigation-->
