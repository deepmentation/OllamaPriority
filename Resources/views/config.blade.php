@extends('layouts.app')

@section('title', __('Ollama Priority Einstellungen'))

@section('content')
<div class="section-heading">
    {{ __('Ollama Priority Einstellungen') }}
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" method="POST" action="{{ route('ollamapriority.config.save') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('server_url') ? ' has-error' : '' }}">
                    <label for="server_url" class="col-sm-2 control-label">{{ __('Server URL') }}</label>

                    <div class="col-sm-6">
                        <input id="server_url" type="text" class="form-control input-sized" name="server_url" value="{{ old('server_url', $server_url) }}" required autofocus>

                        @if ($errors->has('server_url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('server_url') }}</strong>
                            </span>
                        @endif
                        <p class="help-block">
                            {{ __('Die URL des Ollama-Servers (z.B. http://localhost:11434)') }}
                        </p>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
                    <label for="model" class="col-sm-2 control-label">{{ __('Modell') }}</label>

                    <div class="col-sm-6">
                        <input id="model" type="text" class="form-control input-sized" name="model" value="{{ old('model', $model) }}" required>

                        @if ($errors->has('model'))
                            <span class="help-block">
                                <strong>{{ $errors->first('model') }}</strong>
                            </span>
                        @endif
                        <p class="help-block">
                            {{ __('Name des zu verwendenden Ollama-Modells (z.B. mistral)') }}
                        </p>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('system_prompt') ? ' has-error' : '' }}">
                    <label for="system_prompt" class="col-sm-2 control-label">{{ __('System Prompt') }}</label>

                    <div class="col-sm-6">
                        <textarea id="system_prompt" class="form-control input-sized" name="system_prompt" rows="4" required>{{ old('system_prompt', $system_prompt) }}</textarea>

                        @if ($errors->has('system_prompt'))
                            <span class="help-block">
                                <strong>{{ $errors->first('system_prompt') }}</strong>
                            </span>
                        @endif
                        <p class="help-block">
                            {{ __('Anweisung für das KI-Modell zur Priorisierung der E-Mails') }}
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Speichern') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
