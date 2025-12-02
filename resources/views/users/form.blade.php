<x-layout>
    <div class="container">
        <h1 class="mb-4">Agregar / Editar usuario</h1>

        <form class="row g-3 needs-validation" novalidate method="POST" action="{{ url('/users') }}">
            @csrf
            <input type="hidden" name="id" value="{{ isset($user) ? $user->id : '' }}">

            <div class="col-md-6">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control {{ $errors->has('name')? 'is-invalid' : '' }}" id="name" name="name" required maxlength="255" value="{{ old('name', $user->name ?? '') }}">
                <div class="invalid-feedback">
                     {{ $errors->has('name')? $errors->first('name') : 'Campo requerido' }}
                </div>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control {{ $errors->has('email')? 'is-invalid' : '' }}" id="email" name="email" required maxlength="255" value="{{ old('email', $user->email ?? '') }}">
                <div class="invalid-feedback">
                     {{ $errors->has('email')? $errors->first('email') : 'Campo requerido' }}
                </div>
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control {{ $errors->has('password')? 'is-invalid' : '' }}" id="password" name="password" {{ isset($user) ? '' : 'required' }} minlength="8">
                <div class="invalid-feedback">
                     {{ $errors->has('password')? $errors->first('password') : (isset($user) ? 'Dejar en blanco para mantener la contraseña' : 'Campo requerido') }}
                </div>
            </div>

            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }} minlength="8">
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

    </div>

    @section('js')
    <script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
    </script>
    @endsection

</x-layout>