@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Item: {{ $item->objCommon->CodeName128 }}</h1>
    <section class="body">
        <!-- Top part -->
        <section id="armory_top">
            <img class="avatar" src="{{ $item->objCommon->Image }}" />

            <section id="armory_name">
                <h2><b>{{ $item->objCommon->CodeName128 }}</b></h2>
            </section>
            <div class="clear"></div>
        </section>
        <section>
            <table width="100%" border="0">
                <tr>
                    <td>Rarity:</td>
                    <td>{{ $item->objCommon->Rarity }}</td>
                </tr>
            </table>
            <div class="clear"></div>
        </section>
    </section>
</article>
@endsection
