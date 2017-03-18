<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo form_open_multipart('', array('role' => 'form')); ?>

<?php // hidden id ?>
<?php if (isset($product_id)) : ?>
    <?php echo form_hidden('id', $product_id); ?>
<?php endif; ?>
<div class="row">
        <?php // language ?>
        <div class="form-group col-sm-6<?php echo form_error('parent_id') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('products input category'), 'category_id', array('class'=>'control-label')); ?>
            
            <?php echo form_dropdown('category_id', $category, set_value('category_id', isset($saved_product['category_id']) ? $saved_product['category_id'] : 0) , 'id="category_id" class="form-control"');?>
        </div>
    </div>
<div class="row">
    <?php // product name?>
    <div class="form-group col-sm-4<?php echo form_error('name') ? ' has-error' : ''; ?>">
        <?php echo form_label(lang('products input name'), 'name', array('class' => 'control-label')); ?>
        <span class="required">*</span>
        <?php echo form_input(array('name' => 'name', 'value' => set_value('name', (isset($saved_product['name']) ? $saved_product['name'] : '')), 'class' => 'form-control')); ?>
    </div>
</div>

<div class="row">
    <?php // username ?>
    <div class="form-group col-sm-4<?php echo form_error('description') ? ' has-error' : ''; ?>">
        <?php echo form_label(lang('products input description'), 'description', array('class' => 'control-label')); ?>
        <span class="required">*</span>
        <?php echo form_textarea(array('name' => 'description', 'value' => set_value('description', (isset($saved_product['description']) ? $saved_product['description'] : '')), 'class' => 'form-control')); ?>
    </div>
</div>
<div class="row">
    <?php // username ?>
    <div class="form-group col-sm-4<?php echo form_error('price') ? ' has-error' : ''; ?>">
        <?php echo form_label(lang('products input price'), 'price', array('class' => 'control-label')); ?>
        <span class="required">*</span>
        <?php echo form_input(array('name' => 'price', 'value' => set_value('price', (isset($saved_product['price']) ? $saved_product['price'] : '')), 'class' => 'form-control')); ?>
    </div>
</div>

<div class="row">
    <?php // username ?>
    <div class="form-group col-sm-4<?php echo form_error('quantity') ? ' has-error' : ''; ?>">
        <?php echo form_label(lang('products input quantity'), 'quantity', array('class' => 'control-label')); ?>
        <span class="required">*</span>
        <?php echo form_input(array('name' => 'quantity', 'value' => set_value('quantity', (isset($saved_product['quantity']) ? $saved_product['quantity'] : '')), 'class' => 'form-control')); ?>
    </div>
</div>
<div class="row">
    <?php // username ?>
    <div class="form-group col-sm-4<?php echo form_error('image') ? ' has-error' : ''; ?>">
        <?php echo form_label(lang('products input image'), 'image', array('class' => 'control-label')); ?>
        <span class="required">*</span>

        <?php echo form_upload(array('name' => 'image', 'value' => set_value('image', (isset($saved_product['image']) ? $saved_product['image'] : '')), 'class' => '')); ?>
        <?php if(isset($saved_product['image'])):?>
            <img src="<?php echo base_url('/uploads/'.  $saved_product['image']);?>" width="100" heigh="100"/>
            <input type="hidden" name="file_exist" value="1"/>
        <?php endif;?>
    </div>
</div>
<div class="row">
    <?php // username ?>
    <div class="form-group col-sm-4<?php echo form_error('is_active') ? ' has-error' : ''; ?>">
        <?php echo form_label(lang('products input is_active'), 'is_active', array('class' => 'control-label')); ?>
        
        <?php echo form_checkbox(array('name' => 'is_active', 'value' => set_value('is_active', (isset($saved_product['is_active']) ? $saved_product['is_active'] : '')), 'class' => '')); ?>
    </div>
</div>

<?php // buttons ?>
<div class="row pull-right">
    <a class="btn btn-default" href="<?php echo $cancel_url; ?>"><?php echo lang('core button cancel'); ?></a>
    <button type="submit" name="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> <?php echo lang('core button save'); ?></button>
</div>

<?php echo form_close(); ?>
