@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuários</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row mb-3">
                <h4>
                    Usuários
                </h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4>
                                {{ $title }} de Usuário
                            </h4>
                        </div>
                    </div>

                    <form action="{{ $action }}" method="post" onsubmit="saveBtn.disabled = true; return true;">
                        @csrf
                        @isset($user)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" name="name" id="name" aria-describedby="nameHelp" value="{{ old('name', $user->name ?? '') }}" required>
                                <div id="nameHelp" class="form-text">Obrigatório.</div>
                                @error('name')
                                    <span class="text-danger"><small>{{ $message }}</small></span>
                                @enderror
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" class="form-control {{ $errors->has('login') ? 'is-invalid' : ''}}" name="login" id="login" aria-describedby="loginHelp" value="{{ old('login', $user->login ?? '') }}" required>
                                <div id="loginHelp" class="form-text">Obrigatório.</div>
                                @error('login')
                                    <span class="text-danger"><small>{{ $message }}</small></span>
                                @enderror
                            </div>
                            @if (!(isset($user)))
                                <div class="col-sm-4 mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}" name="password" id="password" aria-describedby="passwordHelp" value="{{ old('password', $user->password ?? '') }}" autocomplete="off" required>
                                    <div id="passwordHelp" class="form-text">Obrigatório.</div>
                                    @error('password')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            @endif
                        <div class="text-end">
                            <a href="{{ route('usuarios.index') }}" type="button" class="btn btn-secondary mx-1">Cancelar</a>
                            <button type="submit" class="btn btn-success" name="saveBtn">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
