<?php echo form_open('admin/settings/analytics/edit')?>
        <fieldset style="margin-top: 15px;">
            <legend>Google analytics API <em style="color: #aaa;font-weight:normal;">must be defined to use on site reports</em></legend>
            <div>
                <label for="ga_username">Google analytics username</label>
                <input type="text" name="ga_username" id="ga_username" value="<?php echo set_value('ga_username', isset($ga_username) ? $ga_username : ''); ?>" />
            </div>
            <div>
                <label for="ga_password">Google analytics password</label>
                <input type="text" name="ga_password" id="ga_password" value="<?php echo set_value('ga_password', isset($ga_password) ? $ga_password : ''); ?>" />
            </div>
        </fieldset>
        <fieldset>
            <legend>Google analytics </legend>
            <div>
                <label for="ga_enabled">Enabled</label>
                <?php echo form_dropdown('ga_enabled',array('0'=>'No','1'=>'Yes'),$ga_enabled,'id="ga_enabled"');?>
            </div>
            <div>
                <label for="ga_profile">Profile id</label>
                <input type="text" name="ga_profile" value="<?php echo set_value('ga_profile', isset($ga_profile) ? $ga_profile : ''); ?>" id="ga_profile"/>
            </div>
        </fieldset>
        <div class="submits">
            <input type="submit" name="submit" value="Save Settings" />
        </div>
<?php echo form_close()?>