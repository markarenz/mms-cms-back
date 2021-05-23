<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/"><img src="{{ asset('img/logo.svg') }}" Alt="Mark Makes Stuff" /></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Dashboard <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Pages
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/pages">All Pages</a>
          <a class="dropdown-item" href="/page-new">New Page</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Posts
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/posts">All Posts</a>
          <a class="dropdown-item" href="/post-new">New Post</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Projects
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/projects">All Projects</a>
          <a class="dropdown-item" href="/project-new">New Projects</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/images">Images</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/publish">Publish</a>
      </li>

      <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
    </ul>
    @guest
    <a class="btn btn-outline-danger my-2 my-sm-0" href="/login">Log In</a>
    @endguest
    @auth
      <a class="btn btn-outline-danger my-2 my-sm-0" href="/logout">Logout</a>
    @endauth
  </div>
</nav>
