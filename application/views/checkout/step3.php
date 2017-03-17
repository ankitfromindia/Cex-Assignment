<?php echo form_open('', array('role'=>'form')); ?>
<div class="container">
   <table class="table table-condensed">
        <thead>
            <tr>
                <th>Available Options</th>
               
            </tr>
        </thead>
        <tbody>
            <?php foreach($payment_options as $opt => $optValue):?>
            <tr>
                <td><input class="form-inline" type="radio" name="option" value="<?php echo $opt;?>" checked = "checked"> <?php echo $optValue;?> </td>
                
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-12">
        <div class="text-left">
            <a href="/" class="btn btn-success"><span class="glyphicon glyphicon-backward"></span>&nbsp;Address</a>
        </div>
        <div class="text-right">
             <button type="submit" name="submit" class="btn btn-success">Place Order <span class="glyphicon glyphicon-forward"></span> </button>
        
        </div>
        </div>
       
    </div>
</div>
<?php echo form_close(); ?>