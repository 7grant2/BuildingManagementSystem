<!--
file:///Users/glanham/Documents/CurrentProjects/BuildingManagementSystem/build/index.html
-->
<!DOCTYPE html>
<html>
  <header>
    <title>Building Management System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <nav class="navbar navbar-default">
      <div class="container-fluid">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="#">Brand</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Login</a></li>
	    <!--
	    <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
		<li><a href="#">Action</a></li>
		<li><a href="#">Another action</a></li>
		<li><a href="#">Something else here</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="#">Separated link</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="#">One more separated link</a></li>
              </ul>
            </li>
	    --->
	  </ul>
	  <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Link</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
		<li><a href="#">Action</a></li>
		<li><a href="#">Another action</a></li>
		<li><a href="#">Something else here</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="#">Separated link</a></li>
              </ul>
            </li>
	  </ul>
	</div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </header>
  <body>
    <div class="jumbotron">
      <div class="row text-center">
	  <h1>Building Management System</h1>
	</div>
    </div>
    
    <div class="jumbotron">
      <div class="row justify-content-center">
	<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-6 col-xs-offset-3">
	  <div class="text-center">
	    <h2>login</h2>
	  </div>
	     <form>
	       <input class="form-control search-query d-flex" type="text" placeholder="Username">
   	       <input class="form-control d-flex" type="password" placeholder="Password">
	       <button class="btn-info form-control d-flex" type="submit">Login</button>
	     </form>
	     <div class="text-center">
		 <a href="#">Register</a> - 
		 <a href="#">Forgot Password</a>
	     </div>
	   </div>
      </div>
    </div>
    <script src="js/bootstrap.min.js">
  </body>
</html>
