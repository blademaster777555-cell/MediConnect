@extends('layouts.admin')

@section('title', __('Add New Post'))

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Add New Post') }}</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('medical-content.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="title" class="form-label font-weight-bold">{{ __('Post Title') }}</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label font-weight-bold">{{ __('Category') }}</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">{{ __('-- Select Category --') }}</option>
                            <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>{{ __('Medical News') }}</option>
                            <option value="disease" {{ old('category') == 'disease' ? 'selected' : '' }}>{{ __('Pathology & Prevention') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="published_date" class="form-label font-weight-bold">{{ __('Published Date') }}</label>
                        <input type="date" class="form-control" id="published_date" name="published_date" value="{{ old('published_date', date('Y-m-d')) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label font-weight-bold">{{ __('Thumbnail Image') }}</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label font-weight-bold">{{ __('Content') }}</label>
                    <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('medical-content.index') }}" class="btn btn-secondary me-2">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Save Post') }}</button>
                </div>
            </form>
        </div>
    </div>
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
            // Note: Image upload requires backend adapter. Users can link images or paste if base64 plugin enabled (not default in basic build without config).
            // For now, basic text formatting is better than nothing.
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
