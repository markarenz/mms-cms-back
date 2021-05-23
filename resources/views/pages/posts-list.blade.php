@section('pageTitle', 'Posts')

@extends('layouts.app')

@section('content')
@php $status_labels=array('Draft','Published'); @endphp

<div class="row">
  <div class="col-md-6">
    <h1>Posts</h1>
  </div>
  <div class="col-md-6 text-right">
    <a href="/post-new" class="btn btn-outline-success my-2 my-sm-0">New Post</a>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter">
        <thead>
          <tr>
            <th class="header">ID </th>
            <th class="header">Title </th>
            <th class="header">Status </th>
            <th class="header">Date Published </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
            <tr>
              <td>{{$post->id}}</td>
              <td>{{$post->title}}</td>
              <td>{{$status_labels[$post->status]}}</td>
              <td>{{ date ("m/d/Y", strtotime($post->pub_date)) }}</td>
              <td>
                <a class="btn btn-outline-primary" href="/post-edit/{{$post->id}}" role="button">Edit Post</a>
                <a class="btn btn-outline-danger" href="#" role="button" onclick="$('#form_del_{{$post->id}}').submit(); return false;">Delete Post</a>
                <form id="form_del_{{$post->id}}" action="/post-delete/{{$post->id}}" method="POST">
                  {{ csrf_field() }}
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>


@endsection
