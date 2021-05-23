@section('pageTitle', 'Edit Project')

@extends('layouts.app')

@section('content')

@if($errors)
  @foreach($errors->all() as $message)
  <div class="error">{{ $message }}</div>
  @endforeach
@endif

<div class="row">
  <div class="col-md-12">
    <h1>Edit Project: {{ $project->title }}</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="text-right">
        <a href="/" id="btn-view-project" class="btn btn-outline-success" target="_blank">VIEW</a>
        <button type="button" class="btn btn-outline-primary"onclick="$('#form-edit').submit();">Save</button>
    </div>

   <form role="form" id="form-edit" method="POST" action="/project-update/{{ $project->id }}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{csrf_token()}}" />

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Project Title</label>
            <input value="{{ $project->title }}" name="title" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Project Slug</label>
            <input value="{{ $project->slug }}" name="slug" id="slug" class="form-control">
          </div>
        </div>
      </div>


      <div class="form-group">
        <label>Status</label>
        <select value="{{ $project->status }}" name="status" class="form-control">
          <option value="0" @php if ($project->status==0){ echo " SELECTED ";}@endphp>Draft</option>
          <option value="1" @php if ($project->status==1){ echo " SELECTED ";}@endphp>Published</option>
          <!-- <option value="2" @php if ($project->status==2){ echo " SELECTED ";}@endphp>Revision</option> -->
        </select>
      </div>


      <div class="form-group">
        <label>Meta Description</label>
        <textarea name="metadesc" class="form-control" rows="3">{{$project->metadesc}}</textarea>
      </div>

      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Header Image (JPG 1920x700)</label>
            <input type="file" name="upload" id="upload" class="form-control">
          </div>
        </div>
        <div class="col-md-3">
          <img src="@php
            $tmp="/img/no-image.svg";
            $tmp2=env( 'IMAGE_REMOTE_PATH' ) . "projects/" . "thumb--" . $project->id . ".jpeg";
            echo $tmp2;
          @endphp" alt="Preview" class="img-preview">
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Publication Date</label>
            <input value="{{ $project->pub_date }}" name="pub_date" id="pub_date" class="form-control datepicker">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-2">
          <div class="form-group">
            <label>Gallery Image 1(JPG)</label>
            <input type="file" name="upload_1" id="upload_1" class="form-control">
          </div>
        </div>
        <div class="col-md-2">
          <img src="@php
            $tmp="/img/no-image.svg";
            $tmp2=env( 'IMAGE_REMOTE_PATH' ) . "projects/" . $project->id . "-1.jpeg";
            echo $tmp2;
          @endphp" alt="Preview" class="img-preview">
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Gallery Image 2 (JPG)</label>
            <input type="file" name="upload_2" id="upload_2" class="form-control">
          </div>
        </div>
        <div class="col-md-2">
          <img src="@php
            $tmp="/img/no-image.svg";
            $tmp2=env( 'IMAGE_REMOTE_PATH' ) . "projects/" . $project->id . "-2.jpeg";
            echo $tmp2;
          @endphp" alt="Preview" class="img-preview">
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Gallery Image 3 (JPG)</label>
            <input type="file" name="upload_3" id="upload_3" class="form-control">
          </div>
        </div>
        <div class="col-md-2">
          <img src="@php
            $tmp="/img/no-image.svg";
            $tmp2=env( 'IMAGE_REMOTE_PATH' ) . "projects/" . $project->id . "-3.jpeg";
            echo $tmp2;
          @endphp" alt="Preview" class="img-preview">
        </div>
      </div>


      <div class="row">
        <div class="col-md-2">
          <div class="form-group">
            <label>Gallery Image 4(JPG)</label>
            <input type="file" name="upload_4" id="upload_4" class="form-control">
          </div>
        </div>
        <div class="col-md-2">
          <img src="@php
            $tmp="/img/no-image.svg";
            $tmp2=env( 'IMAGE_REMOTE_PATH' ) . "projects/" . $project->id . "-4.jpeg";
            echo $tmp2;
          @endphp" alt="Preview" class="img-preview">
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Gallery Image 5 (JPG)</label>
            <input type="file" name="upload_5" id="upload_5" class="form-control">
          </div>
        </div>
        <div class="col-md-2">
          <img src="@php
            $tmp="/img/no-image.svg";
            $tmp2=env( 'IMAGE_REMOTE_PATH' ) . "projects/" . $project->id . "-5.jpeg";
            echo $tmp2;
          @endphp" alt="Preview" class="img-preview">
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Gallery Image 6 (JPG)</label>
            <input type="file" name="upload_6" id="upload_6" class="form-control">
          </div>
        </div>
        <div class="col-md-2">
          <img src="@php
            $tmp="/img/no-image.svg";
            $tmp2=env( 'IMAGE_REMOTE_PATH' ) . "projects/" . $project->id . "-6.jpeg";
            echo $tmp2;
          @endphp" alt="Preview" class="img-preview">
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Images ("123" for 3 images "1234" for 4)</label>
            <input value="{{ $project->images }}" name="images" id="images" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Link</label>
            <input value="{{ $project->link }}" name="link" id="link" class="form-control">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Project Description</label>
        <textarea name="content" class="form-control textarea-tall input-code" style="height:400px;">{{ $project->content }}</textarea>
      </div>


    </form>
    <form role="form" id="form-delete" method="POST" action="/admin/delete-page/{{$project->id}}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{csrf_token()}}" />
    </form>

    <div class="text-right">
        <button type="button" class="btn btn-outline-danger" onclick="if (confirm('Are you sure you want to delete?')){$('#form-delete').submit();}">Delete</button>
        <button type="button" class="btn btn-outline-primary"onclick="$('#form-edit').submit();">Save</button>
    </div>

  </div>
</div><!-- /.row -->
@endsection
