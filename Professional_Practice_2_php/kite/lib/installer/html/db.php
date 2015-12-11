
	<form class="form-horizontal " role="form" action="" method="post">
	<div class="well well-sm">
	<p><b>General Information</b></p>
	</div>
	<div class="form-group">
    <label class="col-lg-3 control-label">Site Name</label>
    <div class="col-lg-9">
      <input class="form-control"name="name" type="text" placeholder="Enter the desired site name" >
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Author</label>
    <div class="col-lg-9">
      <input class="form-control"name="name" type="text" placeholder="Enter your name" >
    </div>
  </div>
  	<div class="well well-sm">
	<b>Database Setup</b>
	</div>
	<div class="form-group">
    <label class="col-lg-3 control-label">DB Type</label>
    <div class="col-lg-9">
      <input class="form-control" id="disabledInput" type="text" placeholder="MySQL" disabled>
    </div>
  </div>
  <div class="form-group">
    <label for="" class="col-lg-3 control-label">Host</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="host" placeholder="hostname">
	   <span class="help-block">This is usually 'localhost'</span>
    </div>
  </div>
  <div class="form-group">
    <label  class="col-lg-3 control-label">DB Name</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="db_name" placeholder="Enter the Database name">
    </div>
  </div>
 <div class="form-group">
    <label class="col-lg-3 control-label">root user</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="username" placeholder="username">
	  <span class="help-block">This is usually 'root' or a username given by host</span>
    </div>
  </div>
   <div class="form-group">
    <label class="col-lg-3 control-label">password</label>
    <div class="col-lg-9">
      <input type="password" class="form-control" name="password" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
  <label class="col-lg-3 control-label">&nbsp;</label>
    <div class=" col-lg-9">
      <button type="submit" class="btn btn-info">Create</button>
    </div>
  </div>
</form>

