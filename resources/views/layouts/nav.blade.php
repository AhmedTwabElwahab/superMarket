<div class="row">
    {{-- Start top-nav  --}}
    <div class="col-12 px-0 d-flex justify-content-between top-nav d-print-none">
        <div id="asideToggle" class="col-12 px-0 d-flex justify-content-center align-items-center btn  asideToggle">
            <i class="fa-solid fa-bars"></i>
        </div>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fa-regular fa-bell"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    {{auth()->user()->name}}
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                            {{$lang->nav('logout')}}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    {{-- End top-nav  --}}
</div>
<div class="col" style="margin-top: 45px"></div>
