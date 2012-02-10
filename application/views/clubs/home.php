<div class="clubHome">
	<h1>Clubs</h1>
	<ul>
		<li><?=anchor('club/create', "Add New Club");?></li>
	</ul>
	<h2>Your Clubs</h2>
	<? foreach($user_clubs as $row): ?>
		<table class="clubList">	
			<thead>
				<tr>
					<td>Edit</td>
					<td>Club Name</td>
					<td>Description</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?=anchor('club/edit/'.$row['club_id'],'Edit')?></td>
					<td><?=anchor('club/view/'.$row['club_id'], $row['club_name'])?></td>
					<td><?=$row['description']?></td>
				</tr>
			</tbody>
		</table>
	<? endforeach; ?>
</div>