@extends('layout')

@section('content')
<article>
    <h1 class="top">
        {{ $page->title }}<div></div>
    </h1>
    <section class="body">
        /view/ klasörü altında, sql'den atadığımız dosyayı çektik, bu dosyayı Laravel şartları altında her şekilde düzenleyebiliriz.
    </section>
</article>
@endsection
