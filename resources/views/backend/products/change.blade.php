<select id="select-categories" name="prod[category_id]" class="select anthracite-gradient">
    @forelse($categories as $valcat)
        <option value="{{$valcat->id}}"> {{$valcat->name}} </option>
    @empty
    	<option value=""> Sem Categoria </option>
    @endforelse
</select>
