<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CI CRUD</title>
		<script type="text/javascript">
			function show_confirm(act,gotoid){
				if(act=="edit"){
					var r=confirm("Do you really want to edit?");
				}
				else{
					var r=confirm("Do you really want to delete?");
				}
				if (r==true){
					window.location="<?php echo base_url();?>index.php/users/"+act+"/"+gotoid;
					//index.php/users/edit/# | edit(#) on users.php
					//index.php/users/delete/# | delete(#) on users.php
				}
			}
		</script>
	</head>
	<body>
		<h2> Simple CI CRUD Application </h2>
		<table width="600" border="1" cellpadding="5">
			<tr>
				<th scope="col">Id</th>
				<th scope="col">User Name</th>
				<th scope="col">Email</th>
				<th scope="col">Mobile</th>
				<th scope="col">Address</th>
				<th scope="col" colspan="2">Action</th>
			</tr>
			<?php
			foreach ($user_list as $u_key){//does this mean foreach ($data['$user_list'] as $u_key)... where are the session variables???
			?>
			<tr>
					<td>
						<?php echo $u_key->id;//shouldnt it be $id or 'id'? ?>
					</td>
					<td>
						<?php echo $u_key->name; ?>
					</td>
					<td>
						<?php echo $u_key->email; ?>
					</td>
					<td>
						<?php echo $u_key->address; ?>
					</td>
					<td>
						<?php echo $u_key->mobile; ?>
					</td>
					<td width="40" align="left" >
						<a href="#" onClick="show_confirm('edit',<?php echo $u_key->id;//the php here makes my head spin, it only makes sense if the above 'mobile'...etc. function as variables despite lacking the $ symbol?>)">Edit</a>
					</td>
					<td width="40" align="left" >
						<a href="#" onClick="show_confirm('delete',<?php echo $u_key->id;//same as above here here?>)">Delete </a>
					</td>
			</tr>
			<?php }//this popping in and out should be messing with the logic, i wonder why it isnt??>
			<tr>
				<td colspan="7" align="right">
					<a href="<?php echo base_url();?>index.php/users/add_form">Insert New User</a>
					<!--users.php's function add_form(), it sends users to insert.php -->
				</td>
			</tr>
		</table>
	</body>
</html>
