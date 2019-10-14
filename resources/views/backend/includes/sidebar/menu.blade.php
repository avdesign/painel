<ul id="catalog-ajax" class="big-menu">
    @forelse($sections as $sec)
        <li id="menu-section-{{$sec->id}}" class="with-right-arrow">
            <span><span id="count-section-{{$sec->id}}" class="list-count">{{count($sec->products)}}</span>{{$sec->name}}</span>
            <ul class="big-menu">
                @forelse($sec->categories as $cat)
                    <li id="menu-category-{{$cat->id}}">
                        <a id="catalog" href="products/{{$cat->slug}}/catalog" title="{{$cat->name}}">{{$cat->name}}
                            <span><span id="count-category-{{$cat->id}}" class="list-count">{{count($cat->products)}}</span></span>
                        </a>
                    </li>
                @empty
                    <li><a href="javascript:void(0)">Não existe categorias<span><span class="list-count">0</span></span></a>
                @endforelse
            </ul>
        </li>
    @empty
        <li><a href="javascript:void(0)">Não existe seções<span><span class="list-count">0</span></span></a>
    @endforelse
</ul>