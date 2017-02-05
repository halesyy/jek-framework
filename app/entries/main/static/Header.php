<div id="header" style="background-image: url({{ header_image }})" class="background-image">
    <nav class="navbar navbar-default">
      <div class="container-fluid header-container">
        <div class="container horizontal-container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-partition" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#!/home">{{ site_logo_name }}</a>
        </div>
        <div class="collapse navbar-collapse" id="collapse-partition" style="">
          <ul class="nav navbar-nav triggerable-links">
            {{ triggerable }}
          </ul>
          <ul class="nav navbar-nav navbar-right triggerable-links">
            @if signedin
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  {{{ User, Username }}}
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </li>
            @else
              <li><a class="navbar-link farleft-link" href="#!/login">Login</a></li>
              <li><a class="navbar-link" href="#!/register">Register</a></li>
            @endif
          </ul>
        </div>
        </div>
      </div>
    </nav>
</div>
