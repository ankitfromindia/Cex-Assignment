<?php foreach($items as $item):?>

<li class="product">
    <div class="product-image"><a href="#0"><img width="50" heigh="50" src="<?php echo base_url('/uploads/' . $item['image']);?>" alt="<?=$item['name']?>"></a></div>
    <div class="product-details">
        <strong><?=$item['name']?></strong>
        <span class="price">Rs.<?=$item['price']?></span>
        <div class="actions">
            <a href="#0" class="delete-item">Delete</a>
            <div class="quantity">
                <label for="cd-product-<?=$item['id']?>">Qty</label>
                <span class="select">
                    <select id="cd-product-<?=$item['id']?>" name="quantity">
                        <?php foreach(range(1,10) as $qty):?>
                        <option value="<?php echo $qty;?>" <?php echo ($qty == $item['quantity']) ? 'selected="selected"' : '';?>><?php echo $qty;?></option>
                        <?php endforeach;?>
                       
                    </select>
                </span>
            </div>
        </div>
    </div>
</li>
<?php endforeach;?>