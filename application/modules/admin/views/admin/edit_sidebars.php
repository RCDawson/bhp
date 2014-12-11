<?php
if (!empty($page)) {
    if ($page->url == $this->uri->segment(3)) {
        if ($this->input->post()) {
            $title = set_value('title');
            $url = set_value('url');
        } else {
            $title = $page->title;
            $url = $page->url;
        }
        ?>
        <div class="cms-70w left">
            <ul class="cms-form-errors">
                <?php echo validation_errors(); ?>
            </ul>
            <form method="post" action="<?php echo current_url(); ?>">
                <p>
                    <label for="title">Sidebar Name <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>" maxlength="50" required>
                </p>
                <p>
                    <label for="heading">Headline for the following content.<em>(optional)</em></label>
                    <input type="text" id="heading" name="heading" value="<?php echo $page->heading; ?>" maxlength="50">
                    
                </p>
                <p>
                    <textarea name="content" cols="6" rows="5" class="ckeditor"><?php echo $page->content; ?></textarea>
                    <input type="submit" value="Update">
                    <a href="/admin" class="cancel">cancel</a>
                </p>
                    <input type="hidden" name="url" value="<?php echo $url; ?>">
            </form>
        </div>
        <div class="cms-30w right pods">
            <label>Publish</label>
            <form method="post" action="<?php echo current_url(); ?>" id="pages-edit">
                <p>Publish: <span id="publish_date"><?php echo unix_to_human(strtotime($page->published)); ?></span> <a onclick="changeDate();
                return false;" href="javascript:void(0);">Schedule</a></p>
                <input type="hidden" name="published" value="<?php /* echo date2select($content->publish); */ echo '2013-10-40'; ?>">
                <input type="hidden" name="id" value="<?php //echo $content->id;  ?>" />
                <input type="submit" value="Set Date">
            </form>
            <div class="pods">
                <label>Extras</label>
                <ul>
                    <li>Side bar: 
                        <select>
                            <option><?php echo(!empty($page->sidebar_content->friendly)) ? $page->sidebar_content->friendly : 'None'; ?></option>
                        </select>
                    </li>
                </ul>
            </div>
        <?php } ?>
    <?php } ?>
</div>