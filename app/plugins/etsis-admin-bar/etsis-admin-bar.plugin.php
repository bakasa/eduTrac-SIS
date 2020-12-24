<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');

/*
 * Plugin Name: eduTrac SIS Admin Bar
 * Plugin URI: https://plugins.edutracsis.com/package/etsis-admin-bar/
 * Version: 1.1.0
 * Description: Overrides the core dashboard admin bar and adds a quick access admin bar. Includes action and filter hooks to extend or override functionality.
 * Author: Joshua Parker
 * Author URI: https://www.edutracsis.com/
 * Plugin Slug: etsis-admin-bar
 */

$app = \Liten\Liten::getInstance();

etsis_load_file(ETSIS_PLUGIN_DIR . 'etsis-admin-bar/lib/menu.php');
etsis_load_file(ETSIS_PLUGIN_DIR . 'etsis-admin-bar/lib/link.php');
etsis_load_file(ETSIS_PLUGIN_DIR . 'etsis-admin-bar/lib/item.php');
etsis_load_file(ETSIS_PLUGIN_DIR . 'etsis-admin-bar/autoload.php');

load_plugin_textdomain('etsis-admin-bar', 'etsis-admin-bar/languages');

function dashboard_etsis_admin_bar_flash_error()
{
    $app = \Liten\Liten::getInstance();
    
    if (compare_releases('6.3.0', RELEASE_TAG, '<') && hasPermission('edit_settings')) {
        _etsis_flash()->error(_t('You must have at least eduTrac SIS release 6.3.0 installed before you can activate and use the <strong>eduTrac SIS Admin Bar</strong> plugin.', 'etsis-admin-bar'), $app->req->server['HTTP_REFERER']);
        exit();
    }
}

function admin_bar_css()
{
    echo '<link rel="stylesheet" type="text/css" href="' . get_base_url() . 'app/plugins/etsis-admin-bar/css/adminbar.css">' . "\n";
}

function admin_bar_menu()
{
    $app = \Liten\Liten::getInstance();
    $cookie = get_secure_cookie_data('SWITCH_USERBACK');

    ?>

    <div id="admin_bar_primary" class="navbar main admin_bar_wrapper">
        <div class="admin_bar_greeting">
            <ul class="no-margin">
                <li class="dropdown">
                    <a href="#"  class="dropdown-toggle profile" data-toggle="dropdown">
                        <span class="admin_bar_user_photo"><?= get_school_photo(get_persondata('personID'), get_persondata('email'), '40'); ?></span><?= sprintf(_t('Hi, %s', 'etsis-admin-bar'), get_persondata('fname') . ' ' . get_persondata('lname')); ?>
                    </a>
                    <ul class="sub-dropdown dropdown-menu">
                        <li><a href="<?= get_base_url(); ?>profile/"><?= _t('Profile', 'etsis-admin-bar'); ?></a></li>
                            <?php if (isset($app->req->cookie['SWITCH_USERBACK'])) : ?>
                            <li>
                                <a href="<?= get_base_url(); ?>switchUserBack/<?= $cookie->personID; ?>/"><?= _t('Switch Back to', 'etsis-admin-bar'); ?> <?= $cookie->uname; ?></a>
                            </li>
                            <?php endif; ?>
                        <li><a href="<?= get_base_url(); ?>logout/"><?= _t('Sign Out', 'etsis-admin-bar'); ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="admin_bar_links">
            <ul class="no-margin">
                <?php $app->hook->do_action('admin_bar_links'); ?>
                <?php $app->hook->do_action('custom_admin_bar_links'); ?>
                <li class="search open">
                    <form autocomplete="off" class="dropdown dd-1" method="post"
                          action="<?= get_base_url(); ?>dashboard/search/">
                        <input type="text" name="screen"
                               placeholder="Type for suggestions . . ." data-toggle="screen" />
                        <button type="button" class="glyphicon glyphicon-search">
                            <i></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="admin_bar_logout">
            <ul<?= ae('access_plugin_screen'); ?> class="no-margin">
                <li class="dropdown">
                    <a href="#"  class="dropdown-toggle plugins" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-cog"></span> <b class="caret"></b> </a>
                    <ul class="sub-dropdown dropdown-menu">
                        <li<?= ae('access_plugin_admin_page'); ?>><a href="<?= get_base_url(); ?>plugins/install/" ><?= _t('Install', 'etsis-admin-bar'); ?></a></li>
                        <li<?= ae('access_plugin_screen'); ?>><a href="<?= get_base_url(); ?>plugins/" ><?= _t('Plugins', 'etsis-admin-bar'); ?></a></li>
                        <?php $app->hook->list_plugin_admin_pages(get_base_url() . 'plugins/options' . '/'); ?>
                        <?php
                        /**
                         * Use this alternative action to create admin pages
                         * and subpages utilizing routers as well as views.
                         * 
                         * @since 6.1.09
                         */
                        $app->hook->do_action('list_plugin_admin_pages');

                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <?php
}

function generate_admin_bar_links()
{
    $app = \Liten\Liten::getInstance();

    $main = new Menu();
    $about = $main->add('<span class="glyphicon glyphicon-info-sign"></span>', '#');
    $about->add(_t('Online Manual', 'etsis-admin-bar'), 'https://www.edutracsis.com/');
    $about->add(_t('Handbook', 'etsis-admin-bar'), 'https://developer.edutracsis.com/');
    $about->add(_t('Plugins', 'etsis-admin-bar'), 'https://plugins.edutracsis.com/');
    $about->add(_t('Translator', 'etsis-admin-bar'), 'https://translate.edutracsis.com/');
    $main->add('<span class="glyphicon glyphicon-home"></span>', get_base_url());
    $main->add('<span class="glyphicon glyphicon-dashboard"></span>', get_base_url() . 'dashboard/');
    if (_he('clear_screen_cache')) :
        $main->add('<span class="glyphicon glyphicon-minus-sign"></span>', get_base_url() . 'dashboard/flushCache/');

    endif;
    $new = $main->add('<span class="glyphicon glyphicon-plus"></span> ' . _t('New', 'etsis-admin-bar'), '#');
    if (_he('add_person')) :
        $new->add(_t('Person', 'etsis-admin-bar'), get_base_url() . 'nae/add/');

    endif;
    if (_he('add_acad_prog')) :
        $new->add(_t('Program', 'etsis-admin-bar'), get_base_url() . 'program/add/');

    endif;
    if (_he('add_course')) :
        $new->add(_t('Course', 'etsis-admin-bar'), get_base_url() . 'crse/add/');

    endif;
    if (_he('add_institution')) :
        $new->add(_t('Institution', 'etsis-admin-bar'), get_base_url() . 'appl/inst/add/');

    endif;
    if (_he('access_communication_mgmt') && _mf('mrkt_module')) :
        $new->add(_t('Email List', 'etsis-admin-bar'), get_base_url() . 'mrkt/list/create/');

    endif;
    if (_he('access_communication_mgmt') && _mf('mrkt_module')) :
        $new->add(_t('Email Template', 'etsis-admin-bar'), get_base_url() . 'mrkt/template/create/');

    endif;
    if (_he('access_communication_mgmt') && _mf('mrkt_module')) :
        $new->add(_t('Campaign', 'etsis-admin-bar'), get_base_url() . 'mrkt/campaign/create/');

    endif;
    if (_he('access_financials') && _mf('financial_module')) :
        $new->add(_t('Bill', 'etsis-admin-bar'), get_base_url() . 'financial/create-bill/');
        $new->add(_t('Batch Fee', 'etsis-admin-bar'), get_base_url() . 'financial/batch/');
        $new->add(_t('Payment', 'etsis-admin-bar'), get_base_url() . 'financial/add-payment/');
        $new->add(_t('Refund', 'etsis-admin-bar'), get_base_url() . 'financial/issue-refund/');
        $new->add(_t('Payment Plan', 'etsis-admin-bar'), get_base_url() . 'financial/payment-plan/');

    endif;
    if (_h(get_option('edutrac_analytics_url')) !== null && _he('access_ea')) :
        $main->add('<span class="glyphicon glyphicon-stats"></span> ' . _t('eduTrac Analytics', 'etsis-admin-bar'), _h(get_option('edutrac_analytics_url')));

    endif;

    $menu = bootstrapItems($main);

    echo $app->hook->apply_filter('etsis_admin_bar', $menu);
}

register_activation_hook(__FILE__, 'dashboard_etsis_admin_bar_flash_error');
$app->hook->remove_filter('core_admin_bar', 'core_admin_bar', 10);
$app->hook->add_filter('core_admin_bar', '__return_false');
$app->hook->add_action('admin_bar_links', 'generate_admin_bar_links');
$app->hook->add_action('admin_bar', 'admin_bar_menu');
$app->hook->add_action('etsis_dashboard_head', 'admin_bar_css');
