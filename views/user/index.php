<?php include ROOT . '/views/layouts/header.php'; ?>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p class="float-left">Таблица с пользователями</p>
                            </div>
                            <div class="card-body">
                                <table class="table-bordered">
                                    <tr>
                                        <th>ФИО</th>
                                        <th>Email</th>
                                        <th>Adress</th>
                                    </tr>
                                    <?php foreach ($usersList as $usersItem):?>
                                    <tr>
                                        <td><?= $usersItem['name'] ?></td>
                                        <td><?= $usersItem['email'] ?></td>
                                        <td><?= $usersItem['ter_address'] ?></td>
                                    </tr>
                                    <? endforeach ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php include ROOT . '/views/layouts/footer.php'; ?>