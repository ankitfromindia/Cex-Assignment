<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6 text-left">
                <h3 class="panel-title"><?php echo lang($identifier . ' title list'); ?></h3>
            </div>
            <?php if($this->add_new):?>
            <div class="col-md-6 text-right">
                <a class="btn btn-success tooltips" href="<?php echo base_url($add_link); ?>" title="<?php echo lang($identifier . ' tooltip add_new') ?>" data-toggle="tooltip"><span class="glyphicon glyphicon-plus-sign"></span> <?php echo lang($identifier. ' button add_new'); ?></a>
            </div>
            <?php endif;?>
        </div>
    </div>

    <table class="table table-striped table-hover-warning">
        <thead>

            <?php // sortable headers ?>
            <tr>
                <?php foreach($cols as $col):?>
                <td>
                    <a href="<?php echo current_url(); ?>?sort=<?=$col?>&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>"><?php echo lang($identifier . ' col ' . $col); ?></a>
                    <?php if ($sort == $col) : ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
                </td>
                <?php endforeach;?>
               
                <td colspan="3">
                    <?php echo lang('admin col actions'); ?>
                </td>
            </tr>

            <?php // search filters ?>
            <tr>
                <?php echo form_open("{$this_url}?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
                   
                    <?php foreach($filter_fields as $ff):?>
                    <?php if($ff == ''):?>
                    <th>
                    </th>
                    <?php else:?>
                    <th<?php echo ((isset($filters[$ff])) ? ' class="has-success"' : ''); ?>>
                        <?php echo form_input(array('name'=> $ff, 'id'=> $ff, 'class'=>'form-control input-sm', 'placeholder'=>lang($identifier. ' input ' . $ff), 'value'=>set_value($ff, ((isset($filters[$ff])) ? $filters[$ff] : '')))); ?>
                    </th>
                    <?php endif;?>
                    <?php endforeach;?>
                    
                    <th colspan="3">
                        <div>
                            <a href="<?php echo $this_url; ?>" class="btn btn-danger tooltips" data-toggle="tooltip" title="<?php echo lang('admin tooltip filter_reset'); ?>"><span class="glyphicon glyphicon-refresh"></span> <?php echo lang('core button reset'); ?></a>
                            <button type="submit" name="submit" value="<?php echo lang('core button filter'); ?>" class="btn btn-success tooltips" data-toggle="tooltip" title="<?php echo lang('admin tooltip filter'); ?>"><span class="glyphicon glyphicon-filter"></span> <?php echo lang('core button filter'); ?></button>
                        </div>
                    </th>
                <?php echo form_close(); ?>
            </tr>

        </thead>
        <tbody>

            <?php // data rows ?>
            <?php if ($total) : ?>
                <?php foreach ($result as $rs) : ?>
                    <tr>
                        <?php foreach($cols as $col):?>
                        <td<?php echo (($sort == $col) ? ' class="sorted"' : ''); ?>>
                            <?php if(isset($image_col) && $col == $image_col):?>
                            <img src='<?php echo base_url('/uploads/' . $rs[$col]);?>' height='100' width="100">
                            <?php else:?>
                            <?php echo $rs[$col]; ?>
                            <?php endif;?>
                        </td>
                        <?php endforeach;?>
                      
                        
                        <td>
                            <div class="text-right">
                                <div class="btn-group">
                                    <?php foreach ($this->actions as $action): ?>
                                        <?php if ($action == 'view'): ?>
                                            <a href="<?php echo $this_url; ?>/view/<?php echo $rs['id']; ?>" class="btn btn-primary" title="<?php echo lang('admin button view'); ?>"><span class="glyphicon glyphicon-camera"></span></a>
                                        <?php elseif ($action == 'delete'): ?>
                                            <a href="#modal-<?php echo $rs['id']; ?>" data-toggle="modal" class="btn btn-danger" title="<?php echo lang('admin button delete'); ?>"><span class="glyphicon glyphicon-trash"></span></a>

                                        <?php elseif ($action == 'edit'): ?>
                                            <a href="<?php echo $this_url; ?>/edit/<?php echo $rs['id']; ?>" class="btn btn-warning" title="<?php echo lang('admin button edit'); ?>"><span class="glyphicon glyphicon-pencil"></span></a>

                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7">
                        <?php echo lang('core error no_results'); ?>
                    </td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>

    <?php // list tools ?>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-2 text-left">
                <label><?php echo sprintf(lang('admin label rows'), $total); ?></label>
            </div>
            <div class="col-md-2 text-left">
                <?php if ($total > 10) : ?>
                    <select id="limit" class="form-control">
                        <option value="10"<?php echo ($limit == 10 OR ($limit != 10 && $limit != 25 && $limit != 50 && $limit != 75 && $limit != 100)) ? ' selected' : ''; ?>>10 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="25"<?php echo ($limit == 25) ? ' selected' : ''; ?>>25 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="50"<?php echo ($limit == 50) ? ' selected' : ''; ?>>50 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="75"<?php echo ($limit == 75) ? ' selected' : ''; ?>>75 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="100"<?php echo ($limit == 100) ? ' selected' : ''; ?>>100 <?php echo lang('admin input items_per_page'); ?></option>
                    </select>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <?php echo $pagination; ?>
            </div>
            
        </div>
    </div>

</div>

<?php // delete modal ?>
<?php if ($total) : ?>
    <?php foreach ($result as $rs) : ?>
        <div class="modal fade" id="modal-<?php echo $rs['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-label-<?php echo $rs['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 id="modal-label-<?php echo $rs['id']; ?>"><?php echo lang($identifier. ' title delete');  ?></h4>
                    </div>
                    <div class="modal-body">
                        <p><?php echo sprintf(lang($identifier. ' msg delete_confirm'), $rs['name']); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('core button cancel'); ?></button>
                        <button type="button" class="btn btn-primary btn-delete-item" data-id="<?php echo $rs['id']; ?>"><?php echo lang('admin button delete'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
