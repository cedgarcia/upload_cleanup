<!-- ******************** -->
<!-- ***START SESSION**** -->
<!-- ******************** -->
<?php
session_name("user_session");
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('includes/dbconnection.php');
?>

<!-- ******************** -->
<!-- ***** PHP CODE ***** -->
<!-- ******************** -->
<?php
if (isset($_GET['concourse_id'])) {
    $concourse_id = $_GET['concourse_id'];

    // Query the database to fetch the detailed information for the selected concourse
    $concourseQuery = "SELECT * FROM concourse_verification WHERE concourse_id = $concourse_id";
    $concourseResult = mysqli_query($con, $concourseQuery);

    // Form Data


    // Check if a POST request was made to update Concourse details
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $concourse_id = $_POST['concourse_id'];


        // Update the database with the new data
        $updateQuery = "UPDATE concourse_verification SET

           
                WHERE concourse_id = $concourse_id";

        // Execute the query
        if (mysqli_query($con, $updateQuery)) {
            echo "Data updated successfully.";
        } else {
            echo "Error updating data: " . mysqli_error($con);
        }
    }
}

// Include your database connection and other required files
?>
    <!-- ******************** -->
    <!-- **** START HTML **** -->
    <!-- ******************** -->
    <?php
include('includes/header.php');
include('includes/nav.php');
?>

<section class="concourse-configuration" style="margin-top:80px;   display: flex; justify-content:space-evenly;">

  
        <div class="concourse-details">
    <?php
    // Display the detailed information
    if ($concourseResult && mysqli_num_rows($concourseResult) > 0) {
        $concourseData = mysqli_fetch_assoc($concourseResult);

        echo '<h3>Concourse Details</h3>';

        echo '<div>';
        echo '<h5 class="card-title">Concourse Map</h5>';
        echo '<a href="index.php" class="card-title">';
        echo '<button>Manage Spaces</button>';
        echo ' </a>';
        echo '</div>';
        echo '<h5 class="card-title">' . $concourseData['concourse_name'] . '</h5>';
        echo '<div class="card">';
        echo '<img src="/COMS/uploads/' . $concourseData['concourse_map'] . '" class="card-img-top smaller-image" alt="Concourse Map" style="width: 200px; height: 200px;">';
        echo '<div class="card-body">';
        echo '<p class="card-text">Concourse ID: ' . $concourseData['concourse_id'] . '</p>';
        echo '<p class="card-text">Owner ID: ' . $concourseData['owner_id'] . '</p>';
        // echo '<p class="card-text">Concourse Name: ' . $concourseData['owner_name'] . '</p>';
        echo '<p class="card-text">Owner Name: ' . $concourseData['owner_name'] . '</p>';
        // Add the user image here
        // echo '<img src="' . $_SESSION['uimage'] . '" class="card-img-top" style="height:50px; width:50px;" alt="User Image">';
        // Add more details as needed
        echo '</div>';
        echo '</div>';
    } else {
        echo 'Concourse not found.';
    }
?>
</div>

<div>
    
<h5 class="card-title">Concourse Featured Image</h5>
<button id="changeImageBtn">Change</button>
<input type="file" id="concourseImageInput" style="display: none;">
<img src="/COMS/uploads/<?php echo $concourseData['concourse_map']; ?>" id="concourseImage" class="card-img-top smaller-image" alt="Concourse Map" style="width: 200px; height: 200px;">
<!-- <img src="/COMS/uploads/'. <?php echo  $concourseData['concourse_map'] ?> . ' " alt="MAP"> -->

<!-- <img src="/COMS/uploads/' . $concourseData['concourse_map'] . '" class="card-img-top smaller-image" alt="Concourse Map" style="width: 200px; height: 200px;"> -->

<div class="edit-concourse-form">
        <h3>Edit Concourse Details</h3>
        <form method="post" action="concourse_configuration.php?concourse_id=<?php echo $concourse_id; ?>" enctype="multipart/form-data">
    <label for="total_area">Total Area (sq ft):</label>
    <input type="text" name="total_area" value="<?php echo $concourseData['concourse_total_area']; ?>"><br>


    <!-- HINDI KO ALAM KUNG DAPAT BANG BAGUHIN YUNG MGA NAKA COMMENT  -->
    <!-- <label for="total_spaces">Total Spaces:</label>
    <input type="text" name="total_spaces" value="<?php echo $concourseData['spaces']; ?>"><br> -->

    <!-- <label for="location">Location (City/Postal Code/Barangay):</label> -->
    <!-- <input type="text" name="location" value="<?php echo $concourseData['location']; ?>"><br> -->

    <label for="contract_of_lease">Contract of Lease:</label>
    <input type="file" name="contract_of_lease"><br>

    <label for="concourse_image">Concourse Image:</label>
    <input type="file" name="concourse_image"><br>

    <input type="submit" value="Save">
</form>

    </div>

</section>

<?php include('includes/footer.php'); ?>


<script>
    // Get the button and input element
    const changeImageBtn = document.getElementById('changeImageBtn');
    const concourseImageInput = document.getElementById('concourseImageInput');
    const concourseImage = document.getElementById('concourseImage');

    // Add an event listener to the "Change" button
    changeImageBtn.addEventListener('click', () => {
        concourseImageInput.click();
    });

    // Add an event listener to the input file element
    concourseImageInput.addEventListener('change', (event) => {
        const selectedFile = event.target.files[0];
        if (selectedFile) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Display the selected image as a preview
                concourseImage.src = e.target.result;
            };
            reader.readAsDataURL(selectedFile);
        }
    });
</script>