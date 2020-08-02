<?php include ROOT . '/views/layouts/header.php'; ?>
 <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <p class="float-left">Карточка пользователя</p>
                        </div>
                        <div class="card-body">
                            <ul>
                                <?php foreach ($userData as $dataItem):?>
                                <li><?= $dataItem ?></li>
                                <? endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>