<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /accounts/');
} else {
    $rows = getPages();
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
                    <h3>Pages</h3>
                    <p>Edit, add pages, lock comments or update slug name.</p>
                    <div class="userReviewList">
                        <?php foreach ($rows as $row) { ?>
                            <form action="/accounts/?action=updateConfig" method="post">
                                <div><strong><?= $row['id'] ?></strong> (Created on <?php echo date("d F, Y", strtotime($row['created_at'])) ?>):

                                    <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                                    <br />
                                    <label>Page slug:</label>
                                    <br />
                                    <input name="slug" class="long" type="text" value="<?php echo $row['slug'] ?>" required>
                                    <br />
                                    <label>LockedComments:</label>
                                    <br />
                                    <input name="data" class="long" type="checkbox" value="<?php echo $row['lockedcomments'] ?>">
                                    <input type="hidden" name="action" value="updatePage">
                                    <input type="submit" class="btn red" name="submit" id="updatebtn" value="Update Data">
                                </div>
                            </form>
                        <?php } ?>
                        <form action="/accounts/?action=updateConfig" method="post">
                            <div>
                                <label>Page slug:</label>
                                <br />
                                <input name="slug" class="long" type="text" value="" required>
                                <br />
                                <label>LockedComments:</label>
                                <br />
                                <input name="data" class="long" type="checkbox" value="1">
                                <input type="hidden" name="action" value="addPage">
                                <input type="submit" class="btn red" name="submit" id="updatebtn" value="New Page">
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