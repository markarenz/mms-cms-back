@section('pageTitle', 'New Page')

@extends('layouts.app')

@section('content')


<div class="row">
  <div class="col-md-6">
    <h1>New Page</h1>
  </div>
  <div class="col-md-6 text-right">
  </div>
</div>

<div class="row">
	<div class="col-lg-12">

        <form role="form" method="POST" action="/page-create" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
              <label>Page Title</label>
              <input name="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="form-group">
              <label>Slug</label>
              <input name="slug" class="form-control" value="{{ old('slug') }}">
            </div>

            <!-- You will enter content on the next screen -->
            <input type="hidden" name="content" class="form-control" value="[]">

            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="1">Published</option>
                <option value="2">Revision</option>
              </select>
            </div>

            <div class="form-group">
              <label>Meta Description</label>
              <textarea name="metadesc" class="form-control" rows="3">{{ old('metadesc') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Start</button>
        </form>
    </div>
</div>



@endsection
