<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="rides">
   
<div>

<?php if(sizeof($data['current_selected_rides'])): ?>


<h3>You have selected the following ride </h3>

<br>

<?php foreach($data['current_selected_rides'] as $ride):?>

<div>
<label for="source"> Source: <?php echo $ride->source; ?> </label> <br>
<label for="destination"> Destination: <?php echo $ride->destination; ?> </label> <br>
<label for="departure"> Departure: <?php echo $ride->departure; ?> </label> <br>
<p><a href="<?php echo URLROOT; ?>rides/removeSelected/<?=$ride->id?>">Remove</a></p>
</div><br>

<?php endforeach?>

<?else:?>
    <!-- emptyness -->
<?php endif;?>

</div>

    <?php if(sizeof($data['rides']) == 0): ?>
    <p><h3>You've not posted anything !!</h3></p><br>
    <?php else: ?>
    <p><h3>You've posted the following</h3></p><br>
    <?php endif; ?>
    <hr>
    <?php foreach ($data['rides'] as $ride) : ?>
    <div>
        <label for="source"> Source: <?php echo $ride->source; ?> </label> <br>
        <label for="destination"> Destination: <?php echo $ride->destination; ?> </label> <br>
        <label for="departure"> Departure: <?php echo $ride->departure; ?> </label> <br>
        <label for="vehicle"> Vehicle: <?php echo $ride->vehicle; ?> </label> <br>
        <label for="seats"> Seats Available: <?php echo $ride->seats; ?> </label> <br>

        <br>
        <div>
            Booked by:
            <br>
            <ul>
                <?php foreach($data['selected_users'][$ride->id] as $user):?>
                <li>
                    <?=$user->full_name?>
                </li>
                <?php endforeach;?>
            </ul>

            <br>
        </div>
    </div>
    <br>
    <div class="edit_delete">
        <ul>
            <li><a href="<?php echo URLROOT; ?>rides/delete/<?php echo $ride->id; ?>">Delete ride</a>
            <li>
            <li><a href="<?php echo URLROOT; ?>rides/update/<?php echo $ride->id; ?>">Edit ride</a>
            <li>
        </ul><br>
    </div>
    <hr>
    <?php endforeach; ?>
</div>



<?php require APPROOT . '/views/inc/footer.php'; ?>