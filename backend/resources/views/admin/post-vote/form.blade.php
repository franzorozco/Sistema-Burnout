<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('User Id') }}</label>
            <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id', $postVote?->user_id) }}" id="user_id" placeholder="User Id">
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="post_id" class="form-label">{{ __('Post Id') }}</label>
            <input type="text" name="post_id" class="form-control @error('post_id') is-invalid @enderror" value="{{ old('post_id', $postVote?->post_id) }}" id="post_id" placeholder="Post Id">
            {!! $errors->first('post_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="comment_id" class="form-label">{{ __('Comment Id') }}</label>
            <input type="text" name="comment_id" class="form-control @error('comment_id') is-invalid @enderror" value="{{ old('comment_id', $postVote?->comment_id) }}" id="comment_id" placeholder="Comment Id">
            {!! $errors->first('comment_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="vote" class="form-label">{{ __('Vote') }}</label>
            <input type="text" name="vote" class="form-control @error('vote') is-invalid @enderror" value="{{ old('vote', $postVote?->vote) }}" id="vote" placeholder="Vote">
            {!! $errors->first('vote', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>