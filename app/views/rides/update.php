<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="error">
    <?=$data['display_error']?>
</div>

<div class="bg-add">
    <div class="add-contain">
        <form action="<?php echo URLROOT; ?>rides/update/<?php echo $data['rides']['rideid'];?>" method="POST">

            <label for="rideid"> ride id: </label>
            <input type="text" name="rideid" value="<?php echo $data['rides']['rideid']; ?>" readonly>
            <br>

            <label for="source"> source: </label>
            <input type="text" name="source" value="<?php echo $data['rides']['source']; ?>">
            <br>

            <label for="destination"> destination: </label>
            <input type="text" name="destination" value="<?php echo $data['rides']['destination']; ?>">
            <br>

            <label for="departure"> departure: </label>
            <input type="datetime-local" name="departure" value="<?php echo $data['rides']['departure']; ?>">
            <br>

            <label for="vehicle"> vehicle: </label>
            <input type="text" name="vehicle" value="<?php echo $data['rides']['vehicle']; ?>">
            <br>

            <label for="seats"> seats: </label>
            <input type="number" name="seats" value="<?php echo $data['rides']['seats']; ?>">
            <br>

            <label for="vehicle"> contact: </label>
            <input type="number" name="contact" value="<?php echo $data['rides']['contact']; ?>">
            <br>

            <label for="vehicle_id"> vehicle id: </label>
            <input type="text" name="vehicle_id" value="<?php echo $data['rides']['vehicle_id']; ?>">
            <br>


            <input type="submit" value="Update Ride">
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>