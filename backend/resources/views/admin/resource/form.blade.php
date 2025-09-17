<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="title" class="form-label">{{ __('Title') }}</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $resource?->title) }}" id="title" placeholder="Title">
            {!! $errors->first('title', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="type" class="form-label">{{ __('Type') }}</label>
            <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $resource?->type) }}" id="type" placeholder="Type">
            {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="summary" class="form-label">{{ __('Summary') }}</label>
            <input type="text" name="summary" class="form-control @error('summary') is-invalid @enderror" value="{{ old('summary', $resource?->summary) }}" id="summary" placeholder="Summary">
            {!! $errors->first('summary', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="content" class="form-label">{{ __('Content') }}</label>
            <input type="text" name="content" class="form-control @error('content') is-invalid @enderror" value="{{ old('content', $resource?->content) }}" id="content" placeholder="Content">
            {!! $errors->first('content', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="url" class="form-label">{{ __('Url') }}</label>
            <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $resource?->url) }}" id="url" placeholder="Url">
            {!! $errors->first('url', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="author_id" class="form-label">{{ __('Author Id') }}</label>
            <input type="text" name="author_id" class="form-control @error('author_id') is-invalid @enderror" value="{{ old('author_id', $resource?->author_id) }}" id="author_id" placeholder="Author Id">
            {!! $errors->first('author_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="validated_by" class="form-label">{{ __('Validated By') }}</label>
            <input type="text" name="validated_by" class="form-control @error('validated_by') is-invalid @enderror" value="{{ old('validated_by', $resource?->validated_by) }}" id="validated_by" placeholder="Validated By">
            {!! $errors->first('validated_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="validated_at" class="form-label">{{ __('Validated At') }}</label>
            <input type="text" name="validated_at" class="form-control @error('validated_at') is-invalid @enderror" value="{{ old('validated_at', $resource?->validated_at) }}" id="validated_at" placeholder="Validated At">
            {!! $errors->first('validated_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tags" class="form-label">{{ __('Tags') }}</label>
            <input type="text" name="tags" class="form-control @error('tags') is-invalid @enderror" value="{{ old('tags', $resource?->tags) }}" id="tags" placeholder="Tags">
            {!! $errors->first('tags', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>