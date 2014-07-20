<div id="control-panel">
<div class="left">
         <ul>
           <li><a href="<?=base_url()?>control-panel/account-settings/">Account Settings</a></li>
           <li><a href="<?=base_url()?>control-panel/my-venues/">My Venues</a></li>
           <li><a href="<?=base_url()?>control-panel/my-events/">My Events</a></li>
          </ul>
</div>
<div class="right">
<h2><?=$username?> manage your venues</h2>
<p class="updated"><?=(isset($updated))?$updated:false?></p>
<table cellspacing="0">
			<thead>
				<tr>
					</tr><tr>
					<th class="first">Venues</th>
                    <th>Posted</th>
                    <th>Edit</th>
                    <th class="tc last">Delete</th>
				</tr>
			</thead>
			<tbody>
 <?php foreach($venues as $venue): ?>             
				<tr>
					</tr><tr>
					<td class="first"><?=$venue->place?></td>
                    <td><?=date("m/d/Y H:i",$venue->posted_time)?></td>
                    <td><a href="<?=base_url()?>control-panel/my-venues/edit/<?=$venue->id?>">Edit</a></td>
                    <td class="tc last"><a href="<?=base_url().'delete/venue_delete/'.$venue->id .'/true' ?>">Delete</a></td>
				</tr>
 <?php endforeach; ?>               
            </tbody>
</table>
</div><div class="clear"></div>
</div>