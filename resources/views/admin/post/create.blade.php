@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">{{ __('Write New Post') }}</div>
    <div class="card-body">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label>{{ __('Post Title') }}</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>{{ __('Post Type') }}</label>
                    <select name="type" class="form-select">
                        <option value="disease">{{ __('Pathology & Prevention') }}</option>
                        <option value="news">{{ __('Medical News') }}</option>
                        <option value="invention">{{ __('Medical Invention') }}</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>{{ __('Image Link (URL)') }}</label>
                    <input type="text" name="image" class="form-control" placeholder="https://...">
                </div>
            </div>

            <div class="mb-3">
                <label>{{ __('Short Summary (Show on Homepage)') }}</label>
                <textarea name="summary" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label>{{ __('Detailed Content') }}</label>
                <textarea name="content" class="form-control" rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-success">{{ __('Publish Post') }}</button>
        </form>
    </div>
</div>
@endsection