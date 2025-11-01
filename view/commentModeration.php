<?php
if (!defined('APP_INIT')) {
    require_once '../library/defaultRouting.php';
}
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
                <h1><?php echo $_SESSION['clientData']['displayName'] ?></h1>
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
                                <li>
                                    <form action="/accounts/?action=moderate" method="post">
                                        <strong><?= $review['id'] ?></strong> (Updated on <?php echo date("d F, Y", strtotime($review['updated_at'])) ?>):
                                        <input type="hidden" name="id" value="<?= $review['id'] ?>" />
                                        <input type="hidden" name="action" value="moderateComment">

                                        <input type="submit" name="approve" class="btn red" name="submit" id="updatebtn" value="Approve">

                                        <br />
                                        <strong>Page:</strong>
                                        <?= $review['slug'] ?>
                                        <br />
                                        <strong>Parent Comment:</strong>
                                        <?= $review['parentId'] ?>
                                        <br />

                                        <strong>Message:</strong>
                                        <p>
                                            <?= $review['commentText'] ?>
                                        </p>
                                    </form>
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