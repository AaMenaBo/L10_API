@extends('layouts.app')
@section('content')
    <h1>Editando tarea ID: {{ $task->id }}</h1>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/tasks/{{ $task->id }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label class="form-label" for="name">Nombre</label>
            <input class="form-control" type="text" name="name" id="name" value="{{ $task->name }}">
            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="form-label" for="description">Descripción</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $task->description }}</textarea>
            @error('description')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="form-label" for="tags">Etiquetas</label>
            <div>
                @foreach ($tags as $tag)
                    <input class="form-check-input" type="checkbox"
                        value="{{ $tag->id }}"id="checkbox-{{ $tag->id }}" name="tags[]"
                        {{ $task->hasTag($tag->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="checkbox-{{ $tag->id }}">
                        {{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary">Regresar</a>
    </form>
@endsection
