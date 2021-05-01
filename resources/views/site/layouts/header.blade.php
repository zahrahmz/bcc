<header class="header" @impersonating($guard = 'site') style="background-color: #bf3636;" @endImpersonating>
    <div class="container h-100 header__container">
        <div class="d-flex h-100 justify-content-between align-items-center">
            <a class="d-flex align-items-center" href="tel:02166962957">
                <i class="svg-icon svg-icon-phone-square ml-3"></i>
                شماره تماس ۶۶۹۶۲۹۵۷
            </a>
            @if(currentUserObj())
                <div class="d-flex align-items-center">
                    <i class="svg-icon svg-icon-user"></i>
                    <div class="dropdown user-menu-dropdown">
                        <button class="btn dropdown-toggle" type="button"
                                id="userDropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <span class="user-fullname ml-2">
                                {{ currentUserObj()->name }}
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdownMenuButton">
                            <a class="dropdown-item text-right" href="#">حساب کاربری</a>
                            <a class="dropdown-item text-right" href="{{ route('site.logout') }}">خروج</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="d-flex align-items-center">
                    <i class="svg-icon svg-icon-user"></i>
                    <a class="px-3 border-left" href="{{ route('site.register') }}">عضویت</a>
                    <a class="px-3" href="{{ route('site.login') }}">ورود</a>
                </div>
            @endif
        </div>
    </div>
</header>
