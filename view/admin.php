<?php
if (!isset($_SESSION['loggedin'])) {
    // header('location: /acme/');
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include '../common/head.php'; ?>

<body>
    <header>
        <?php include '../common/header.php'; ?>
    </header>

    <main>
    <?php if (isset($_SESSION['loggedin'])) { ?>

        <section>
            <h1><?php echo $_SESSION['clientData']['clientFirstname'] . ' ' . $_SESSION['clientData']['clientLastname'] ?></h1>
            <?php if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                // unset message after displaying it
                unset($_SESSION['message']);
            } ?>
            <p>You are logged in.</p>
            <ul>
                <li>First name: <?php echo $_SESSION['clientData']['clientFirstname'] ?></li>
                <li>Last name: <?= $_SESSION['clientData']['clientLastname'] ?></li>
                <li>Email: <?= $_SESSION['clientData']['clientEmail'] ?></li>
                <li>User Level: <?= $_SESSION['clientData']['clientLevel'] ?></li>
            </ul>

            <?php
            echo "<p><a href='/acme/accounts?action=modClient&clientId=" . $_SESSION['clientData']['clientId'] . "'>Update Account Information</a></p>";
            if ($_SESSION['clientData']['clientLevel'] > 1) {
                echo "<h1>Administrative Functions</h1>";
                echo "<p>use the link below to manage products.</p>";
                echo '<p><a href="/acme/products/">Products</a></p>';
            }
            ?>

            <?php if (isset($reviewArray) && count($reviewArray)) { ?>
                <h3>Manage Your Product Reviews</h3>
                <div class="userReviewList">
                    <ul>
                        <?php foreach ($reviewArray as $review) { ?>
                            <li><strong><?= $review['invName'] ?></strong> (Reviewed on <?php echo date("d F, Y", strtotime($review['reviewDate'])) ?>):
                                <a href='/acme/reviews?action=mod&reviewId=<?php echo $review['reviewId'] ?>' title='Click to modify'>Edit</a>
                                | <a href='/acme/reviews?action=del&reviewId=<?php echo $review['reviewId'] ?>' title='Click to Confirm Delete'>Delete</a></li>

                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <hr>
        </section>
        <?php } ?>
    </main>

    <footer class="text-center">
        <!-- Footer Text  -->
        <?php include '../common/footer.php'; ?>
    </footer>
</body>

</html>