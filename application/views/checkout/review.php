<div class="container">
   <table class="table table-condensed">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach($cart_items['items'] as $item):?>
            <tr>
                <td><?php echo $i++;?> </td>
                <td>
                   <img src="<?php echo base_url('/uploads/' . $item['image']);?>" height="100" width="200"></td>
                <td><?=$item['name']?></td>
                <td><?=$item['quantity']?></td>
                <td><?=$item['price']?></td>
                
            </tr>
            <?php endforeach;?>
            <tr>
                <th colspan="3"></th>
                <th>Grand Total</th>
                <th><?php echo number_format($cart_items['total'], 2);?></th>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-12">
        <div class="text-left">
            <a href="/" class="btn btn-default">Continue Shopping</a>
        </div>
        <div class="text-right">
             <a href="/checkout/step2" class="btn btn-default">Address >> </a>
        </div>
        </div>
       
    </div>
</div>