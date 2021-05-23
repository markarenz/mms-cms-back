@section('pageTitle', 'Images')

@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-6">
    <h1>Images</h1>
  </div>
  <div class="col-md-6 text-right">
    <button class="btn btn-outline-success my-2 my-sm-0" onclick="$('#img-upload-form').toggle();return false;">Upload Image</button>
  </div>
</div>
<div class="hidden pt-5 pb-5" id="img-upload-form">
  <form class="form-horizontal" method="POST" action="/image-upload" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-3 text-center">
        <input type="file" name="upload" id="upload" class="form-control" />
      </div>
      <div class="col-md-6 text-center">
        <input type="text" name="alt" class="form-control" required placeholder="alt"/>
      </div>
      <div class="col-md-3 text-center">
        <button type="submit" class="btn btn-primary">
            Upload
        </button>
      </div>
    </div>
  </form>
</div>

<table class="table">
  <thead>
    <tr>
      <th>
        ID
      </th>
      <th>
        Alt
      </th>
      <th>
        Filename
      </th>
      <th>
        Thumbnail
      </th>
      <th>
        Actions
      </th>
    </tr>
  </thead>
  <tbody>
    @if(count($images)>0)
      @foreach($images->all() as $image)
        <tr>
          <td>
            {{$image->id}}
          </td>
          <td>
            {{$image->alt}}
          </td>
          <td>
            <a href="{{ env( 'IMAGE_REMOTE_PATH' ) }}{{ $image->filename }}" class="lightbox">{{$image->filename}}</a>
          </td>
          <td>
            <a href="{{ env( 'IMAGE_REMOTE_PATH' ) }}{{ $image->filename }}" class="lightbox">
              <img src="{{ env( 'IMAGE_REMOTE_PATH' ) }}thumb--{{$image->filename}}" alt="{{$image->alt}}" style="width:100px;height:100px;">
            </a>
          </td>
          <td>
            <form action="image-delete/{{ $image->id }}" method="POST" id="del_form_{{ $image->id }}">
              {{ csrf_field() }}
            </form>
            <button class="btn btn-outline-danger" onclick="$('#del_form_{{ $image->id }}').submit()">DELETE</button>
          </td>
        </tr>
      @endforeach
    @else
      <tr>
        <td colspan="3">
          0 Results
        </td>
      </tr>
    @endif
  </tbody>
</table>
<script>
$(function() {
  $('input[type="file"]').change(function(e){
      var fileName = e.target.files[0].name;
      fileName=fileName.split('_').join(' ');
      fileName=fileName.split('-').join(' ');
      fileName=fileName.split('.').slice(0, -1).join('.');
      fileName=ucFirst(fileName);

      $('input[name="alt"]').val(fileName);
  });
});
</script>
@endsection
