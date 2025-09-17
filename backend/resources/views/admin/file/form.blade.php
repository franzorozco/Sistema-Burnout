<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="owner_user_id" class="form-label">{{ __('Owner User Id') }}</label>
            <input type="text" name="owner_user_id" class="form-control @error('owner_user_id') is-invalid @enderror" value="{{ old('owner_user_id', $file?->owner_user_id) }}" id="owner_user_id" placeholder="Owner User Id">
            {!! $errors->first('owner_user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="related_type" class="form-label">{{ __('Related Type') }}</label>
            <input type="text" name="related_type" class="form-control @error('related_type') is-invalid @enderror" value="{{ old('related_type', $file?->related_type) }}" id="related_type" placeholder="Related Type">
            {!! $errors->first('related_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="related_id" class="form-label">{{ __('Related Id') }}</label>
            <input type="text" name="related_id" class="form-control @error('related_id') is-invalid @enderror" value="{{ old('related_id', $file?->related_id) }}" id="related_id" placeholder="Related Id">
            {!! $errors->first('related_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="filename" class="form-label">{{ __('Filename') }}</label>
            <input type="text" name="filename" class="form-control @error('filename') is-invalid @enderror" value="{{ old('filename', $file?->filename) }}" id="filename" placeholder="Filename">
            {!! $errors->first('filename', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="url" class="form-label">{{ __('Url') }}</label>
            <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $file?->url) }}" id="url" placeholder="Url">
            {!! $errors->first('url', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="mime_type" class="form-label">{{ __('Mime Type') }}</label>
            <input type="text" name="mime_type" class="form-control @error('mime_type') is-invalid @enderror" value="{{ old('mime_type', $file?->mime_type) }}" id="mime_type" placeholder="Mime Type">
            {!! $errors->first('mime_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="size_bytes" class="form-label">{{ __('Size Bytes') }}</label>
            <input type="text" name="size_bytes" class="form-control @error('size_bytes') is-invalid @enderror" value="{{ old('size_bytes', $file?->size_bytes) }}" id="size_bytes" placeholder="Size Bytes">
            {!! $errors->first('size_bytes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="checksum" class="form-label">{{ __('Checksum') }}</label>
            <input type="text" name="checksum" class="form-control @error('checksum') is-invalid @enderror" value="{{ old('checksum', $file?->checksum) }}" id="checksum" placeholder="Checksum">
            {!! $errors->first('checksum', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>