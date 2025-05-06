 @if (isAdminPanel())
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="ri-dashboard-line"></i>
                        <span>{{ __('message.dashboard') }}</span>
                    </a>
                </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="ri-building-line"></i>
                            <span>{{ __('message.houses') }}</span>
                        </a>
                        <ul class="sub-menu {{ @$navHouseMMShowClass }}" aria-expanded="false">
                            <li class="{{ @$subNavAllHouseMMActiveClass }}">
                                <a href="{{ route(userprefix().'.allHouse') }}"
                                    class="{{ @$subNavAllHouseActiveClass }}">{{ __('message.all_house') }}</a>
                            </li>
                            @if (isOwner())
                            <li class="{{ @$subNavAllUnitMMActiveClass }}">
                                <a href="{{ route('owner.addHouse') }}"
                                    class="{{ @$subNavAllUnitActiveClass }}">{{ __('message.add_house') }}</a>
                            </li>
                            @endif
                            <li class="{{ @$subNavOwnHouseActiveClass }}">
                                <a href="{{ route(userprefix().'.rentedHouse') }}"
                                    class="{{ @$subNavOwnHouseActiveClass }}">{{ __('message.rented_house') }}</a>
                            </li>
                        </ul>
                    </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="ri-user-3-line"></i>
                        <span>{{ __('message.tenants') }}</span>
                    </a>
                    <ul class="sub-menu {{ @$navTenantMMShowClass }}" aria-expanded="false">
                        <li class="{{ @$subNavAllTenantMMActiveClass }}">
                            <a href="{{ route(userprefix() .'.tenants')}}" 
                                class="{{ @$subNavAllTenantActiveClass }}">{{ __('message.all_tenants') }}</a>
                        </li>
                        <li class="{{ @$subNavTenantHistoryMMActiveClass }}">
                            <a href="{{ route(userprefix().'.tenantsHistory') }}" 
                                class="{{ @$subNavTenantHistoryActiveClass }}">{{ __('message.tenant_history') }}</a>
                        </li>
                    </ul>
                </li>

                @if (isAdmin())
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="ri-user-3-line"></i>
                            <span>{{ __('message.owners') }}</span>
                        </a>
                        <ul class="sub-menu {{ @$navTenantMMShowClass }}" aria-expanded="false">
                            <li class="{{ @$subNavAllTenantMMActiveClass }}">
                                <a href="{{ route('admin.owners' )}}"
                                    class="{{ @$subNavAllTenantActiveClass }}">{{ __('message.all_owners') }}</a>
                            </li>
                            <li class="{{ @$subNavTenantHistoryMMActiveClass }}">
                                <a href="{{ route('admin.ownersHistory')}}"
                                    class="{{ @$subNavTenantHistoryActiveClass }}">{{ __('message.owners_history') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="ri-account-circle-line"></i>
                        <span>{{ __('message.profile') }}</span>
                    </a>
                    <ul class="sub-menu {{ @$navProfileMMShowClass }}" aria-expanded="false">
                        <li class="{{ @$subNavProfileMMActiveClass }}"><a class="{{ @$subNavProfileActiveClass }}"
                                href="{{ route(userPrefix().'.profile') }}">{{ __('message.my_profile') }}</a></li>
                        <li><a href="{{ route(userPrefix().'.change-password') }}">{{ __('message.change_password') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route(userPrefix().'.messages') }}" id="messages-menu-item">
                        <i class="ri-message-fill"></i>
                        <span>{{ __('message.message') }}</span>
                        @if (getUnreadMessage()>0)
                        <span class="badge bg-success rounded-pill float-end" id="unread-messages-badge">{{ getUnreadMessage() }}</span>
                        @endif
                    </a>
                </li>
                @if (isAdmin())
                    <li>
                        <a href="{{ route('admin.setting') }}">
                            <i class="ri-settings-3-line"></i>
                            <span>{{ __('message.setting') }}</span>
                        </a>
                    </li>
                @endif
            </ul>

        </div>
    </div>
</div>
@endif