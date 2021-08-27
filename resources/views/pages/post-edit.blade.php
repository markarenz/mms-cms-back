@section('pageTitle', 'Edit Post')

@extends('layouts.app')

@section('content')

@if($errors)
  @foreach($errors->all() as $message)
  <div class="error">{{ $message }}</div>
  @endforeach
@endif


<div class="row">
  <div class="col-md-12">
    <h1>Edit Post: {{ $post->title }}</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="text-right">
        <a href="/" id="btn-view-post" class="btn btn-outline-success" target="_blank">VIEW</a>
        <button type="button" class="btn btn-outline-primary"onclick="$('#form-edit').submit();">Save</button>
    </div>

   <form role="form" id="form-edit" method="POST" action="/post-update/{{ $post->id }}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{csrf_token()}}" />

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Post Title</label>
            <input value="{{ $post->title }}" name="title" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Post Slug</label>
            <input value="{{ $post->slug }}" name="slug" id="slug" class="form-control">
            @if ($errors->has('slug'))
                <span class="help-block">
                    <strong>{{ $errors->first('slug') }}</strong>
                </span>
            @endif
          </div>
        </div>
      </div>


      <div class="form-group">
        <label>Status</label>
        <select value="{{ $post->status }}" name="status" class="form-control">
          <option value="0" @php if ($post->status==0){ echo " SELECTED ";}@endphp>Draft</option>
          <option value="1" @php if ($post->status==1){ echo " SELECTED ";}@endphp>Published</option>
          <!-- <option value="2" @php if ($post->status==2){ echo " SELECTED ";}@endphp>Revision</option> -->
        </select>
      </div>


      <div class="form-group">
        <label>Meta Description (<span id="metadesc_count">0</span>)</label>
        <textarea name="metadesc" id="metadesc" class="form-control" rows="3" onkeyup="meta_desc_keyup();">{{$post->metadesc}}</textarea>
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
            $tmp2=env( 'IMAGE_REMOTE_PATH' ) . "posts/" . "thumb--" . $post->id . ".jpeg";
            echo $tmp2;
          @endphp" alt="Preview" class="img-preview">
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Publication Date</label>
            <input value="{{ $post->pub_date }}" name="pub_date" id="pub_date" class="form-control datepicker">
          </div>
        </div>
      </div>



      <div class="form-group">
        <label>Post Content</label>
        <textarea name="content" class="form-control textarea-tall input-code" style="height:400px;">{{ $post->content }}</textarea>
      </div>

    </form>
    <form role="form" id="form-delete" method="POST" action="/admin/delete-page/{{$post->id}}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{csrf_token()}}" />
    </form>

    <div class="text-right">
        <button type="button" class="btn btn-outline-danger" onclick="if (confirm('Are you sure you want to delete?')){$('#form-delete').submit();}">Delete</button>
        <button type="button" class="btn btn-outline-primary"onclick="$('#form-edit').submit();">Save</button>
    </div>
    @include('partials.classes-for-posts')

  </div>
</div><!-- /.row -->
<script src="/js/pagebuilder/pb_functions.js"></script>
<script src="/js/pagebuilder/pb_functions_images.js"></script>
<script>
  var editor={};
  editor.mode='ui';
  $(function(){
    // block_library.sort(sort_block_library);
    update_slug();
    update_slug_init();
    enable_tabs_for_textareas();
    // init_ui();
    meta_desc_keyup();
  });
  function meta_desc_keyup(){
    console.log('??');
    var length=$('#metadesc').val().length;
    $('#metadesc_count').html(length);
  }
</script>
@endsection
