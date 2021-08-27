@section('pageTitle', 'New Post')

@extends('layouts.app')

@section('content')

@if($errors)
  @foreach($errors->all() as $message)
  <div class="error">{{ $message }}</div>
  @endforeach
@endif


<div class="row">
  <div class="col-md-6">
    <h1>New Post</h1>
  </div>
  <div class="col-md-6 text-right">
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
   <form role="form" id="form-edit" method="POST" action="/post-create" enctype="multipart/form-data">
     {{ csrf_field() }}

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Post Title</label>
            <input value="{{ old('title') }}" name="title" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Post Slug</label>
            <input value="{{ old('slug') }}" name="slug" id="slug" class="form-control">
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Status</label>
            <select value="{{ old('status') }}" name="status" class="form-control">
              <option value="0" @php if (old('status')==0){ echo " SELECTED ";}@endphp>Draft</option>
              <option value="1" @php if (old('status')==1){ echo " SELECTED ";}@endphp>Published</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Date</label>
            <input value="{{ old('pub_date') }}" name="pub_date" id="pub_date" class="form-control datepicker">
          </div>
        </div>
      </div>


      <div class="form-group">
        <label>Meta Description</label>
        <textarea name="metadesc" class="form-control" rows="3">{{ old('metadesc') }}</textarea>
      </div>

      <div class="form-group">
        <label>Post Content</label>
        <textarea name="content" class="form-control textarea-tall input-code" style="height:400px;">{{ old('content') }}</textarea>
      </div>

    </form>

    <div class="text-right">
        <button type="button" class="btn btn-outline-primary"onclick="$('#form-edit').submit();">Start</button>
    </div>
    @include('partials.classes-for-posts')

  </div>
</div><!-- /.row -->



@endsection
