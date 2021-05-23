@section('pageTitle', 'Edit Page')

@extends('layouts.app')

@section('content')

<!-- CONTENT BLCOK DEFINITIONS -->
<script type="text/javascript" language="javascript" src="/js/pagebuilder/block_definitions.js"></script>

<div class="row">
  <div class="col-md-12">
    <h1>Edit Page: {{ $page->title }}</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="text-right">
        <a href="/" id="btn-view-page" class="btn btn-outline-success" target="_blank">VIEW</a>
        <button type="button" class="btn btn-outline-primary"onclick="$('#form-edit').submit();">Save</button>
    </div>

   <form role="form" id="form-edit" method="POST" action="/page-update/{{ $page->id }}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{csrf_token()}}" />

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Page Title</label>
            <input value="{{ $page->title }}" name="title" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Page Slug</label>
            <input value="{{ $page->slug }}" name="slug" id="slug" class="form-control">
          </div>
        </div>
      </div>


      <div class="form-group">
        <label>Status</label>
        <select value="{{ $page->status }}" name="status" class="form-control">
          <option value="0" @php if ($page->status==3){ echo " SELECTED ";}@endphp>Draft</option>
          <option value="1" @php if ($page->status==1){ echo " SELECTED ";}@endphp>Published</option>
          <!-- <option value="2" @php if ($page->status==2){ echo " SELECTED ";}@endphp>Revision</option> -->
        </select>
      </div>


      <div class="form-group">
        <label>Meta Description</label>
        <textarea name="metadesc" class="form-control" rows="3">{{$page->metadesc}}</textarea>
      </div>

      <div class="row">
        <div class="col-md-6">
          <h2>Content</h2>
        </div>
        <div class="col-md-6">
          <div class="btn-group btn-group-toggle pull-right" data-toggle="buttons">
            <label class="btn btn-secondary active" onclick="set_ui_mode('ui');">
              <input type="radio" name="options" id="option1" autocomplete="off" checked> Page Builder
            </label>
            <label class="btn btn-secondary" onclick="set_ui_mode('raw');">
              <input type="radio" name="options" id="option2" autocomplete="off"> Raw
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">

        <div id="content-raw" class="pt-2" style="display:none;">
          <textarea name="content" class="form-control textarea-tall input-code" style="height:400px;">{{ $page->content }}</textarea>
        </div>
        <div id="content-ui" class="pt-2">
          <div id="content-ui-stage">
          </div>
        </div>
      </div>


    </form>
    <form role="form" id="form-delete" method="POST" action="/admin/delete-page/{{$page->id}}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{csrf_token()}}" />
    </form>

    <div class="text-right">
        <button type="button" class="btn btn-outline-danger" onclick="if (confirm('Are you sure you want to delete?')){$('#form-delete').submit();}">Delete</button>
        <button type="button" class="btn btn-outline-primary"onclick="$('#form-edit').submit();">Save</button>
    </div>

  </div>
</div><!-- /.row -->
<script src="/js/pagebuilder/pb_functions.js"></script>
<script src="/js/pagebuilder/pb_functions_images.js"></script>
<script>
  var editor={};
  editor.mode='ui';
  $(function(){
    block_library.sort(sort_block_library);
    update_slug();
    update_slug_init();
    enable_tabs_for_textareas();
    init_ui();
  });
</script>
@endsection
