<table class="table">
    <tbody>
        <tr>
            <th>Order Id</th>
            <td><?php echo $item['id'];?></td>
        </tr>
        <tr>
            <th>Order Placed Date</th>
            <td><?php echo $item['created'];?></td>

        </tr>
        <tr>
            <th>Order Total</th>
            <td>Rs. <?php echo $item['order_total'];?></td>

        </tr>
        <tr>
            <th>Order Status</th>
            <td>
                <div class="input-prepend input-append">
                    <div class="btn-group">

                        <button class="btn dropdown-toggle" name="recordinput" data-toggle="dropdown">
                            <?php echo ucfirst($item['status']);?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php foreach(['processing', 'dispatched', 'delivered'] as $status):?>
                            <li><a href="javascript:void(0)" data-id="<?php echo $item['id'];?>" data-status="<?php echo $status;?>" class="orderstatus"><?php echo ucfirst($status);?></a></li>
                            <?php endforeach;?>
                        </ul>
                       
                    </div>
                </div>
            </td>

        </tr>
    </tbody>
</table>

<div class="panel panel-default">
    <div class="panel-heading">Panel Heading</div>
    <div class="panel-body">


        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John</td>
                        <td>Doe</td>
                        <td>john@example.com</td>
                    </tr>
                    <tr>
                        <td>Mary</td>
                        <td>Moe</td>
                        <td>mary@example.com</td>
                    </tr>
                    <tr>
                        <td>July</td>
                        <td>Dooley</td>
                        <td>july@example.com</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
