<ul class="sel">
    @forelse ($carrossel as $c)
        <li data-p1="{{ $c->nome }}" data-p2="{{ $c->mini }}" class="wb"></li>
    @empty
        <li class="wb">Sem carrossel</li>
    @endforelse
</ul>