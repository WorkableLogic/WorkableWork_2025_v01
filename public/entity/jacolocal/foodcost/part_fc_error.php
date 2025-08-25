<div class="w3-container w3-card-4 w3-light-grey w3-padding-16">
    <h2><i class="fas fa-exclamation-triangle w3-text-red"></i> An Error Occurred</h2>
    <p>Sorry, the page you requested could not be found or an unexpected error occurred.</p>
    <hr>
    <h4>Debugging Information:</h4>
    <div class="w3-container w3-border w3-padding">
        <p><strong>Requested Page ('thing' parameter):</strong> 
            <?php 
                if (isset($_GET['thing'])) {
                    echo htmlspecialchars($_GET['thing']);
                } else {
                    echo '<em>Not provided</em>';
                }
            ?>
        </p>
        <p>This indicates either a missing or incorrect 'thing' parameter in the URL, which is used for navigation.</p>
    </div>
    <br>
    <a href="index.php?thing=dashboard" class="w3-button w3-blue">Go to Dashboard</a>
</div>
