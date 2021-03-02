<?php
if (!isset($_SESSION['loggedin'])) {
    // header('location: /acme/');
    $clientId = $_SESSION['id'];
    $reviewArray = getUserReviews($clientId);
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
                <li>Display Name: <?php echo $_SESSION['clientData']['displayName'] ?></li>
                <li>Email: <?= $_SESSION['clientData']['email'] ?></li>
                <li>User Level: <?= $_SESSION['clientData']['clientLevel'] ?></li>
            </ul>

            <?php
            echo "<p><a href='/accounts?action=modClient&clientId=" . $_SESSION['clientData']['clientId'] . "'>Update Account Information</a></p>";
            if ($_SESSION['clientData']['clientLevel'] > 1) {
                echo "<h1>Administrative Functions</h1>";
                echo "<p>use the link below to moderate comments.</p>";
                echo '<p><a href="/comments/?moderate">Moderate</a></p>';
            }
            ?>

            <?php if (isset($reviewArray) && count($reviewArray)) { ?>
                <h3>Manage Your Comments</h3>
                <div class="userReviewList">
                    <ul>
                        <?php foreach ($reviewArray as $review) { ?>
                            <li><strong><?= $review['invName'] ?></strong> (Reviewed on <?php echo date("d F, Y", strtotime($review['reviewDate'])) ?>):
                                <a href='/comments?action=mod&reviewId=<?php echo $review['reviewId'] ?>' title='Click to modify'>Edit</a>
                                | <a href='/comments?action=del&reviewId=<?php echo $review['reviewId'] ?>' title='Click to Confirm Delete'>Delete</a></li>

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