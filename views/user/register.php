<?php include ROOT . '/views/layouts/header.php'; ?>
<section>
    <h1 class="text-center">Регистрация</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form id="form">

                    <input type="text" id="login" name="login" placeholder="ФИО" class="form-control"><br>
                    <input type="email" id="email" name="email" placeholder="Почта" class="form-control"><br>

                    <select class="form-control" name="region" id="region">
                        <option value='' selected>Выбери меня</option>
                        <? foreach ($regionList as $region): ?>
                            <option value="<?= $region ?>"><?= $region ?></option>
                        <? endforeach ?>
                    </select>
                    <br><br>

                    <select class="form-control" name="city" id="city">
                        <option value='' selected>Выбери меня</option>
                    </select><br>

                    <select class="form-control" name="village" id="village">
                        <option value='' selected>Выбери меня</option>
                    </select><br><br>

                    <button id="submit" class="btn btn-primary">Отправить</button>

                </form>
                <br><br><br>
                <div><span class="info"></span></div>
            </div>
        </div>

    </div>
</section>
<?php include ROOT . '/views/layouts/footer.php'; ?>