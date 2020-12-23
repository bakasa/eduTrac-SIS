<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/*
  Plugin Name: Moodle
  Plugin URI: https://plugins.edutracsis.com/package/moodle/
  Version: 1.1.0
  Description: The plugin allows for deep integration with Moodle when courses are created, students are enrolled or unenrolled and more.
  Author: Joshua Parker
  Author URI: https://www.edutracsis.com/
  Plugin Slug: moodle
 */

$app = \Liten\Liten::getInstance();
$app->view->extend('_layouts/dashboard');
$app->view->block('dashboard');

require_once('moodle.class.php');
$moodle = new MoodleLMS();

$app->hook->add_action('admin_menu', 'moodle_page', 10);
load_plugin_textdomain('moodle', 'moodle/languages');

function moodle_lms_admin_flash_error()
{
    $app = \Liten\Liten::getInstance();
    
    if (compare_releases('6.3.0', RELEASE_TAG, '<') && hasPermission('edit_settings')) {
        _etsis_flash()->error(_t('You must have at least eduTrac SIS release 6.3.0 installed before you can activate and use the <strong>Moodle</strong> plugin.', 'moodle'), $app->req->server['HTTP_REFERER']);
        exit();
    }
}

function moodle_page()
{
    // parameters: page slug, page title, and function that will display the page itself
    register_admin_page('moodle', 'Moodle', 'moodle_do_page');
}

function moodle_do_page()
{
    $app = \Liten\Liten::getInstance();
    $options = [
        'moodle_token', 'moodle_install_url', 'moodle_auth',
        'moodle_secure_passwords', 'moodle_password_email',
        'moodle_unenroll_student','moodle_auth_teacher_update',
        'moodle_auth_student_update'
    ];

    if ($app->req->post) {
        foreach ($options as $option_name) {
            if (!isset($app->req->post[$option_name]))
                continue;
            $value = $app->req->post[$option_name];
            update_option($option_name, $value);
        }
        _etsis_flash()->success(_t('Plugin settings were saved successfully.', 'moodle'), $app->req->server['HTTP_REFERER']);
        // Update more options here
        $app->hook->do_action('update_options');
    }

    ?>

    <ul class="breadcrumb">
        <li><?= _t('You are here', 'moodle'); ?></li>
        <li><a href="<?= get_base_url(); ?>dashboard/" class="glyphicons dashboard"><i></i> <?= _t('Dashboard', 'moodle'); ?></a></li>
        <li class="divider"></li>
        <li><a href="<?= get_base_url(); ?>plugins/" class="glyphicons cogwheels"><i></i> <?= _t('Plugins', 'moodle'); ?></a></li>
        <li class="divider"></li>
        <li><?= _t('Moodle Settings', 'moodle'); ?></li>
    </ul>

    <h3><?= _t('Moodle Settings', 'moodle'); ?></h3>
    <div class="innerLR">

        <!-- Widget -->
        <div class="widget widget-heading-simple widget-body-gray">

            <!-- Widget heading -->
            <!--<div class="widget-head">
                <h4 class="heading"></h4>
            </div>-->
            <!-- // Widget heading END -->

            <div class="widget-body">

                <form class="form-horizontal margin-none" action="<?= get_base_url(); ?>plugins/options/?page=moodle" id="validateSubmitForm" method="post" autocomplete="off">

                    <!-- Row -->
                    <div class="row">
                        <!-- Column -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?= _t('Moodle API Token', 'moodle'); ?></label> 
                                <div class="col-md-8"><input id='input01' class="form-control" name="moodle_token" type="text" value="<?= _h(get_option('moodle_token')); ?>" required/></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?= _t('Moodle URL', 'moodle'); ?></label> 
                                <div class="col-md-8"><input id='input01' class="form-control" name="moodle_install_url" type="text" value="<?= _h(get_option('moodle_install_url')); ?>" required/></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?= _t('Auth', 'moodle'); ?> <a href="#auth" data-toggle="modal"><img src="<?= get_base_url(); ?>static/common/theme/images/help.png" /></a></label> 
                                <div class="col-md-8">
                                    <select name="moodle_auth" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true" required>
                                        <option value="">&nbsp;</option>
                                        <option value="nologin"<?= selected('nologin', _h(get_option('moodle_auth')), false); ?>><?= _t('No Login', 'moodle'); ?></option>
                                        <option value="manual"<?= selected('manual', _h(get_option('moodle_auth')), false); ?>><?= _t('Manual', 'moodle'); ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?= _t('Update Teacher Auth', 'moodle'); ?> <a href="#teachauth" data-toggle="modal"><img src="<?= get_base_url(); ?>static/common/theme/images/help.png" /></a></label> 
                                <div class="col-md-8">
                                    <select name="moodle_auth_teacher_update" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true" required>
                                        <option value="">&nbsp;</option>
                                        <option value="yes"<?= selected('yes', _h(get_option('moodle_auth_teacher_update')), false); ?>><?= _t('Yes', 'moodle'); ?></option>
                                        <option value="no"<?= selected('no', _h(get_option('moodle_auth_teacher_update')), false); ?>><?= _t('No', 'moodle'); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <!-- Column -->
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?= _t('Update Student Auth', 'moodle'); ?> <a href="#stuauth" data-toggle="modal"><img src="<?= get_base_url(); ?>static/common/theme/images/help.png" /></a></label> 
                                <div class="col-md-8">
                                    <select name="moodle_auth_student_update" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true" required>
                                        <option value="">&nbsp;</option>
                                        <option value="yes"<?= selected('yes', _h(get_option('moodle_auth_student_update')), false); ?>><?= _t('Yes', 'moodle'); ?></option>
                                        <option value="no"<?= selected('no', _h(get_option('moodle_auth_student_update')), false); ?>><?= _t('No', 'moodle'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?= _t('Unenroll Student', 'moodle'); ?> <a href="#unenrol_stu" data-toggle="modal"><img src="<?= get_base_url(); ?>static/common/theme/images/help.png" /></a></label> 
                                <div class="col-md-8">
                                    <select name="moodle_unenroll_student" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true" required>
                                        <option value="">&nbsp;</option>
                                        <option value="yes"<?= selected('yes', _h(get_option('moodle_unenroll_student')), false); ?>><?= _t('Yes', 'moodle'); ?></option>
                                        <option value="no"<?= selected('no', _h(get_option('moodle_unenroll_student')), false); ?>><?= _t('No', 'moodle'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?= _t('Secure Passwords', 'moodle'); ?> <a href="#pass" data-toggle="modal"><img src="<?= get_base_url(); ?>static/common/theme/images/help.png" /></a></label> 
                                <div class="col-md-8">
                                    <select name="moodle_secure_passwords" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true" required>
                                        <option value="">&nbsp;</option>
                                        <option value="yes"<?= selected('yes', _h(get_option('moodle_secure_passwords')), false); ?>><?= _t('Yes', 'moodle'); ?></option>
                                        <option value="no"<?= selected('no', _h(get_option('moodle_secure_passwords')), false); ?>><?= _t('No', 'moodle'); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <!-- // Column END -->
                    </div>
                    <!-- // Row END -->

                    <!-- Form actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i><?= _t('Submit', 'moodle'); ?></button>
                    </div>
                    <!-- // Form actions END -->

                </form>
                <!-- // Form END -->

            </div>
        </div>
        <!-- // Widget END -->

        <div class="modal fade" id="unenrol_stu">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal heading -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><?= _t('Unenroll Student', 'moodle'); ?></h3>
                    </div>
                    <!-- // Modal heading END -->
                    <div class="modal-body">
                        <?= _t('If a student should be unenrolled from a Moodle course when the student is either dropped or withdrawn from a course section, set this to "Yes".', 'moodle'); ?>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-primary"><?= _t('Cancel', 'moodle'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="auth">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal heading -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><?= _t('Auth', 'moodle'); ?></h3>
                    </div>
                    <!-- // Modal heading END -->
                    <div class="modal-body">
                        <?= _t('If set to No Login, when the user is created in Moodle, the user will not be able to log in. If you set it to Manual, then when the user is created in Moodle, the user will be able to log in.', 'moodle'); ?>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-primary"><?= _t('Cancel', 'moodle'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="pass">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal heading -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><?= _t('Secure Passwords', 'moodle'); ?></h3>
                    </div>
                    <!-- // Modal heading END -->
                    <div class="modal-body">
                        <?= _t('If you are using a site policy especially in regards to passwords, then set this to yes. When logged into eduTrac SIS, users can only generate a password instead of entering a custom password.', 'moodle'); ?>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-primary"><?= _t('Cancel', 'moodle'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="teachauth">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal heading -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><?= _t('Update Teacher Auth', 'moodle'); ?></h3>
                    </div>
                    <!-- // Modal heading END -->
                    <div class="modal-body">
                        <?= _t('If the Auth setting is set to "No Login", the teacher in Moodle will not be able to log in. Set this to "Yes" if the Auth for teacher should be changed to "Manual" when faculty is added to the course section.', 'moodle'); ?>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-primary"><?= _t('Cancel', 'moodle'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="stuauth">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal heading -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><?= _t('Update Student Auth', 'moodle'); ?></h3>
                    </div>
                    <!-- // Modal heading END -->
                    <div class="modal-body">
                        <?= _t('If the Auth setting is set to "No Login", the student in Moodle will not be able to log in. Set this to "Yes" if the Auth for student should be changed to "Manual" when applicant is moved to student.', 'moodle'); ?>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-primary"><?= _t('Cancel', 'moodle'); ?></a>
                    </div>
                </div>
            </div>
        </div>

    </div>	

    </div>
    <!-- // Content END -->


    <?php
    
register_activation_hook(__FILE__, 'moodle_lms_admin_flash_error'); 
   
    $app->view->stop();
}
