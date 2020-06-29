<form action="{{ route('especialidades.store') }}" method="POST">
    @csrf

    <label for="descripcion"> Nombre de la Especialidad</label>
    <input type="text" name="descripcion" class="form-control">
    <button type="submit">Guardar</button>
</form>
