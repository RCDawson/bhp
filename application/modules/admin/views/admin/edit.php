<?php
/* @	Documentation
 * 	Admin/Edit View must contain 1 object: $page
 * 	May contain 1 array of objects: $kids
 * 	Debug::dump($page);exit;
 * 	Debug::dump($kids);exit;
 */
if (!empty($page)) {
    //Debug::dump($page);
    /* @ Documentation
     *  Popluate the form on initial render with user-to-be-edited's information.
     *  Use form_validation handler after form processing begins.
     */
    (!empty($page->parent_url)) ? $parent_url = $page->parent_url.'/': $parent_url='';
    if ($page->url == $this->uri->segment(3)) {
        if ($this->input->post()) {
            $title = set_value('title');
            $url = set_value('url');
            $active = set_radio('active', '1', true);
        } else {
            $title = $page->title;
            $url = $page->url;
            $active = ($page->active) ? 'value="1" checked' : 'value="0"';
        }
//Debug::dump($page,true);
        ?>
        <div class="cms-70w left">
            <ul class="cms-form-errors">
                <?php echo validation_errors(); ?>
            </ul>
            <form method="post" action="<?php echo current_url(); ?>">
                <p>
                    <label>Page Title *</label>
                    <input type="text" name="title" value="<?php echo $title; ?>" maxlength="50">
                    <input type="text" name="url">
                    <input type="checkbox" name="active" value="1" <?php echo $active ?>>
                </p>
                <?php if ($page->url != 'home') { ?>
                <p>
                    <b>Permalink:</b> <?php echo base_url().$parent_url; ?><input type="text" id="permalink" name="url" style="width:auto;margin:0 1ex" class="editable" value="<?php echo $page->url; ?>">
                    <button type="button" onClick="window.open('<?php echo base_url().$parent_url.$page->url; ?>','_blank');return false;" title="View page in new window">View Page</button>
                </p>
                <?php } else { ?>
                <p><b>Permalink:</b> <?php echo base_url(); ?></p>
                <input type="hidden" name="url" value="<?php echo $url; ?>">
                <?php } ?>
                <p>
                    <label for="heading">Headline (optional). Leave blank, if you want to use your page title as a headline.</label>
                    <input type="text" id="heading" name="heading" value="<?php echo $page->heading; ?>" maxlength="200">
                </p>
                <textarea name="content" class="ckeditor"><?php echo $page->content; ?></textarea>
                <label>Excerpt</label>
                <textarea name="excerpt" cols="6" rows="5" class="ckeditor"><?php echo $page->excerpt; ?></textarea>
                <input type="submit" value="Update">
                <a href="/admin" class="cancel">cancel</a>
                <input type="hidden" name="orig_url" value="<?php echo $page->url; ?>">
            </form>
        </div>
        <div class="cms-30w right pods">
            <div class="pods">
                <p>Child Pages</p>
            <?php } if (!empty($kids)) { ?>
                <ul class="manage sub">

                    <?php $i = 0;
                    foreach ($kids as $kid) { ?>
                        <li>

                            <a href="/admin/edit/<?php echo $url . '/' . $kid->url; ?>" title="Edit this page"><b><?php echo $kid->title ?></b></a>

                            <dl class="cms-controls">
                                <dd><a href="/admin/edit/<?php echo $kid->url; ?>" class="edit" title="Edit this page"><span>Edit</span></a></dd>
                                <dd><a href="/admin/delete/<?php echo $kid->url; ?>" class="delete" title="Delete this page"><span>Delete</span></a></dd>
                            </dl>
                        </li>
                        <?php $i++;
                    } ?>
                </ul>
                <button type="button" onclick="window.location='/admin/create/page';">Add <?php echo $title; ?></button>
            <?php } ?>
<?php } else { ?>
            <p class="info warning"><span class="icon">&nbsp;</span> Something went wrong. <a href="/admin/" title="Good idea">Return to the dashboard?</a></p>
<?php } ?>
    </div>
</div>
<script type="text/javascript">
    $('input.editable').hide();
    $('.editable').keydown(function(e) {
        var flag = $(this).data('flag');
        if (e.which == 13) {
            $('.editOk.'+flag).trigger('click');
            $('.editThis.'+flag).trigger('focus');
            return false;
        }
    });

    function editThis(flag) {
        $(flag).toggle();
        $('.editOk' + flag).after('<a class="' + flag + '" onclick="editCancel(\'' + flag + '\',this);" href="#">Cancel</a>');
        $('input' + flag).focus();
        return false;
    }
    function editOk(flag) {
        $(flag).toggle();
        $('.editOk' + flag).next('a').remove();
        $('span' + flag).text($('input' + flag).val());
        return false;
    }
    function editCancel(flag, e) {
        $(flag).toggle();
        $(e).remove();
        $('span' + flag).show();
    }
    $(document).ready(function() {
        var i = 1;
        $('.editable').each(function() {
            var contents = $(this).val(),
                    orig = '<span class="edit' + i + '">' + contents + '</span>',
                    editBtn = '<button class="editThis edit' + i + '" onClick="editThis(\'.edit' + i + '\');return false" type="button" title="Edit permlink.">Edit</button>',
                    okBtn = '<button class="editOk edit' + i + '" onClick="editOk(\'.edit' + i + '\');return false" style="display:none" type="button">Ok</button>';
            $(this).addClass('edit' + i).after(orig + editBtn + okBtn).attr('data-flag','edit'+i);
        });
    });
</script>
