<div class="nav-header pt-4">
    <nav id="megaMenu">
        <a onclick="myFunction()" id="sidebar-collapse" href="javascript:void(0);"
            class="sidebar-collapse-icon with-animation text-center mobile-menu-trigger">Browse All Categories
            <span class="bi bi-chevron-down"></span>
        </a>
        <ul class="menu menu-bar mega-menu-hide pt-3">
            <li class="open-on-hover no-  open-on-hover">
                <a href="#" class="menu-link menu-bar-link hover-link" aria-haspopup="true">
                    <div id="loadCategoriesButton" class="main-category-wrapper"><i class="fas fa-th-list"></i>
                        BROWSE ALL CATEGORIES </div>
                </a>
                <ul id="nav-section" class="mega-menu mega-menu--multiLevel mega-menu-bg get-categories"
                    style="height:100%; overflow-y:auto;">
                    <li class="active-sub-category">
                        <a style="background-color: transparent!important; color:#59baf4!important;"
                            href="{{ url(config('country.icode') . '/search') }}"
                            class="menuLink-3427205540 menu-link menu-bar-link">
                            <span class="childName-3872504796 ">
                                <b><i class="fas fa-th-list"></i> MAIN CATEGORIES </b>
                            </span>
                        </a>
                    </li>
                    <li class="mobile-menu-back-item">
                        <a href="#" style="color: black!important"
                            class="menu-link mobile-menu-back-link">Back</a>
                    </li>
                </ul>
            </li>
            <li class="open-on-hover no-  open-on-hover">
                <a href="http://ezead.community/" class="menu-link menu-bar-link hover-link" target="_blank">
                    <div class="main-category-wrapper"><i class="fas fa-store"></i> EzeAD Community </div>
                </a>
            </li>
            <li class="open-on-hover no-  open-on-hover">
                <a href="https://ezeadhost.com/" class="menu-link menu-bar-link hover-link" target="_blank">
                    <div class="main-category-wrapper"><i class="fas fa-store"></i> EzeAD Host </div>
                </a>
            </li>
            <li class="open-on-hover no-  open-on-hover">
                <a href="https://ezead.info/" class="menu-link menu-bar-link hover-link" target="_blank">
                    <div class="main-category-wrapper"><i class="fas fa-store"></i> EzeAD Info </div>
                </a>
            </li>
            <li class="open-on-hover no-  open-on-hover">
                <a href="https://ezelancers.com/" class="menu-link menu-bar-link hover-link" target="_blank">
                    <div class="main-category-wrapper"><i class="fas fa-store"></i> EzeAD Lancers </div>
                </a>
            </li>
            <li class="open-on-hover no-  open-on-hover">
                <a href="https://ezead.services/" class="menu-link menu-bar-link hover-link" target="_blank">
                    <div class="main-category-wrapper"><i class="fas fa-store"></i> EzeAD Services </div>
                </a>
            </li>
            <li class="open-on-hover no-  open-on-hover">
                <a href="{{ auth()->check() ? 'https://shop.ezead.com/login?u=' . auth()->user()->id . '&r=ezead.com' : 'https://shop.ezead.com/' }}"
                    class="menu-link menu-bar-link hover-link" target="_blank">
                    <div class="main-category-wrapper"><i class="fas fa-store"></i> EzeAD Store </div>
                </a>
            </li>
            <li class="nav-item postadd add-post-max-width">
                <a id="themeMode" class="btn btn-light themeModeButton border shadow ms-2" href="#">
                    <i class="fa fa-moon"></i>
                    Light Mode </a>
            </li>
            <li class="mobile-menu-header">
                <a href="javascript:void(0);" class="">
                    <span>Menu</span>
                </a>
            </li>
        </ul>
    </nav>
</div>