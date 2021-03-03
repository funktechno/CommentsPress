<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /accounts/');
    // $clientId = $_SESSION['id'];
    // $reviewArray = getUserReviews($clientId);
} else {
    $contactForms = getContactForms();
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
                <h1><?php echo $_SESSION['clientData']['displayName'] ?></h1>
                <?php if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    // unset message after displaying it
                    unset($_SESSION['message']);
                } ?>

                <?php if (isset($contactForms) && count($contactForms)) { ?>
                    <h3>Messages</h3>
                    <div class="userReviewList">
                        <ul>
                            <?php foreach ($contactForms as $review) { ?>
                                <li><strong><?= $review['id'] ?></strong> (Recieved on <?php echo date("d F, Y", strtotime($review['created_at'])) ?>):
                                    <br />
                                    <strong>Email:</strong>
                                    <?= $review['email'] ?>
                                    <br />
                                    <strong>Subject:</strong>
                                    <?= $review['subject'] ?>
                                    <br />

                                    <strong>Message:</strong>
                                    <p>
                                        <?= $review['message'] ?>
                                    </p>
                                </li>

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