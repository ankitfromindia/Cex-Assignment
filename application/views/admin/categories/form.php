<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo form_open('', array('role'=>'form')); ?>

    <?php // hidden id ?>
    <?php if (isset($category_id)) : ?>
        <?php echo form_hidden('id', $category_id); ?>
    <?php endif; ?>

    <div class="row">
        <?php // username ?>
        <div class="form-group col-sm-4<?php echo form_error('name') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('categories input name'), 'name', array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <?php echo form_input(array('name'=>'name', 'value'=>set_value('name', (isset($saved_category['name']) ? $saved_category['name'] : '')), 'class'=>'form-control')); ?>
        </div>
    </div>

    <div class="row">
        <?php // language ?>
        <div class="form-group col-sm-6<?php echo form_error('parent_id') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('categories input parent'), 'parent', array('class'=>'control-label')); ?>
            
            <?php echo form_dropdown('parent_id', $category, isset($saved_category['parent_id']) ? $saved_category['parent_id'] : 0 , 'id="parent_id" class="form-control"');?>
        </div>
    </div>


    <?php // buttons ?>
    <div class="row pull-right">
        <a class="btn btn-default" href="<?php echo $cancel_url; ?>"><?php echo lang('core button cancel'); ?></a>
        <button type="submit" name="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> <?php echo lang('core button save'); ?></button>
    </div>

<?php echo form_close(); ?>
