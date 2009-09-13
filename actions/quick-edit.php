<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2007-2008 Harvey Kane <code@ragepank.com>
 * Copyright 2007-2008 Michael Holt <code@gardyneholt.co.nz>
 * Copyright 2007 Melanie Schulz <mel@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Harvey Kane <code@ragepank.com>
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @author  Melanie Schulz <mel@gardyneholt.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 * @package jojo_quick_edit
 */

/* ensure users of this function have access to the admin page */
$page = Jojo_Plugin::getPage(Jojo::parsepage('admin'));
if (!$page->perms->hasPerm($_USERGROUPS, 'view')) {
  echo "You do not have permission to use this function";
  exit();
}

$table = Jojo::getFormData('arg1', '');
$id    = Jojo::getFormData('arg2', 0 );
$field = Jojo::getFormData('arg3', '');
if ($field == 'undefined') $field = '';

$frajax = new frajax();
$frajax->title = 'Quick Edit - ' . _SITETITLE;
$frajax->sendHeader();
$frajax->scrollToTop();

if ($field=='') {

    $fd = Jojo::selectQuery("SELECT * FROM fielddata WHERE fd_table = ? AND fd_quickedit='yes'", array($table));
    $options = array();
    $n = count($fd);
    for ($i=0;$i<$n;$i++) {
        $options[$i]['name'] = $fd[$i]['fd_name'];
        $options[$i]['field'] = $fd[$i]['fd_field'];
    }
    $smarty->assign('id',$id);
    $smarty->assign('table',$table);
    $smarty->assign('options',$options);
    $content = $smarty->fetch('quick-edit-menu.tpl');
} else {
    //have chosen a field

    $tbl = &Jojo_Table::singleton($table);
    if ($id > 0) {
        $tbl->getRecord($id);
    }

    $submit = Jojo::getFormData('btn_save', false);
    if ($submit) {
        $tbl->setFieldValue($field, Jojo::getFormData('fm_' . $field));
        $errors = $tbl->fieldErrors();
        if (!is_array($errors)) {
            $res = $tbl->saveRecord();
            if ($res !== false) {
                /* Clear the content cache after saving */
                Jojo::deleteQuery("DELETE FROM contentcache");

                $frajax->script('parent.window.location = parent.window.location;');
                //$frajax->alert('Changes saved');
                $frajax->sendFooter();
                exit();
            }
        }
        $frajax->alert('save failed');
        $frajax->sendFooter();
        exit();
    }

    $fieldHTML = $tbl->getFieldHTML($field,'edit');
    //print_r($fieldsHTML[$field]);
    //$control = $tbl->fields[$field]->displayedit();

    $smarty->assign('control',$fieldHTML['html']);
    $smarty->assign('title',$fieldHTML['name']);
    $smarty->assign('required',$fieldHTML['required']);
    $smarty->assign('field',$field);

    $smarty->assign('id',$id);
    $smarty->assign('table',$table);
    $content = $smarty->fetch('quick-edit.tpl');


}

$frajax->assign('content', 'innerHTML',$content);
$frajax->sendFooter();