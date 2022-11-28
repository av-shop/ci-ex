<?php echo $header;?>
    
<h1>Add new user</h1>

<form method="post"action="/" enctype="multipart/form-data">
<div class="container">
<input type="text" placeholder="Name" name="name" required>
<input type="email" placeholder="Email" name="email" required>
<div class="inputContainer">
<label class="button avatarbtn"for="avatar">Upload avatar</label>
<input type="file" id="avatar"name="avatar">
</div>
<div class="buttonContainer"><button type="submit" class="button registerButton">Create</button></div>
</div> 
</form>

<?php echo $footer;?>