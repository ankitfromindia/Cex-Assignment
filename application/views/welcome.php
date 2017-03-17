<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .thumbnail
{
    margin-bottom: 20px;
    padding: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}

.item.list-group-item
{
    float: none;
    width: 100%;
    background-color: #fff;
    margin-bottom: 10px;
}
.item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
{
    background: #428bca;
}

.item.list-group-item .list-group-image
{
    margin-right: 10px;
}
.item.list-group-item .thumbnail
{
    margin-bottom: 0px;
}
.item.list-group-item .caption
{
    padding: 9px 9px 0px 9px;
}
.item.list-group-item:nth-of-type(odd)
{
    background: #eeeeee;
}

.item.list-group-item:before, .item.list-group-item:after
{
    display: table;
    content: " ";
}

.item.list-group-item img
{
    float: left;
}
.item.list-group-item:after
{
    clear: both;
}
.list-group-item-text
{
    margin: 0 0 11px;
}

</style>
<script>
    
</script>

<div class="container">
    <center>
        <?php echo form_open("{$this_url}?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role' => 'form', 'id' => "filters")); ?>

        <table>
            <tr>
                <td class="col-md-8">
                    <?php echo form_input(array('name' => 'name', 'id' => 'search', 'class' => 'form-control input-sm', 'placeholder' => 'Search products by name or by description...', 'value' => set_value('name', ((isset($filters['name'])) ? $filters['name'] : '')))); ?>

                </td>
                <td class="col-md-4">
                    <div class="text-right">
                        <a href="<?php echo $this_url; ?>" class="btn btn-danger tooltips" data-toggle="tooltip" title="<?php echo lang('admin tooltip filter_reset'); ?>"><span class="glyphicon glyphicon-refresh"></span> <?php echo lang('core button reset'); ?></a>
                        <button type="submit" name="submit" value="<?php echo lang('core button filter'); ?>" class="btn btn-success tooltips" data-toggle="tooltip" title="<?php echo lang('admin tooltip search'); ?>"><span class="glyphicon glyphicon-filter"></span> <?php echo lang('core button search'); ?></button>
                    </div>
                </td>
            </tr>
        </table>
        <?php echo form_close(); ?>

    </center>
    <br><br>
    <div class="well well-sm">
        <strong>Product Listing</strong>
    
    </div>
    <div id="products" class="row list-group">
        <div class='row text-right col-xs-12'>
            Sort By:
            <a href="<?php echo current_url(); ?>?sort=price&dir=<?php echo (($dir == 'asc' ) ? 'desc' : 'asc'); ?>&limit=<?php echo $limit; ?>&offset=<?php echo $offset; ?><?php echo $filter; ?>">Price</a>
            <?php if ($sort == 'price'): ?><span class="glyphicon glyphicon-arrow-<?php echo (($dir == 'asc') ? 'up' : 'down'); ?>"></span><?php endif; ?>
           
        </div>
        <div class="row col-md-12">
        <?php if ($total) : ?>
        <?php foreach($result as $r):?>
        <div class="item  col-xs-4 col-lg-4">
            <div class="thumbnail">
                <img class="group list-group-image" src="<?php echo base_url('/uploads/' . $r['image']);?>" alt="<?php echo $r['name'];?>" height='300' width='300' />
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        <?php echo $r['name'];?></h4>
                    <p class="group inner list-group-item-text"><?php echo $r['description'];?></p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead">
                                Rs. <?php echo $r['price'];?>
                            </p>
                        </div>
                        <div class="col-xs-12 col-md-6 text-right">
                            <a class="btn btn-success text-right add_to_cart" data-product="<?php echo $r['id'];?>" href="javascript:void(0)">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        <div class="col-md-8">
                <?php echo $pagination; ?>
        </div>
        <?php else: ?>
        <div class="row col-md-12 text-center">
            No Results Found
        </div>
        
        <?php endif;?>
        </div>
    </div>
</div>
