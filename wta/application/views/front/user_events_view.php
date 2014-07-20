<div id="control-panel">
<div class="left">
         <ul>
           <li><a href="<?=base_url()?>control-panel/account-settings/">Account Settings</a></li>
           <li><a href="<?=base_url()?>control-panel/my-venues/">My Venues</a></li>
           <li><a href="<?=base_url()?>control-panel/my-events/">My Events</a></li>
          </ul>
</div>
<div class="right">
<h2><?=$username?> manage your events</h2>
<p class="updated"><?=(isset($updated))?$updated:false?></p>
<table cellspacing="0">
			<thead>
				<tr>
					</tr><tr>
					<th class="first">Event</th>
                    <th>Posted</th>
                    <th>Edit</th>
                    <th class="tc last">Delete</th>
				</tr>
			</thead>
			<tbody>
 <?php foreach($events as $event): ?>             
				<tr>
					</tr><tr>
					<td class="first"><?=$event->title?></td>
                    <td><?=date("m/d/Y H:i",$event->posted_time)?></td>
                    <td><a href="<?=base_url()?>control-panel/my-events/edit/<?=$event->id?>">Edit</a></td>
                    <td class="tc last"><a href="<?=base_url().'delete/event_delete/'.$event->id .'/true' ?>">Delete</a></td>
				</tr>
 <?php endforeach; ?>               
            </tbody>
</table>
</div><div class="clear"></div>
</div>