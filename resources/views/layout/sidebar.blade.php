<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <a href="{{route('admin.dashboard')}}"><img src="{{url('assets/images/icon.svg')}}" alt="Logo"
                class="img-fluid logo"><span>Tourism</span></a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i
                class="lnr lnr-menu fa fa-chevron-circle-left"></i></button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
                <img src="{{url('assets/images/user.png')}}" class="user-photo" alt="User Profile Picture">
            </div>
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="user-name" data-toggle="dropdown"><strong>
                        {{isset(auth()->user()->name) ? auth()->user()->name : null}}</strong></a>
            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">

                <li class="{{ Request::segment(2) === 'locations' ? 'active open' : null }}">
                    <a href="" class="has-arrow"><i class="icon-anchor"></i><span>Locations</span></a>
                    <ul>
                        <li><a href="{{route('admin.cities.index')}}">Cities</a></li>
                        <li><a href="{{route('admin.areas.index')}}">Areas</a></li>

                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'clients' ? 'active open' : null }}">
                    <a href="{{route('admin.clients.index')}}"><i class="icon-users"></i><span>Clients</span></a>
                </li>
                <li class="{{ Request::segment(2) === 'banners' ? 'active open' : null }}">
                    <a href="{{route('admin.banners.index')}}"><i class="icon-picture"></i><span>Banners</span></a>
                </li>
                <li class="{{ Request::segment(2) === 'categories' ? 'active open' : null }}">
                    <a href="{{route('admin.categories.index')}}"><i class="icon-layers"></i><span>Categories</span></a>
                </li>
                <li class="{{ Request::segment(2) === 'places' ? 'active open' : null }}">
                    <a href="{{route('admin.places.index')}}"><i class="icon-map"></i><span>Places</span></a>
                </li>
                <li class="{{ Request::segment(2) === 'notifications' ? 'active open' : null }}">
                    <a href="{{route('admin.notifications.index')}}"><i
                            class="icon-map"></i><span>Notifications</span></a>
                </li>
                <li>
                    <a href="{{route('admin.places.topRating')}}"><i class="icon-star"></i><span>Top Rating
                            Places</span></a>
                </li>

                <li>
                    <a href="{{route('admin.places.PopularPlaces')}}"><i
                            class="icon-plane"></i><span>PopularPlaces</span></a></li>

                <li class="{{ Request::segment(2) === 'adminstrators' ? 'active open' : null }}">
                    <a href="" class="has-arrow"><i class="icon-briefcase"></i><span>Adminstrators</span></a>
                    <ul>
                        <li><a href="{{route('admin.users.index')}}">Users</a></li>
                        <li><a href="{{route('admin.roles.index')}}">Roles</a></li>
                    </ul>
                </li>

            </ul>


        </nav>
    </div>
</div>
