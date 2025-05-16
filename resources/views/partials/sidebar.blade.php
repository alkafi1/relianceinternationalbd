<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        @if (auth()->guard('agent')->check())
            <a href="{{ route('agent.dashboard') }}">
            @else
                <a href="{{ route('dashboard') }}">
        @endif
        <img alt="Logo" src="{{ asset('public/frontend/images/' . $global['logo']) }}" class="h-25px logo" />
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

                @if ((auth('agent')->check() && auth('agent')->user()->hasAnyPermission('agent.dashboard')) ||
                        (auth()->check() && auth()->user()->hasAnyPermission('dashboard')))
                    <div class="menu-item">
                        @if (auth()->guard('agent')->check())
                            <a class="menu-link {{ Route::currentRouteName() == 'agent.dashboard' ? 'active' : '' }}"
                                href="{{ route('agent.dashboard') }}">
                            @elseif(auth()->guard('web')->check())
                                <a class="menu-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                                    href="{{ route('dashboard') }}">
                        @endif
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
                @endif
                {{-- dashboard sidebar end --}}

                {{-- admin sidebar start --}}
                @if (auth('web')->check() &&
                        auth('web')->user()->hasAnyPermission(['admin.index', 'admin.create']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'admin.index' || Route::currentRouteName() == 'admin.create' ? 'hover show' : '' }}">
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
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'admin.index' || Route::currentRouteName() == 'admin.index' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('admin.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'admin.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Admin List</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-request-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('admin.create') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'admin.create' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Admin Create
                                    </span>
                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{-- aqdmin sidebar end --}}

                {{-- agent sidebar start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission(['agent.index', 'agent.create', 'agent.edit']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'agent.create' || Route::currentRouteName() == 'agent.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-user-tie"></i>
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
                @endif
                {{-- agent sidebar end --}}

                {{-- Terminal Start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission([
                                'terminal.index',
                                'terminal.create',
                                'terminal.expense.create',
                                'terminal.expense.index',
                            ]))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'terminal.create' || Route::currentRouteName() == 'terminal.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/maps/map003.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-plane-departure"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">Terminal
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'terminal.index' || Route::currentRouteName() == 'terminal.create' || Route::currentRouteName() == 'terminal.expense.index' || Route::currentRouteName() == 'terminal.expense.create' ? 'hover show' : '' }}">
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
                            <a class="menu-item menu-accordion" href="{{ route('terminal.create') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'terminal.create' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Terminal Create
                                    </span>
                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-request-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('terminal.expense.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'terminal.expense.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Terminal Expense List
                                    </span>
                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-request-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('terminal.expense.create') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'terminal.expense.create' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Terminal Expense Create
                                    </span>
                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{-- Terminal End --}}

                {{-- Parties Start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission(['party.index', 'party.create']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'party.create' || Route::currentRouteName() == 'party.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen002.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-user-tie"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">Parties
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'party.index' || Route::currentRouteName() == 'party.create' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('party.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'party.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Parties List</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-request-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('party.create') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'party.create' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Parties Create
                                    </span>
                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{-- Parties End --}}

                {{-- Jobs Start --}}
                @if (
                    (auth('agent')->check() &&
                        auth('agent')->user()->hasAnyPermission(['job.index', 'job.create'])) ||
                        (auth('web')->check() &&
                            auth()->user()->hasAnyPermission(['job.index', 'job.create'])))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'party.create' || Route::currentRouteName() == 'party.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-briefcase"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">Jobs
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'job.index' || Route::currentRouteName() == 'job.create' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('job.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'job.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Job List</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-request-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('job.create') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'job.create' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Job Create
                                    </span>
                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-request-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('job.create') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'job.create' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Job Report
                                    </span>
                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{-- Jobs End --}}

                {{-- Bills Start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission(['bill.register.index', 'party.create']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'bill.register.index' || Route::currentRouteName() == 'party.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen002.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-user-tie"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">Bill
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'bill.register.index' || Route::currentRouteName() == 'party.create' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('bill.register.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'bill.register.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Bill Register</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-request-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('party.create') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'party.create' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title position-relative">Bill Statement 
                                    </span>
                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{-- Bills End --}}

                {{-- Account Start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission(['account.index', 'party.create']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'account.index' || Route::currentRouteName() == 'party.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen002.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-user-tie"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">Account
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'account.index' || Route::currentRouteName() == 'party.create' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('account.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'account.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Account List</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('account.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'account.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Chart of Account</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('account.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'account.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">New Income</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('account.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'account.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">New Expense</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('account.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'account.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Cash Book</span>

                                </span>
                            </a>
                            {{-- @endcan --}}

                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('account.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'account.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Commission</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            
                        </div>
                    </div>
                @endif
                {{-- Account End --}}

                {{--CTG Start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission(['system.index']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'system.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-cog"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">Reports
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'system.index' || Route::currentRouteName() == 'party.create' ? 'hover show' : '' }}">
                            
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('system.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'system.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Profit and Loss</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('system.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'system.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Leadger Report</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{--Report End --}}

                {{--Genral Leadger Start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission(['system.index']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'system.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-cog"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">Genral Leadger
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'system.index' || Route::currentRouteName() == 'party.create' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('system.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'system.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Leadger Entries</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('system.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'system.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Leadger Entry Type</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{--Genral Leadger End --}}

                {{--CTG Start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission(['system.index']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'system.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-cog"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">CTG
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'system.index' || Route::currentRouteName() == 'party.create' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('system.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'system.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">One Bank</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('system.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'system.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Shonali Bank</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('system.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'system.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">REC/EXP Record</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{--CTG End --}}

                {{-- System setting Start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission(['system.index']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'system.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-cog"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">System Settings
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'system.index' || Route::currentRouteName() == 'party.create' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('system.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'system.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">System Settings</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{-- System setting End --}}

                {{-- Role And Permission Start --}}
                @if (auth('web')->check() &&
                        Auth::guard('web')->user()->hasAnyPermission(['role.index']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'role.create' || Route::currentRouteName() == 'role.index' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-user-lock"></i>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title position-relative">Role Management
                            </span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'role.index' || Route::currentRouteName() == 'role.create' ? 'hover show' : '' }}">
                            {{-- @can('member-list-view') --}}
                            <a class="menu-item menu-accordion" href="{{ route('role.index') }}">
                                <span
                                    class="menu-link {{ Route::currentRouteName() == 'role.index' ? 'active' : '' }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Permission</span>

                                </span>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                @endif
                {{-- Role And Permission End --}}

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

</div>
