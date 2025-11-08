<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="code" class="form-label">{{ __('Código') }}</label>
            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                   value="{{ old('code', $questionnaire?->code) }}" id="code" placeholder="Código" readonly>
            {!! $errors->first('code', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="title" class="form-label">{{ __('Título') }}</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                   value="{{ old('title', $questionnaire?->title) }}" id="title" placeholder="Título">
            {!! $errors->first('title', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="description" class="form-label">{{ __('Descripción') }}</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" 
                   value="{{ old('description', $questionnaire?->description) }}" id="description" placeholder="Descripción">
            {!! $errors->first('description', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="version" class="form-label">{{ __('Versión') }}</label>
            <input type="text" name="version" class="form-control @error('version') is-invalid @enderror" 
                value="{{ old('version', $questionnaire?->version) }}" 
                id="version" placeholder="Versión" readonly>
            {!! $errors->first('version', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>


        <div class="form-group mb-2 mb20">
            <label for="created_by" class="form-label">{{ __('Creado por') }}</label>
            <select name="created_by" id="created_by" class="form-control @error('created_by') is-invalid @enderror">
                <option value="">-- Seleccionar usuario --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ old('created_by', $questionnaire?->created_by) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('created_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>


    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){

    $('#title').on('keyup', function(){
        let title = $(this).val();

        if(title.length > 0){
            $.ajax({
                url: "{{ route('admin.questionnaires.generateCode') }}", 
                type: "POST",
                data: {
                    title: title,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    $('#code').val(response.code);
                }
            });
        } else {
            $('#code').val('');
        }
    });

    $.ajax({
        url: "{{ route('admin.questionnaires.generateVersion') }}", 
        type: "POST",
        data: {
            questionnaire_id: "{{ $questionnaire->id ?? null }}",
            current_version: "{{ $questionnaire->version ?? null }}",
            _token: "{{ csrf_token() }}"
        },
        success: function(response){
            $('#version').val(response.version);
        }
    });

});
</script>

