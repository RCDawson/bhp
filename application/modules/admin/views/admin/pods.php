<?php
// Give yourself some help
$empty = '<span class="empty">- empty -</span>';
?>
<div id="pods">
	<?php
		// Thanks to Joey, the same results using class files.
		echo $pods;
//		echo $divElement->render();
	?>
</div>

<div class="cms-30w pods-delete left">
	<label>Menus</label>
		<p class="cms-dash-pod">Main Nav</p>
   <label>Settings
	   <dl class="cms-controls">
		   <dd><a title="Edit: The Home Page" class="edit" href="/admin/edit/home"><span>Edit</span></a></dd>
		</dl>
	</label>
   		<div class="cms-dash-pod">
			<dl>
				<dt><a href="#">Admin Email</a></dt>
				<dd><?php echo $settings->admin_email; ?></dd>
				<dt><a href="#">Contact Info</a></dt>
				<dd><?php echo(!empty($page->co_info->name)) ? $page->co_info->name : $empty; ?></dd>
			</dl>
	    </div>
<?php /* @todo Keep this, or not?
	<label>Contact Info<span class="cms-controls"><a href="admin/contact_info/<?php echo $this->session->userdata('uid'); ?>" class="edit"><span>edit</span></a></span></label>
    <div class="cms-dash-pod">
        <?php if (!empty($co_info)) { ?>
            <dl class="vcard" id="desc_sml" contenteditable="true">
                <dd><span class="adr"><b><?php echo $co_info->name; ?></b></span><br>
                    <span class="street-address"><?php echo $co_info->address; ?></span><br>
                    <span class="locality"><?php echo $co_info->city; ?></span>, <span class="region"><?php echo $co_info->state; ?></span> <span class="postal-code">35222</span>, <span class="country">United States</span><br>
                    <span class="tel"><span class="value"><?php echo $co_info->phone; ?></span></span>
                </dd>
            </dl>
        <?php } else { ?>
            <p><em style="color:gray">Information has not been entered.</em></p>
        <?php } //End co_info ?>
    </div>
*/ ?>
</div>
<div class="cms-40w pods-delete left">
    <dl>
        <dt><label>Pages</label></dt>
        <?php if (!empty($pages)) { ?>
            <dd><ul class="manage">
                    <?php
                    $i = 0;
                    foreach ($pages as $page) {
                        $page->kids = array();
                        $k = 0;
                        foreach ($kids as $kid) {
                            if ($kid->parent_id == $page->id) {
                                $page->kids[$k]['title'] = $kid->title;
                                $page->kids[$k]['url'] = $kid->url;
                                // Done with ya kid.
                                unset($kids[$k]);
                                ++$k;
                            }
                        }
                        ?>
                        <li<?php //echo $i%2==1 ? ' class="alt"' : '';  ?>>
                            <?php $action = $page->parent > 0 ? 'Manage' : 'Edit'; ?>
                            <a href="<?php echo '/admin/edit/' . $page->url ?>" title="<?php echo $action ?> <?php echo $page->title ?>"><b><?php echo $page->title ?></b></a>
                            <dl class="cms-controls">
                                <?php if (!empty($page->kids)) { ?>
                                    <dd><a href="/admin/edit/<?php echo $page->url; ?>/list" class="children" title="Edit content of '<?php echo $page->title; ?>'"><span>Edit Child Pages of </span></a></dd>
                                <?php } ?>
                                <dd><a href="/admin/edit/<?php echo $page->url; ?>" class="edit" title="Edit: <?php echo $page->title; ?>"><span>Edit</span></a></dd>
                            </dl>
                            <?php echo '<p>'/* . /character_limiter(strip_tags($page->description),80) . */ . '</p>' ?>
                        </li>
                        <?php $i++;
                    } unset($kids); ?>
                </ul></dd>
        <?php } else { ?>
            <dd class="info warning"><span class="icon">&nbsp;</span> No pages have been created.</dd>
<?php } ?>
</div>
<div class="cms-30w right pods-delete">
   <label>Sidebars</label>
   <?php echo $sidebars; ?>
   <?php if (!empty($page->blog)) { ?>
        <form>
            <label>Quick Post</label>
        </form>
<?php } ?>
</div>