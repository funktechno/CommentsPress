<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /accounts/');
    // $clientId = $_SESSION['id'];
    // $reviewArray = getUserReviews($clientId);
} else {
    $reviewArray = getUnapprovedReviews();
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

                <?php if (isset($reviewArray) && count($reviewArray)) { ?>
                    <h3>Moderate Comments</h3>
                    <div class="userReviewList">
                        <ul>
                            <?php foreach ($reviewArray as $review) { ?>
                                <li><strong><?= $review['id'] ?></strong> (Updated on <?php echo date("d F, Y", strtotime($review['updated_at'])) ?>):
                                    <a href='/comments?action=approve&reviewId=<?php echo $review['id'] ?>' title='Click to approve'>Approve</a>
                                    <br />
                                    <strong>Page:</strong>
                                    <?= $review['pageId'] ?>
                                    <br/>
                                    <strong>Parent Comment:</strong>
                                    <?= $review['parentId'] ?>
                                    <br/>

                                    <strong>Message:</strong>
                                    <p>
                                        <?= $review['commentText'] ?>
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