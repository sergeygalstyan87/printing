<aside class="sidebar sidebar-left">
    <div class="sidebar-content">
        <div class="aside-toolbar">
            <ul class="site-logo">
                <li>
                    <a href="{{ route('dashboard.index') }}">
                        <div class="logo">
                            <svg id="logo" width="25" height="25" viewBox="0 0 54.03 56.55">
                                <defs>
                                    <linearGradient id="logo_background_color">
                                        <stop class="stop1" offset="0%"/>
                                        <stop class="stop2" offset="50%"/>
                                        <stop class="stop3" offset="100%"/>
                                    </linearGradient>
                                </defs>
                                <path id="logo_path" class="cls-2" d="M90.32,0c14.2-.28,22.78,7.91,26.56,18.24a39.17,39.17,0,0,1,1,4.17l.13,1.5A15.25,15.25,0,0,1,118.1,29v.72l-.51,3.13a30.47,30.47,0,0,1-3.33,8,15.29,15.29,0,0,1-2.5,3.52l.06.07c.57.88,1.43,1.58,2,2.41,1.1,1.49,2.36,2.81,3.46,4.3.41.55,1,1,1.41,1.56.68.92,1.16,1.89.32,3.06-.08.12-.08.24-.19.33a2.39,2.39,0,0,1-2.62.07,4.09,4.09,0,0,1-.7-.91c-.63-.85-1.41-1.61-2-2.48-1-1.42-2.33-2.67-3.39-4.1a16.77,16.77,0,0,1-1.15-1.37c-.11,0-.06,0-.13.07-.41.14-.65.55-1,.78-.72.54-1.49,1.08-2.24,1.56A29.5,29.5,0,0,1,97.81,53c-.83.24-1.6.18-2.5.39a16.68,16.68,0,0,1-3.65.26H90.58L88,53.36A36.87,36.87,0,0,1,82.71,52a27.15,27.15,0,0,1-15.1-14.66c-.47-1.1-.7-2.17-1.09-3.39-1-3-1.45-8.86-.51-12.38a29,29,0,0,1,2.56-7.36c3.56-6,7.41-9.77,14.08-12.57a34.92,34.92,0,0,1,4.8-1.3Zm.13,4.1c-.45.27-1.66.11-2.24.26a32.65,32.65,0,0,0-4.74,1.37A23,23,0,0,0,71,18.7,24,24,0,0,0,71.13,35c2.78,6.66,7.2,11.06,14.21,13.42,1.16.39,2.52.59,3.84.91l1.47.07a7.08,7.08,0,0,0,2.43,0H94c.89-.21,1.9-.28,2.75-.46V48.8A7.6,7.6,0,0,1,95.19,47c-.78-1-1.83-1.92-2.62-3s-1.86-1.84-2.62-2.87c-2-2.7-4.45-5.1-6.66-7.62-.57-.66-1.14-1.32-1.66-2-.22-.29-.59-.51-.77-.85a2.26,2.26,0,0,1,.58-2.61,2.39,2.39,0,0,1,2.24-.2,4.7,4.7,0,0,1,1.22,1.3l.51.46c.5.68,1,1.32,1.6,2,2.07,2.37,4.38,4.62,6.27,7.17.94,1.26,2.19,2.3,3.14,3.58l1,1c.82,1.1,1.8,2,2.62,3.13.26.35.65.6.9,1A23.06,23.06,0,0,0,105,45c.37-.27,1-.51,1.15-1h-.06c-.18-.51-.73-.83-1-1.24-.74-1-1.64-1.88-2.37-2.87-1.8-2.44-3.89-4.6-5.7-7-.61-.82-1.44-1.52-2-2.34-.85-1.16-3.82-3.73-1.54-5.41a2.27,2.27,0,0,1,1.86-.26c.9.37,2.33,2.43,2.94,3.26s1.27,1.31,1.79,2c1.44,1.95,3.11,3.66,4.54,5.6.41.55,1,1,1.41,1.56.66.89,1.46,1.66,2.11,2.54.29.39.61,1.06,1.09,1.24.54-1,1.34-1.84,1.92-2.8a25.69,25.69,0,0,0,2.5-6.32c1.27-4.51.32-10.37-1.15-13.81A22.48,22.48,0,0,0,100.75,5.94a35.12,35.12,0,0,0-6.08-1.69A20.59,20.59,0,0,0,90.45,4.11Z" transform="translate(-65.5)" fill="url(#logo_background_color)"/>
                            </svg>
                        </div>
                        <span class="brand-text">Yansprint</span>
                    </a>
                </li>
            </ul>
        </div>
        <nav class="main-menu">
            <ul class="nav metismenu">
                <li class="sidebar-header"><span>Shop</span></li>
                @if(auth()->user()->role_id === \App\Enums\UserRoles::SUPER_ADMIN)
                    <li class="{{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
                        <a href="{{ route('dashboard.index') }}"><i class="icon dripicons-view-apps"></i><span>Financial Reports</span></a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'dashboard.orders.index' || Route::currentRouteName() == 'dashboard.orders.add' || Route::currentRouteName() == 'dashboard.orders.edit' ? 'active' : '' }}">
                        <a  href="{{ route('dashboard.orders.index', ['filters[orders-active-filter]' => 'new']) }}" aria-expanded="false"><i class="icon dripicons-basket"></i><span>Orders</span></a>

                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.categories.index' || Route::currentRouteName() == 'dashboard.categories.add' || Route::currentRouteName() == 'dashboard.categories.edit' || Route::currentRouteName() == 'dashboard.categories.subcategories' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-checklist"></i><span>Categories</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.categories.index' || Route::currentRouteName() == 'dashboard.categories.add' || Route::currentRouteName() == 'dashboard.categories.edit' || Route::currentRouteName() == 'dashboard.categories.subcategories' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.categories.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.categories.index') }}"><span>Categories</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.categories.subcategories' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.categories.subcategories') }}"><span>Subategories</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.categories.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.categories.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.attributes.index' || Route::currentRouteName() == 'dashboard.attributes.add' || Route::currentRouteName() == 'dashboard.attributes.edit' || Route::currentRouteName() == 'dashboard.types.index' || Route::currentRouteName() == 'dashboard.types.add' || Route::currentRouteName() == 'dashboard.types.edit' || Route::currentRouteName() == 'dashboard.quantities.index' || Route::currentRouteName() == 'dashboard.quantities.add' || Route::currentRouteName() == 'dashboard.quantities.edit' || Route::currentRouteName() == 'dashboard.sizes.index' || Route::currentRouteName() == 'dashboard.sizes.add' || Route::currentRouteName() == 'dashboard.sizes.edit' || Route::currentRouteName() == 'dashboard.grommets.index' || Route::currentRouteName() == 'dashboard.grommets.add' || Route::currentRouteName() == 'dashboard.grommets.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-gear"></i><span>Attributes</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.attributes.index' || Route::currentRouteName() == 'dashboard.attributes.add' || Route::currentRouteName() == 'dashboard.attributes.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.attributes.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.attributes.index') }}"><span>Attributes</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.attributes.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.attributes.add') }}"><span>Add attribute</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.types.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.types.index') }}"><span>Types</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.types.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.types.add') }}"><span>Add type</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.quantities.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.quantities.index') }}"><span>Quantities</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.quantities.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.quantities.add') }}"><span>Add quantity</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.sizes.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.sizes.index') }}"><span>Sizes</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.sizes.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.sizes.add') }}"><span>Add size</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.products.index' || Route::currentRouteName() == 'dashboard.products.add' || Route::currentRouteName() == 'dashboard.products.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-cart"></i><span>Products</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.products.index' || Route::currentRouteName() == 'dashboard.products.add' || Route::currentRouteName() == 'dashboard.products.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.products.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.products.index') }}"><span>All Products</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.products.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.products.add') }}"><span>Add new</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.products.production_time' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.products.production_time') }}"><span>Production time</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.products.templates' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.products.templates') }}"><span>Product Templates</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.coupons.index' || Route::currentRouteName() == 'dashboard.coupons.add' || Route::currentRouteName() == 'dashboard.coupons.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-tags"></i><span>Coupons</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.coupons.index' || Route::currentRouteName() == 'dashboard.coupons.add' || Route::currentRouteName() == 'dashboard.coupons.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.coupons.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.coupons.index') }}"><span>All Coupons</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.coupons.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.coupons.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header"><span>Users</span></li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.users.index' || Route::currentRouteName() == 'dashboard.users.add' || Route::currentRouteName() == 'dashboard.users.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-user"></i><span>Users</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.users.index' || Route::currentRouteName() == 'dashboard.users.add' || Route::currentRouteName() == 'dashboard.users.edit' ? 'in' : '' }}" aria-expanded="false">
                            <li class="{{ Route::currentRouteName() == 'dashboard.users.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.users.index') }}"><span>All Users</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.users.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.users.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header"><span>Content</span></li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.alerts.index' || Route::currentRouteName() == 'dashboard.alerts.add' || Route::currentRouteName() == 'dashboard.alerts.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-bell"></i><span>Alerts</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.alerts.index' || Route::currentRouteName() == 'dashboard.alerts.add' || Route::currentRouteName() == 'dashboard.alerts.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.alerts.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.alerts.index') }}"><span>All Alerts</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.alerts.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.alerts.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.sliders.index' || Route::currentRouteName() == 'dashboard.sliders.add' || Route::currentRouteName() == 'dashboard.sliders.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-photo-group"></i><span>Sliders</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.sliders.index' || Route::currentRouteName() == 'dashboard.sliders.add' || Route::currentRouteName() == 'dashboard.sliders.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.sliders.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.sliders.index') }}"><span>All Sliders</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.sliders.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.sliders.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.services.index' || Route::currentRouteName() == 'dashboard.services.add' || Route::currentRouteName() == 'dashboard.services.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-to-do"></i><span>Services</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.services.index' || Route::currentRouteName() == 'dashboard.services.add' || Route::currentRouteName() == 'dashboard.services.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.services.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.services.index') }}"><span>All Services</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.services.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.services.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.banners.index' || Route::currentRouteName() == 'dashboard.banners.add' || Route::currentRouteName() == 'dashboard.banners.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-photo"></i><span>Banner</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.banners.index' || Route::currentRouteName() == 'dashboard.banners.add' || Route::currentRouteName() == 'dashboard.banners.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.banners.edit' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.banners.edit', ['id' => 1]) }}"><span>Edit</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.reviews.index' || Route::currentRouteName() == 'dashboard.reviews.add' || Route::currentRouteName() == 'dashboard.reviews.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-star"></i><span>Reviews</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.reviews.index' || Route::currentRouteName() == 'dashboard.reviews.add' || Route::currentRouteName() == 'dashboard.reviews.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.reviews.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.reviews.index') }}"><span>All reviews</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.reviews.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.reviews.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.subscriptions.index' || Route::currentRouteName() == 'dashboard.subscriptions.add' || Route::currentRouteName() == 'dashboard.subscriptions.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-mail"></i><span>Subscriptions</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.subscriptions.index' || Route::currentRouteName() == 'dashboard.subscriptions.add' || Route::currentRouteName() == 'dashboard.subscriptions.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.subscriptions.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.subscriptions.index') }}"><span>All subscriptions</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.subscriptions.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.subscriptions.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'dashboard.partners.index' ? 'active' : '' }}">
                        <a href="{{ route('dashboard.partners.index') }}"><i class="icon dripicons-photo-group"></i><span>Partners logo</span></a>
                    </li>

                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.uploadedFileTypes.index' || Route::currentRouteName() == 'dashboard.uploadedFileTypes.add' || Route::currentRouteName() == 'dashboard.uploadedFileTypes.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-upload"></i><span>Uploaded File Types</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.uploadedFileTypes.index' || Route::currentRouteName() == 'dashboard.uploadedFileTypes.add' || Route::currentRouteName() == 'dashboard.uploadedFileTypes.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.uploadedFileTypes.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.uploadedFileTypes.index') }}"><span>All Uploaded File Types</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.uploadedFileTypes.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.uploadedFileTypes.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-header"><span>Settings</span></li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.settings.index' || Route::currentRouteName() == 'dashboard.settings.add' || Route::currentRouteName() == 'dashboard.settings.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-toggles"></i><span>Settings</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.settings.index' || Route::currentRouteName() == 'dashboard.settings.add' || Route::currentRouteName() == 'dashboard.settings.edit' ? 'in' : '' }}" aria-expanded="false">
                            <li class="{{ Route::currentRouteName() == 'dashboard.settings.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.settings.index') }}"><span>All Settings</span></a>
                            </li>
                        </ul>
                    </li>
                @elseif(auth()->user()->role_id === \App\Enums\UserRoles::MANAGER)
                    <li class="{{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
                        <a href="{{ route('dashboard.index') }}"><i class="icon dripicons-view-apps"></i><span>Financial Reports</span></a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'dashboard.orders.index' || Route::currentRouteName() == 'dashboard.orders.add' || Route::currentRouteName() == 'dashboard.orders.edit' ? 'active' : '' }}">
                        <a  href="{{ route('dashboard.orders.index', ['filters[orders-active-filter]' => 'new']) }}" aria-expanded="false"><i class="icon dripicons-basket"></i><span>Orders</span></a>

                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.coupons.index' || Route::currentRouteName() == 'dashboard.coupons.add' || Route::currentRouteName() == 'dashboard.coupons.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-tags"></i><span>Coupons</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.coupons.index' || Route::currentRouteName() == 'dashboard.coupons.add' || Route::currentRouteName() == 'dashboard.coupons.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.coupons.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.coupons.index') }}"><span>All Coupons</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.coupons.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.coupons.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header"><span>Users</span></li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.users.index' || Route::currentRouteName() == 'dashboard.users.add' || Route::currentRouteName() == 'dashboard.users.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-user"></i><span>Users</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.users.index' || Route::currentRouteName() == 'dashboard.users.add' || Route::currentRouteName() == 'dashboard.users.edit' ? 'in' : '' }}" aria-expanded="false">
                            <li class="{{ Route::currentRouteName() == 'dashboard.users.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.users.index') }}"><span>All Users</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.users.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.users.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header"><span>Content</span></li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.alerts.index' || Route::currentRouteName() == 'dashboard.alerts.add' || Route::currentRouteName() == 'dashboard.alerts.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-bell"></i><span>Alerts</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.alerts.index' || Route::currentRouteName() == 'dashboard.alerts.add' || Route::currentRouteName() == 'dashboard.alerts.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.alerts.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.alerts.index') }}"><span>All Alerts</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.alerts.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.alerts.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.sliders.index' || Route::currentRouteName() == 'dashboard.sliders.add' || Route::currentRouteName() == 'dashboard.sliders.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-photo-group"></i><span>Sliders</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.sliders.index' || Route::currentRouteName() == 'dashboard.sliders.add' || Route::currentRouteName() == 'dashboard.sliders.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.sliders.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.sliders.index') }}"><span>All Sliders</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.sliders.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.sliders.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.services.index' || Route::currentRouteName() == 'dashboard.services.add' || Route::currentRouteName() == 'dashboard.services.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-to-do"></i><span>Services</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.services.index' || Route::currentRouteName() == 'dashboard.services.add' || Route::currentRouteName() == 'dashboard.services.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.services.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.services.index') }}"><span>All Services</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.services.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.services.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.banners.index' || Route::currentRouteName() == 'dashboard.banners.add' || Route::currentRouteName() == 'dashboard.banners.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-photo"></i><span>Banner</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.banners.index' || Route::currentRouteName() == 'dashboard.banners.add' || Route::currentRouteName() == 'dashboard.banners.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.banners.edit' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.banners.edit', ['id' => 1]) }}"><span>Edit</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.reviews.index' || Route::currentRouteName() == 'dashboard.reviews.add' || Route::currentRouteName() == 'dashboard.reviews.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-star"></i><span>Reviews</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.reviews.index' || Route::currentRouteName() == 'dashboard.reviews.add' || Route::currentRouteName() == 'dashboard.reviews.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.reviews.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.reviews.index') }}"><span>All reviews</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.reviews.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.reviews.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.subscriptions.index' || Route::currentRouteName() == 'dashboard.subscriptions.add' || Route::currentRouteName() == 'dashboard.subscriptions.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-mail"></i><span>Subscriptions</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.subscriptions.index' || Route::currentRouteName() == 'dashboard.subscriptions.add' || Route::currentRouteName() == 'dashboard.subscriptions.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.subscriptions.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.subscriptions.index') }}"><span>All subscriptions</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.subscriptions.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.subscriptions.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'dashboard.partners.index' ? 'active' : '' }}">
                        <a href="{{ route('dashboard.partners.index') }}"><i class="icon dripicons-photo-group"></i><span>Partners logo</span></a>
                    </li>
                @elseif(auth()->user()->role_id === \App\Enums\UserRoles::DESIGNER)
                    <li class="sidebar-header"><span>Content</span></li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.products.index' || Route::currentRouteName() == 'dashboard.products.add' || Route::currentRouteName() == 'dashboard.products.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-cart"></i><span>Products</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.products.index' || Route::currentRouteName() == 'dashboard.products.add' || Route::currentRouteName() == 'dashboard.products.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.products.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.products.index') }}"><span>All Products</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.sliders.index' || Route::currentRouteName() == 'dashboard.sliders.add' || Route::currentRouteName() == 'dashboard.sliders.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-photo-group"></i><span>Sliders</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.sliders.index' || Route::currentRouteName() == 'dashboard.sliders.add' || Route::currentRouteName() == 'dashboard.sliders.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.sliders.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.sliders.index') }}"><span>All Sliders</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.sliders.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.sliders.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.services.index' || Route::currentRouteName() == 'dashboard.services.add' || Route::currentRouteName() == 'dashboard.services.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-to-do"></i><span>Services</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.services.index' || Route::currentRouteName() == 'dashboard.services.add' || Route::currentRouteName() == 'dashboard.services.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.services.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.services.index') }}"><span>All Services</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.services.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.services.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.banners.index' || Route::currentRouteName() == 'dashboard.banners.add' || Route::currentRouteName() == 'dashboard.banners.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-photo"></i><span>Banner</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.banners.index' || Route::currentRouteName() == 'dashboard.banners.add' || Route::currentRouteName() == 'dashboard.banners.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.banners.edit' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.banners.edit', ['id' => 1]) }}"><span>Edit</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.reviews.index' || Route::currentRouteName() == 'dashboard.reviews.add' || Route::currentRouteName() == 'dashboard.reviews.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-star"></i><span>Reviews</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.reviews.index' || Route::currentRouteName() == 'dashboard.reviews.add' || Route::currentRouteName() == 'dashboard.reviews.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.reviews.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.reviews.index') }}"><span>All reviews</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.reviews.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.reviews.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Route::currentRouteName() == 'dashboard.subscriptions.index' || Route::currentRouteName() == 'dashboard.subscriptions.add' || Route::currentRouteName() == 'dashboard.subscriptions.edit' ? 'active' : '' }}">
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="icon dripicons-mail"></i><span>Subscriptions</span></a>
                        <ul class="collapse nav-sub {{ Route::currentRouteName() == 'dashboard.subscriptions.index' || Route::currentRouteName() == 'dashboard.subscriptions.add' || Route::currentRouteName() == 'dashboard.subscriptions.edit' ? 'in' : '' }}" aria-expanded="true">
                            <li class="{{ Route::currentRouteName() == 'dashboard.subscriptions.index' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.subscriptions.index') }}"><span>All subscriptions</span></a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'dashboard.subscriptions.add' ? 'active' : '' }}">
                                <a href="{{ route('dashboard.subscriptions.add') }}"><span>Add new</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'dashboard.partners.index' ? 'active' : '' }}">
                        <a href="{{ route('dashboard.partners.index') }}"><i class="icon dripicons-photo-group"></i><span>Partners logo</span></a>
                    </li>
                @elseif(auth()->user()->role_id === \App\Enums\UserRoles::FRONTDESK)
                    <li class="{{ Route::currentRouteName() == 'dashboard.orders.index' || Route::currentRouteName() == 'dashboard.orders.add' || Route::currentRouteName() == 'dashboard.orders.edit' ? 'active' : '' }}">
                        <a  href="{{ route('dashboard.orders.index', ['filters[orders-active-filter]' => 'new']) }}" aria-expanded="false"><i class="icon dripicons-basket"></i><span>Orders</span></a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
