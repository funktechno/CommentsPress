<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /accounts/');
} else {
    $rows = getConfig();
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

                <?php if (isset($rows) && count($rows)) { ?>
                    <h3>Config</h3>
                    <div class="userReviewList">
                        <ul>
                            <?php foreach ($rows as $row) { ?>
                                <li><strong><?= $row['id'] ?></strong> (Recieved on <?php echo date("d F, Y", strtotime($row['created_at'])) ?>):
                                    <br />
                                    <strong>Name:</strong>
                                    <?= $row['data'] ?>
                                    <br />
                                    <strong>Data:</strong>
                                    <?= $row['name'] ?>
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