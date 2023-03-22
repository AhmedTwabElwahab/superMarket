<div class="aside d-print-none">
    <div class="col-12 px-0 pb-4 text-center justify-content-center align-items-center mt-5">
        <a href="#">
            <img src="{{asset('images/pic1.jpg')}}" class="d-inline-block">
        </a>
        <div class="col-12 px-0 mt-2 text-center" style="color: #232323;">
            {{$lang->sideMenu('welcome').' '.auth()->user()->name}}
        </div>
    </div>
    <div class="col-12 px-0">
        <div class="col-12 px-3 aside-menu" style="overflow: auto;">
            <ul class="nav flex-column p-0 ">
                <li class="nav-item active">
                    <a class="nav-link " aria-current="page" href="{{route('dashboard')}}">
                       <span class="px-2">
                            <img src="{{asset('images/icon/dashboard.svg')}}" alt="home" style="width: 20px;height: 20px">
                       </span>
                        الرئيسية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('client.index')}}">
                            <span class="px-2">
                                <img src="{{asset('images/icon/groups.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('client')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('saleInvoice.index')}}">
                            <span class="px-2">
                                    <img src="{{asset('images/icon/attach_money.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('sales')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('purchaseInvoice.index')}}">
                            <span class="px-2">
                                    <img src="{{asset('images/icon/shopping_cart.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('purchase')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('supplier.index')}}">
                            <span class="px-2">
                                <img src="{{asset('images/icon/shopping_basket.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('supplier')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('saleReturn.index')}}">
                            <span class="px-2">
                                <img src="{{asset('images/icon/remove_shopping_cart.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('saleReturn')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('purchaseReturn.index')}}">
                            <span class="px-2">
                                <img src="{{asset('images/icon/shopping_cart_checkout.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('purchaseReturn')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('product.index')}}">
                            <span class="px-2">
                                    <img src="{{asset('images/icon/product.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('product')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('category.index')}}">
                            <span class="px-2">
                                     <img src="{{asset('images/icon/category.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('category')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('receipt.index')}}">
                            <span class="px-2">
                                    <img src="{{asset('images/icon/receipt.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('receipt')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('warehouse.index')}}">
                            <span class="px-2">
                                    <img src="{{asset('images/icon/store.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('warehouse')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('account.index')}}">
                            <span class="px-2">
                                <img src="{{asset('images/icon/account_tree.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('accounts')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('warehouse.index')}}">
                            <span class="px-2">
                                 <img src="{{asset('images/icon/description.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('report')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('warehouse.index')}}">
                            <span class="px-2">
                                    <img src="{{asset('images/icon/manage_accounts.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('users')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('warehouse.index')}}">
                            <span class="px-2">
                                    <img src="{{asset('images/icon/settings.svg')}}" alt="home" style="width: 20px;height: 20px">
                            </span>
                        {{$lang->sideMenu('settings')}}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
