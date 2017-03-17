<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo form_open('', array('role'=>'form')); ?>

    <div class="row">
        <?php // email ?>
        <div class="form-group col-sm-4<?php echo form_error('email') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('users input email'), 'email', array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <?php echo form_input(array('name'=>'email', 'value'=>set_value('email', (isset($user['email']) ? $user['email'] : '')), 'class'=>'form-control', 'type'=>'email')); ?>
        </div>
        
        <div class="form-group col-sm-4<?php echo form_error('mobile') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('users input mobile'), 'mobile', array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <?php echo form_input(array('name'=>'mobile', 'value'=>set_value('mobile', (isset($user['mobile']) ? $user['mobile'] : '')), 'class'=>'form-control', 'type'=>'text')); ?>
        </div>
    </div>

    <div class="row">
        <?php // email ?>
        <div class="form-group col-sm-6<?php echo form_error('address') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('users input address'), 'address', array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <?php echo form_textarea(array('name'=>'address', 'value'=>set_value('address', (isset($user['address']) ? $user['address'] : '')), 'class'=>'form-control')); ?>
        </div>
        
    </div>

    <div class="row">
        <?php // email ?>
        <div class="form-group col-sm-4<?php echo form_error('city') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('users input city'), 'city', array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <?php echo form_input(array('name'=>'city', 'value'=>set_value('city', (isset($user['city']) ? $user['city'] : '')), 'class'=>'form-control', 'type'=>'city')); ?>
        </div>
        
         <div class="form-group col-sm-4<?php echo form_error('state') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('users input state'), 'state', array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <?php echo form_input(array('name'=>'state', 'value'=>set_value('state', (isset($user['state']) ? $user['state'] : '')), 'class'=>'form-control', 'type'=>'state')); ?>
        </div>
        
         <div class="form-group col-sm-4<?php echo form_error('pincode') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('users input pincode'), 'pincode', array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <?php echo form_input(array('name'=>'pincode', 'value'=>set_value('pincode', (isset($user['pincode']) ? $user['pincode'] : '')), 'class'=>'form-control', 'type'=>'pincode')); ?>
        </div>
        
        
    </div>
<div class="row">
        <div class="col-sm-12">
        <div class="text-left">
            <a href="/" class="btn btn-success"><span class="glyphicon glyphicon-backward"></span>&nbsp;Review</a>
        </div>
        <div class="text-right">
             <button type="submit" name="submit" class="btn btn-success">Payment Options <span class="glyphicon glyphicon-forward"></span> </button>
        
        </div>
        </div>
       
    </div>

<?php echo form_close(); ?>
