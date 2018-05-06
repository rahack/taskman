<?php
//print_r($rows);
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tasks').DataTable({
            ordering: true,
            searching: false,
            lengthChange : false,
            pageLength: 3,
            pagingType: 'simple_numbers',
            language: {
                info: "",
                paginate: {
                    previous: '<',
                    next: '>',
                    info: 'dd'
                }
            },
            "columnDefs": [ {
                "targets": [ 2, 3<?php if ($login) : ?>, 5<?php endif;?>],
                "orderable": false
            } ]});

        $('#add-task').on('click', function() {
            $(this).hide();
            $('.form').show();
        });

        $('#preview').on('click', function() {
            $('.preview tbody tr').prepend('<th><img id="preview-image" src=""></th>');
            var input = $('#file').get(0);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            $('.preview tbody tr').prepend('<th>' + $('#text').val() + '</th>');
            $('.preview tbody tr').prepend('<th>' + $('#email').val() + '</th>');
            $('.preview tbody tr').prepend('<th>' + $('#name').val() + '</th>');
            $('.form').hide();
            $('.preview').show();
        });

        $('#back').on('click', function() {
            $('.preview tbody tr').html('');
            $('.form').show();
            $('.preview').hide();
        });

        $('#enter').on('click', function() {
            $(this).hide();
            $('.form-auth').show();
        });
    });
</script>
<div class="container" style="margin-top:10px">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-4 text-center">
            <?php if (!$login) : ?>
                <button type="button" class="btn btn-primary" id="enter">Войти</button>
                <div class="form-container form-auth" style="display:none">
                    <form action="./user/auth" method="post" >
                        <div class="form-group">
                            <label for="name">Логин</label>
                            <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
            <?php else : ?>
                <strong>Здравствуйте, <?php echo $login;?></strong>
                <form action="./user/out" method="post" >
                    <button type="submit" class="btn btn-primary">Выйти</button>
                </form>
            <?php endif; ?>
        </div>
        <div class="col-7"></div>
    </div>
</div>
<div class="container view-tasks">
    <table id="tasks" class="table table-striped table-inverse table-bordered table-hover" cellspacing="0" width="100%">
        <thead> <tr> <th>Имя</th> <th>Email</th> <th>Текст задачи</th> <th>Фото</th> <th>Статус</th><?php if ($login) : ?><td>Действия</td><?php endif;?></tr></thead>
        <tbody>
        <?php for($i = 0; $i < count($rows); $i++) : ?>
            <tr>
                <td><?php echo $rows[$i]['name']; ?></td>
                <td><?php echo $rows[$i]['email']; ?></td>
                <td><?php echo $rows[$i]['text']; ?></td>
                <td>
                    <?php if ($rows[$i]['photo']) : ?>
                        <img src="/uploads/<?php echo $rows[$i]['photo']; ?>" >
                    <?php else: ?>
                        <img src="/uploads/no-image.jpg" >
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($rows[$i]['status'] === '0') : ?>
                        Не выполнено
                    <?php else: ?>
                        Выполнено
                    <?php endif; ?>
                </td>
                <?php if ($login) : ?>
                    <td><a href="./tasks/edit?id=<?php echo $rows[$i]['id']; ?>">Редактировать</a></td>
                <?php endif;?>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>

<div class="container">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-5 text-center">
            <button type="button" class="btn btn-primary" id="add-task">Добавить задачу</button>
            <div class="form-container form" style="display:none">
                <form action="./tasks/add" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Введите имя" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Введите email" required>
                    </div>
                    <div class="form-group">
                        <label for="text">Задача</label>
                        <textarea class="form-control" name="text" id="text" rows="3" placeholder="Введите текст задачи" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">Выберите картинку</label>
                        <input type="file" class="form-control-file" name="file" id="file" aria-describedby="fileHelp" accept="image/x-png,image/gif,image/jpeg">
                        <small id="fileHelp" class="form-text text-muted">Формат фото JPG/GIF/PNG, не более 320х240 пикселей.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" id="save">Сохранить</button>
                    <button type="button" class="btn btn-primary" id="preview">Предварительный просмотр</button>
                </form>
            </div>
            <div class="form-container preview" style="display:none">
                <table id="tasks" class="table table-striped table-inverse table-bordered table-hover" cellspacing="0" width="100%">
                    <tbody><tr></tr></tbody>
                </table>
                <button type="button" class="btn btn-primary" id="back">Назад</button>
            </div>
        </div>
        <div class="col-6"></div>
    </div>
</div>