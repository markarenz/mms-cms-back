@section('pageTitle', 'Publish')

@extends('layouts.app')

@section('content')

<h1>Publishing</h1>


<div class="row container pt-5">
  <div class="col-md-12 text-center">
    <h2>Pages:</h2>
    <a href="/push-pages-staging" class="btn btn-outline-primary"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Staging: Pages</a>
    &nbsp;
    <a href="/push-pages-production" class="btn btn-outline-danger"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Production: Pages</a>
  </div>
</div>

<div class="row container pt-5">
  <div class="col-md-12 text-center">
    <h2>Posts:</h2>
    <a href="/push-posts-staging" class="btn btn-outline-primary"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Staging: Posts</a>
    &nbsp;
    <a href="/push-posts-production" class="btn btn-outline-danger"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Production: Posts</a>
  </div>
</div>

<div class="row container pt-5">
  <div class="col-md-12 text-center">
    <h2>Projects:</h2>
    <a href="/push-projects-staging" class="btn btn-outline-primary"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Staging: Projects</a>
    &nbsp;
    <a href="/push-projects-production" class="btn btn-outline-danger"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Production: Projects</a>
  </div>
</div>



<!-- <a href="{{ config('app.front_url_staging') }}" target="_blank" class="btn btn-outline-success">View Staging</a>
<a href="{{ config('app.front_url_production') }}" target="_blank" class="btn btn-outline-success">View Production</a> -->



@endsection
