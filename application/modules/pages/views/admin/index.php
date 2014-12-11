    <div class="cms-50w left">

        <?php if( $rows ):?>

        <ul class="manage">
                <?php $i=0;
        foreach( $rows as $row ):?>
            <li<?php echo $i%2==1 ? ' class="alt"' : ''; ?>>

            <?php $action = $row->parent > 0 ? 'Manage' : 'Edit'; ?>
                <a href="<?php echo current_url() . '/edit/' . $row->id ?>" title="<?php echo $action?> <?php echo $row->title?>"><b><?php echo $row->title?></b></a>

                <dl class="cms-controls">
            <?php if( $row->parent > 0 ) { ?>
                    <dd><a href="<?php echo current_url(); ?>/manage/<?php echo $row->id?>" class="children" title="Manage content of '<?php echo $row->title; ?>'"><span>manages</span></a></dd>
                <?php } ?>
                    <dd><a href="<?php echo current_url(); ?>/edit/<?php echo $row->id?>" class="edit" title="Edit '<?php echo $row->title; ?>' page"><span>edit</span></a></dd>
                </dl>

            <?php echo '<p>' . character_limiter(strip_tags($row->description),80) . '</p>'?>
            </li>
            <?php $i++;
        endforeach;?>
        </ul>

    <?php else:?>

        <p class="info warning"><span class="icon">&nbsp;</span> No pages have been created.</p>

    <?php endif;?>

    </div>