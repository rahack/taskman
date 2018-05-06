<div class="container">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-5 text-center">
            <div class="form-container form">
                <form action="/tasks/update" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="text">Задача</label>
                        <textarea class="form-control" name="text" id="text" rows="3" placeholder="Введите текст задачи" required><?php echo $row['text']; ?></textarea>
                    </div>
                    <div class="form-check">
                        <input  class="form-check-input" name="status" id="status" type="checkbox" <?php if($row['status'] === '1') { echo 'checked'; };?>>
                        <label class="" for="status">Статус выполнения</label>
                    </div>
                    <button type="submit" class="btn btn-primary" id="save">Сохранить</button>
                </form>
            </div>
        </div>
        <div class="col-6"></div>
    </div>
</div>