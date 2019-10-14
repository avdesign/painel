<p class="button-height inline-label">
    <label for="last_name" class="label"> Razão Social <span class="red">*</span></label>
    <input type="text" id="last_name" name="user[last_name]" class="input full-width" value="">
</p>
<p class="button-height inline-label">
    <label for="first_name" class="label"> Fantasia <span class="red">*</span></label>
    <input type="text" id="first_name" name="user[first_name]" class="input full-width" value="">
</p>
<p class="button-height inline-label">
    <label for="document1" class="label"> CNPJ <span class="red">*</span></label>
    <input type="text" id="document1" name="user[document1]" class="input full-width" value="">
</p>
<p class="button-height inline-label">
    <label for="document2" class="label"> Insc. Estadual <span class="red">*</span></label>
    <input type="text" id="document2" name="user[document2]" class="input full-width" value="">
</p>
<p/>
<script>
    $( document ).ready(function() {
        $("#document1").mask("99.999.999/9999-99");
    });
</script>