<?php
//fetch.php
include("database_connection.php");

$query = "SELECT * FROM users";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table class="table table-striped table-bordered">
	<tr>
		<th>No.</th>
		<th>user_mobile</th>
		<th>join_date</th>
      <th>coin</th>
      <th>Edit</th>
      <th>Delete</th>
	</tr>
';
if($total_row > 0)
{
   $i = 0;

   foreach($result as $row)
	{
      $i += 1;
      $output .= '
		<tr>
         <td>'.$i.'</td>
         <td>'.$row["user_mobile"].'</td>
         <td>'.$row["join_date"].'</td>
         <td>'.number_format($row["user_coin"]).'</td>
			<td>
				<button type="button" name="edit" class="btn btn-primary btn-small edit" id="'.$row["user_id"].'">Edit</button>
			</td>
			<td>
				<button type="button" name="delete" class="btn red btn-small delete" id="'.$row["user_id"].'">Delete</button>
			</td>
		</tr>
		';
	}
}
else
{
	$output .= '
	<tr>
		<td colspan="4" align="center">Data not found</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;

?>