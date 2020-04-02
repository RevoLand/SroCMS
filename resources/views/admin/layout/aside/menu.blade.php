<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu" data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{ route('admin.dashboard.index') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-dashboard"></i>
                    <span class="kt-menu__link-text">Dashboard</span>
                </a>
            </li>
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">SroCMS</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-sheet"></i>
                    <span class="kt-menu__link-text">Articles</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.articles.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-copy"></i>
                                <span class="kt-menu__link-text">List Articles</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.articles.create') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-edit"></i>
                                <span class="kt-menu__link-text">Create Article</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                <i class="kt-menu__link-icon flaticon2-files-and-folders"></i>
                                <span class="kt-menu__link-text">Article Categories</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu ">
                                <span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                                        <span class="kt-menu__link">
                                            <span class="kt-menu__link-text">Article Categories</span>
                                        </span>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.articles.categories.create') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-icon la la-edit"></i>
                                            <span class="kt-menu__link-text">Create Category</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.articles.categories.index') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-icon la la-copy"></i>
                                            <span class="kt-menu__link-text">List Categories</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon la la-comment-dots"></i>
                    <span class="kt-menu__link-text">Article Comments</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.articles.comments.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-comment-dots"></i>
                                <span class="kt-menu__link-text">List Comments</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.articles.comments.index', ['is_approved' => 0]) }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-comment-o"></i>
                                <span class="kt-menu__link-text">Awaiting Approval</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-copy"></i>
                    <span class="kt-menu__link-text">Pages</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.pages.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-copy"></i>
                                <span class="kt-menu__link-text">List Pages</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.pages.create') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-edit"></i>
                                <span class="kt-menu__link-text">Create Page</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-open-box"></i>
                    <span class="kt-menu__link-text">Vote System</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.votes.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet flaticon2-list">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Vote Logs</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Vote Providers</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu ">
                                <span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.votes.providers.index') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">List</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.votes.providers.create') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">Create</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Reward Groups</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu ">
                                <span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.votes.rewardgroups.index') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">List Reward Groups</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.votes.rewardgroups.create') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">Add New</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.votes.providers.ips.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Allowed Callback IPs</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-open-box"></i>
                    <span class="kt-menu__link-text">E-Pin System</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.epins.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">List</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.epins.create') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">Create</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-copy"></i>
                    <span class="kt-menu__link-text">Web Item Mall</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                <i class="kt-menu__link-icon flaticon2-files-and-folders"></i>
                                <span class="kt-menu__link-text">Categories</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu ">
                                <span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.itemmall.categories.index') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-icon la la-copy"></i>
                                            <span class="kt-menu__link-text">List</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.itemmall.categories.create') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-icon la la-edit"></i>
                                            <span class="kt-menu__link-text">Create</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                <i class="kt-menu__link-icon flaticon2-files-and-folders"></i>
                                <span class="kt-menu__link-text">Item Groups</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu ">
                                <span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.itemmall.itemgroups.index') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-icon la la-copy"></i>
                                            <span class="kt-menu__link-text">List</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="{{ route('admin.itemmall.itemgroups.create') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-icon la la-edit"></i>
                                            <span class="kt-menu__link-text">Create</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Settings</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-files-and-folders"></i>
                    <span class="kt-menu__link-text">Menus</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.menus.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-copy"></i>
                                <span class="kt-menu__link-text">List</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.menus.create') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-edit"></i>
                                <span class="kt-menu__link-text">Create</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Game</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon la la-warehouse"></i>
                    <span class="kt-menu__link-text">Teleport Manager</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.teleports.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-copy"></i>
                                <span class="kt-menu__link-text">Teleports</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="{{ route('admin.teleports.reverse_points.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon la la-edit"></i>
                                <span class="kt-menu__link-text">Reverse Points</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Components</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
        </ul>
    </div>
</div>
<!-- end:: Aside Menu -->
