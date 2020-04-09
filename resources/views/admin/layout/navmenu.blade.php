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
			<div class="d-flex align-items-center py-3"><img class="mr-2" src="{{ Theme::url('img/illustrations/falcon.png') }}" alt="" width="40"/><span class="text-sans-serif">SroCMS</span>
			</div>
		</a>
	</div>
	<div class="collapse navbar-collapse navbar-glass perfect-scrollbar scrollbar" id="navbarVerticalCollapse">
		<ul class="navbar-nav flex-column">
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#home" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="home">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-chart-pie"></span>
						</span>
						<span class="nav-link-text">Home</span>
					</div>
				</a>
				<ul class="nav collapse show" id="home" data-parent="#navbarVerticalCollapse">
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
							<span class="fas fa-newspaper"></span>
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
							<span class="fas fa-comment"></span>
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
							<span class="fas fa-copy"></span>
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
							<span class="fas fa-trophy"></span>
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
						<a class="nav-link" href="{{ route('admin.votes.providers.ips.index') }}">Callback IP Management</a>
					</li>
				</ul>
			</li>
            <li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#web-item-mall" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="web-item-mall">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-cart-arrow-down"></span>
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
							<span class="fas fa-code"></span>
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
		</ul>
		<div class="px-3 px-xl-0 navbar-vertical-divider">
			<hr class="border-300 my-2"/>
		</div>
		<ul class="navbar-nav flex-column">
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#user-manager" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="user-manager">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-users"></span>
						</span>
						<span class="nav-link-text">User Manager</span>
					</div>
				</a>
				<ul class="nav collapse" id="user-manager" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.users.index') }}">List</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#teleport-manager" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="teleport-manager">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-map-marked-alt"></span>
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
		</ul>
	</div>
</nav>
