<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="post_id" class="form-label">{{ __('Post Id') }}</label>
            <input type="text" name="post_id" class="form-control @error('post_id') is-invalid @enderror" value="{{ old('post_id', $postTag?->post_id) }}" id="post_id" placeholder="Post Id">
            {!! $errors->first('post_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tag" class="form-label">{{ __('Tag') }}</label>
            <input type="text" name="tag" class="form-control @error('tag') is-invalid @enderror" value="{{ old('tag', $postTag?->tag) }}" id="tag" placeholder="Tag">
            {!! $errors->first('tag', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>