<?php
if (!defined('APP_INIT')) {
    require_once '../library/defaultRouting.php';
}
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
                    <p>Edit and add configuration values. Check docs for what each value does.</p>
                    <div class="userReviewList">
                        <?php foreach ($rows as $row) { ?>
                            <form action="/accounts/?action=updateConfig" method="post">
                                <div><strong><?= $row['id'] ?></strong> (Created on <?php echo date("d F, Y", strtotime($row['created_at'])) ?>):

                                    <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                                    <br />
                                    <label>Name:</label>
                                    <br />
                                    <input name="name" class="long" type="text" value="<?php echo $row['name'] ?>" required>
                                    <br />
                                    <label>Data:</label>
                                    <br />
                                    <input name="data" class="long" type="text" value="<?php echo $row['data'] ?>">
                                    <input type="hidden" name="action" value="updateConfigData">
                                    <input type="submit" class="btn red" name="submit" id="updatebtn" value="Update Data">
                                </div>
                            </form>
                        <?php } ?>
                        <form action="/accounts/?action=updateConfig" method="post">
                            <div>
                                <label>Name:</label>
                                <br />
                                <input name="name" class="long" type="text" value="" required>
                                <br />
                                <label>Data:</label>
                                <br />
                                <input name="data" class="long" type="text" value="">
                                <input type="hidden" name="action" value="addConfigData">
                                <input type="submit" class="btn red" name="submit" id="updatebtn" value="New Data">
                            </div>
                        </form>
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