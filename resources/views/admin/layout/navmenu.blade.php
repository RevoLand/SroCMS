<nav class="navbar navbar-vertical navbar-expand-xl navbar-light">
	<div class="d-flex align-items-center">
		<div class="toggle-icon-wrapper">
			<button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-toggle="tooltip" data-placement="left" title="Toggle Navigation">
				<span class="navbar-toggle-icon">
					<span class="toggle-line"></span>
				</span>
			</button>
		</div>
		<a class="navbar-brand" href="{{ route('admin.dashboard.index') }}">
			<div class="d-flex align-items-center py-3"><img class="mr-2" src="{{ Theme::url('img/illustrations/falcon.png') }}" alt="" width="40"/><span class="text-sans-serif">SroCMS</span></div>
		</a>
	</div>
	<div class="collapse navbar-collapse navbar-glass perfect-scrollbar scrollbar" id="navbarVerticalCollapse">
		<ul class="navbar-nav flex-column">
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#home" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="home">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-chart-pie"></span>
						</span>
						<span class="nav-link-text">Home</span>
					</div>
				</a>
				<ul class="nav collapse" id="home" data-parent="#navbarVerticalCollapse">
					<li class="nav-item active">
						<a class="nav-link" href="{{ route('admin.dashboard.index') }}">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#!">Feed</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#articles" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="articles">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-newspaper"></span>
						</span>
						<span class="nav-link-text">Articles</span>
					</div>
				</a>
				<ul class="nav collapse" id="articles" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.articles.index') }}">List</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.articles.create') }}">Create</a>
					</li>
					<li class="nav-item">
						<a class="nav-link dropdown-indicator" href="#article-categories" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="article-categories">Article Categories</a>
						<ul class="nav collapse" id="article-categories" data-parent="#articles">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.articles.categories.index') }}">List</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.articles.categories.create') }}">Create</a>
							</li>
						</ul>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#article-comments" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="article-comments">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-comment"></span>
						</span>
						<span class="nav-link-text">Comments</span>
						<span class="badge badge-pill ml-2 badge-soft-success"></span>
					</div>
				</a>
				<ul class="nav collapse" id="article-comments" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.articles.comments.index') }}">List</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.articles.comments.index', ['is_approved' => 0]) }}">Awaiting Approval</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.articles.comments.index', ['is_visible' => 0]) }}">Hidden Comments</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#pages" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-copy"></span>
						</span>
						<span class="nav-link-text">Pages</span>
						<span class="badge badge-pill ml-2 badge-soft-success"></span>
					</div>
				</a>
				<ul class="nav collapse" id="pages" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.pages.index') }}">List</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.pages.create') }}">Create</a>
					</li>
				</ul>
            </li>
            <li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#vote-system" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="vote-system">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-trophy"></span>
						</span>
						<span class="nav-link-text">Vote System</span>
					</div>
				</a>
				<ul class="nav collapse" id="vote-system" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.votes.index') }}">Vote Logs</a>
					</li>
					<li class="nav-item">
						<a class="nav-link dropdown-indicator" href="#vote-providers" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="vote-providers">Vote Providers</a>
						<ul class="nav collapse" id="vote-providers" data-parent="#vote-system">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.votes.providers.index') }}">List</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.votes.providers.create') }}">Create</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a class="nav-link dropdown-indicator" href="#vote-reward-groups" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="vote-reward-groups">Reward Groups</a>
						<ul class="nav collapse" id="vote-reward-groups" data-parent="#vote-system">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.votes.rewardgroups.index') }}">List</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.votes.rewardgroups.create') }}">Create</a>
							</li>
						</ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator" href="#vote-callback-management" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="vote-callback-management">Callback IP Management</a>
                        <ul class="nav collapse" id="vote-callback-management" data-parent="#vote-system">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.votes.providers.ips.index') }}">List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.votes.providers.ips.create') }}">Create</a>
                            </li>
                        </ul>
					</li>
				</ul>
			</li>
            <li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#web-item-mall" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="web-item-mall">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-cart-arrow-down"></span>
						</span>
						<span class="nav-link-text">Web Item Mall</span>
					</div>
				</a>
				<ul class="nav collapse" id="web-item-mall" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.itemmall.index') }}">Orders</a>
					</li>
					<li class="nav-item">
						<a class="nav-link dropdown-indicator" href="#web-item-mall-categories" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="web-item-mall-categories">Categories</a>
						<ul class="nav collapse" id="web-item-mall-categories" data-parent="#web-item-mall">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.itemmall.categories.index') }}">List</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.itemmall.categories.create') }}">Create</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a class="nav-link dropdown-indicator" href="#web-item-mall-item-groups" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="web-item-mall-item-groups">Item Groups</a>
						<ul class="nav collapse" id="web-item-mall-item-groups" data-parent="#web-item-mall">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.itemmall.itemgroups.index') }}">List</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.itemmall.itemgroups.create') }}">Create</a>
							</li>
						</ul>
                    </li>
				</ul>
			</li>
            <li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#epin-system" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="epin-system">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-code"></span>
						</span>
						<span class="nav-link-text">E-Pin System</span>
					</div>
				</a>
				<ul class="nav collapse" id="epin-system" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.epins.create') }}">Create</a>
					</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.epins.index') }}">List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.epins.index', ['filter' => 1]) }}">Unused</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.epins.index', ['filter' => 2]) }}">Used</a>
                    </li>
				</ul>
            </li>
            @can('manage tickets')
            <li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#ticket-system" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="ticket-system">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-envelope"></span>
						</span>
						<span class="nav-link-text">Tickets</span>
					</div>
				</a>
				<ul class="nav collapse" id="ticket-system" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.tickets.index') }}">List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ticketbans.index') }}">Ticket Bans</a>
                    </li>
					<li class="nav-item">
						<a class="nav-link dropdown-indicator" href="#ticket-system-categories" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="ticket-system-categories">Categories</a>
						<ul class="nav collapse" id="ticket-system-categories" data-parent="#ticket-system">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.tickets.categories.index') }}">List</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.tickets.categories.create') }}">Create</a>
							</li>
						</ul>
					</li>
				</ul>
            </li>
            @endcan
		</ul>
		<div class="px-3 px-xl-0 navbar-vertical-divider">
			<hr class="border-300 my-2"/>
		</div>
		<ul class="navbar-nav flex-column">
            @can('view users')
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#user-manager" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="user-manager">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-users"></span>
						</span>
						<span class="nav-link-text">User Manager</span>
					</div>
				</a>
				<ul class="nav collapse" id="user-manager" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.users.index') }}">List</a>
                    </li>
                    @can('manage users')
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.users.edit') }}">Edit</a>
                    </li>
                    @endcan
                    @can('manage user bans')
					<li class="nav-item">
						<a class="nav-link dropdown-indicator" href="#nav-user-bans" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="nav-user-bans">Bans</a>
						<ul class="nav collapse" id="nav-user-bans" data-parent="#user-manager">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.users.bans.index') }}">List</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.users.bans.create') }}">New Ban</a>
							</li>
						</ul>
                    </li>
                    @endcan
				</ul>
            </li>
            @endcan
            @can('view characters')
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#character-manager" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="character-manager">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-user-alien"></span>
						</span>
						<span class="nav-link-text">Character Manager</span>
					</div>
				</a>
				<ul class="nav collapse" id="character-manager" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.characters.index') }}">List</a>
                    </li>
                    @can('manage characters')
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.characters.edit') }}">Edit</a>
                    </li>
                    @endcan
				</ul>
            </li>
            @endcan
            @can('manage items')
            <li class="nav-item">
                <a class="nav-link dropdown-indicator" href="#item-manager" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="item-manager">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <span class="fad fa-directions"></span>
                        </span>
                        <span class="nav-link-text">Item Manager</span>
                    </div>
                </a>
                <ul class="nav collapse" id="item-manager" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.item-manager.give_item_form') }}">Give Item</a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('manage teleports')
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#teleport-manager" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="teleport-manager">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fad fa-map-marked-alt"></span>
						</span>
						<span class="nav-link-text">Teleport Manager</span>
					</div>
				</a>
				<ul class="nav collapse" id="teleport-manager" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.teleports.index') }}">Teleports</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.teleports.reverse_points.index') }}">Reverse Points</a>
					</li>
				</ul>
            </li>
            @endcan
		</ul>
	</div>
</nav>
