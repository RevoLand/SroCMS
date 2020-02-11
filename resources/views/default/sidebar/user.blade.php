<div class="row">
    <div class="col-12">
        @auth
        <div class="sidebar-user-actions">
            <table class="table table-borderless table-responsive-md">
                <tr>
                    <td>{{ setting('balance.name', 'Bakiye') }}:</td>
                    <td>
                        {{ number_format(Auth::user()->balance->balance, 2) }} {{ setting('balance.currency', 'TL') }}
                    </td>
                </tr>
                <tr>
                    <td>{{ setting('balance.point_name', 'Bakiye (Puan)') }}:</td>
                    <td>
                        {{ number_format(Auth::user()->balance->balance_point, 2) }} {{ setting('balance.currency', 'TL') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td>{{ setting('silk.silk_own_name', 'Silk') }}</td>
                    <td>{{ number_format(Auth::user()->silk->silk_own) }}</td>
                </tr>
                <tr>
                    <td>{{ setting('silk.silk_gift_name', 'Silk (Gift)') }}</td>
                    <td>{{ number_format(Auth::user()->silk->silk_gift) }}</td>
                </tr>
                <tr>
                    <td>{{ setting('silk.silk_point_name', 'Silk (Point)') }}</td>
                    <td>{{ number_format(Auth::user()->silk->silk_point) }}</td>
                </tr>
                <tr>
                    <td>
                    <a class="btn btn-danger btn-block" href="{{ route('users.current_user') }}" role="button">User CP</a>
                    <a class="btn btn-danger btn-block" href="{{ route('users.current_user') }}" role="button">User CP</a>
                    </td>
                    <td>
                    <a class="btn btn-danger btn-block" href="{{ route('votes.show_votes') }}" role="button">Voting</a>
                    <a class="btn btn-danger btn-block" href="{{ route('users.do_logout') }}" role="button">Logout</a>
                    </td>
                </tr>
            </table>
        </div>
        @endauth

        @guest
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            @include('components.forms.user.login')
        @endguest
    </div>
</div>
