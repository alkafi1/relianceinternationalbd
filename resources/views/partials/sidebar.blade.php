<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('dashboard') }}">
            <img alt="Logo" src="{{ asset('public/frontend/images/logo.png') }}"
                class="h-25px logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="black" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">
                {{-- dashboard sidebar start --}}
                {{-- @if (Auth::guard('admin')->user()->hasAnyPermission(['dashboard-view'])) --}}
                    <div class="menu-item">
                        <div class="menu-content pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-tachometer-alt"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                {{-- @endif --}}
                {{-- dashboard sidebar end --}}

                {{-- member sidebar start --}}
                {{-- @if (Auth::guard('admin')->user()->hasAnyPermission(['member-list-view', 'member-request-view'])) --}}
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Admin</span>
                        </div>
                    </div>
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'dashboard' || Route::currentRouteName() == 'dashboard' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-users"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">Admin
                                {{-- <div class="pendingMemberCount">
                                    @if ($global['pendingMemberCount'] > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                            style="top: 9px !important; margin-left: -12px;">
                                            {{ $global['pendingMemberCount'] }}
                                        </span>
                                    @endif
                                </div> --}}
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'dashboard' || Route::currentRouteName() == 'dashboard' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                                <a class="menu-item menu-accordion" href="{{ route('dashboard') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Admin List</span>

                                    </span>
                                </a>
                            {{-- @endcan --}}
                            {{-- @can('member-request-view') --}}
                                <a class="menu-item menu-accordion" href="{{ route('dashboard') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title position-relative">Admin Create
                                            {{-- <div class="pendingMemberCount">
                                                @if ($global['pendingMemberCount'] > 0)
                                                    <span
                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                                        style="top: 9px !important; margin-left: -12px;">
                                                        {{ $global['pendingMemberCount'] }}
                                                    </span>
                                                @endif
                                            </div> --}}
                                        </span>
                                    </span>
                                </a>
                            {{-- @endcan --}}
                        </div>
                    </div>

                {{-- @endif --}}
                {{-- member sidebar end --}}

                {{-- member sidebar start --}}
                {{-- @if (Auth::guard('admin')->user()->hasAnyPermission(['member-list-view', 'member-request-view'])) --}}
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Agent</span>
                    </div>
                </div>
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ Route::currentRouteName() == 'agent.create' || Route::currentRouteName() == 'dashboard' ? 'hover show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fas fa-users"></i>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title position-relative">Agent
                        </span>
                        <span class="menu-arrow"></span>
                    </span>

                    <div
                        class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'agent.index' || Route::currentRouteName() == 'agent.create' ? 'hover show' : '' }}">
                        {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('agent.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'agent.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Agent List</span>

                                </span>
                            </a>
                        {{-- @endcan --}}
                        {{-- @can('member-request-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('agent.create') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'agent.create' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Agent Create
                                    </span>
                                </span>
                            </a>
                        {{-- @endcan --}}
                    </div>
                </div>

                {{-- Terminal Start --}}
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Terminal</span>
                    </div>
                </div>
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ Route::currentRouteName() == 'terminal.create' || Route::currentRouteName() == 'dashboard' ? 'hover show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fas fa-users"></i>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title position-relative">Terminal
                        </span>
                        <span class="menu-arrow"></span>
                    </span>

                    <div
                        class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'terminal.index' || Route::currentRouteName() == 'agent.create' ? 'hover show' : '' }}">
                        {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('terminal.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'terminal.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Terminal List</span>

                                </span>
                            </a>
                        {{-- @endcan --}}
                        {{-- @can('member-request-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('agent.create') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'agent.create' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Terminal Create
                                    </span>
                                </span>
                            </a>
                        {{-- @endcan --}}
                    </div>
                </div>
                {{-- Terminal End --}}

            {{-- @endif --}}
            {{-- member sidebar end --}}



            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

</div>
